<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\SppBill;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function checkout(SppBill $sppBill, PaymentService $service): JsonResponse
    {
        $user = Auth::user();
        if ($user->role !== 'siswa' || $user->siswa_id !== $sppBill->siswa_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($sppBill->status === 'lunas') {
            return response()->json(['message' => 'Tagihan sudah lunas.'], 400);
        }

        try {
            return DB::transaction(function () use ($sppBill, $service) {
                // Cari transaksi pending yang belum expired
                $transaction = PaymentTransaction::where('spp_bill_id', $sppBill->id)
                    ->where('status', 'pending')
                    ->where(function ($query) {
                        $query->whereNull('expired_at')
                            ->orWhere('expired_at', '>', now());
                    })
                    ->lockForUpdate()
                    ->first();

                // Jika belum ada, buat baru
                if (! $transaction) {
                    $transaction = PaymentTransaction::create([
                        'spp_bill_id' => $sppBill->id,
                        'external_id' => 'SPP-'.$sppBill->id.'-'.bin2hex(random_bytes(4)),
                        'amount' => $sppBill->jumlah,
                        'status' => 'pending',
                        'currency' => 'IDR',
                        'expired_at' => now()->addHours(24), // Set expired 24 jam
                    ]);
                }

                // Jika belum ada snap_token, generate
                if (! $transaction->snap_token) {
                    $transaction->snap_token = $service->getSnapToken($transaction);
                    $transaction->save();
                    Log::info('Snap token generated', ['transaction_id' => $transaction->id, 'order_id' => $transaction->external_id]);
                }

                Log::info('Checkout successful', ['transaction_id' => $transaction->id, 'order_id' => $transaction->external_id]);

                return response()->json([
                    'snap_token' => $transaction->snap_token,
                    'external_id' => $transaction->external_id,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Payment Checkout Failed: '.$e->getMessage());

            return response()->json(['message' => 'Gagal memproses pembayaran. Silakan coba lagi.'], 500);
        }
    }
}
