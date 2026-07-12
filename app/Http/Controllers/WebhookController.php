<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\SppBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Webhook received', $request->all());

        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($request->signature_key !== $hashed) {
            Log::warning('Webhook failed: Invalid signature', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = PaymentTransaction::where('external_id', $request->order_id)->first();

        if (!$transaction) {
            Log::error('Webhook failed: Transaction not found', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Idempotency: Jika sudah lunas, jangan proses ulang
        if ($transaction->status === 'paid') {
            return response()->json(['message' => 'Already processed']);
        }

        $statusMapping = [
            'settlement' => 'paid',
            'capture'    => 'paid',
            'pending'    => 'pending',
            'deny'       => 'failed',
            'failure'    => 'failed',
            'expire'     => 'expired',
            'cancel'     => 'cancelled',
            'refund'     => 'refunded',
        ];

        $newStatus = $statusMapping[$request->transaction_status] ?? 'failed';

        DB::transaction(function () use ($transaction, $newStatus, $request) {
            $transaction->update([
                'status' => $newStatus,
                'paid_at' => ($newStatus === 'paid') ? now() : $transaction->paid_at,
                'metadata' => array_merge($transaction->metadata ?? [], $request->all()),
            ]);

            if ($newStatus === 'paid') {
                $transaction->sppBill->update(['status' => 'lunas', 'paid_at' => now()]);
                Log::info('Webhook processed: Settlement successful', [
                    'order_id' => $request->order_id,
                    'transaction_status' => $request->transaction_status,
                    'payment_type' => $request->payment_type,
                    'gross_amount' => $request->gross_amount
                ]);
            }
        });

        return response()->json(['message' => 'Success']);
    }
}
