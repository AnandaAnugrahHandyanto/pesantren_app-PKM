<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\PaymentTransaction;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken(PaymentTransaction $transaction): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->external_id,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->sppBill->siswa->nama_lengkap ?? 'Siswa',
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
