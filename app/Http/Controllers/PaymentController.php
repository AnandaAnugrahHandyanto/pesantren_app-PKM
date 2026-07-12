<?php

namespace App\Http\Controllers;

use App\Models\SppBill;
use App\Models\PaymentTransaction;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function checkout(SppBill $sppBill, PaymentService $service): JsonResponse
    {
        // 4. Otorisasi
        $user = Auth::user();
        if ($user->role !== 'admin' && ($user->siswa_id !== $sppBill->siswa_id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 3. Pastikan hanya tagihan SPP yang belum lunas
        if ($sppBill->status === 'lunas') {
            return response()->json(['message' => 'Tagihan sudah lunas.'], 400);
        }

        try {
            // 1 & 5. Bungkus dengan DB transaction & lockForUpdate untuk cegah race condition
            return DB::transaction(function () use ($sppBill, $service) {
                $transaction = PaymentTransaction::where('spp_bill_id', $sppBill->id)
                    ->where('status', 'pending')
                    ->where(function ($query) {
                        $query->whereNull('expired_at')
                              ->orWhere('expired_at', '>', now());
                    })
                    ->lockForUpdate()
                    ->first();

                if (!$transaction) {
                    $transaction = PaymentTransaction::create([
                        'spp_bill_id' => $sppBill->id,
                        'external_id' => 'SPP-' . $sppBill->id . '-' . bin2hex(random_bytes(4)),
                        'amount' => $sppBill->jumlah,
                        'status' => 'pending',
                        'currency' => 'IDR',
                    ]);
                }

                if (!$transaction->snap_token) {
                    // 2. Try-catch untuk error dari PaymentService (Midtrans)
                    $transaction->snap_token = $service->getSnapToken($transaction);
                    $transaction->save();
                }

                return response()->json([
                    'snap_token' => $transaction->snap_token,
                    'external_id' => $transaction->external_id
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Payment Checkout Failed: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memproses pembayaran. Silakan coba lagi.'], 500);
        }
    }
}
