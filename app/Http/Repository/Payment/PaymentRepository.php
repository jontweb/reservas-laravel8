<?php

namespace App\Http\Repository\Payment;

use App\Models\Payment\CmnPaymentType;

class PaymentRepository
{

    public function getPaymentType()
    {
        return CmnPaymentType::where('status', 1)->select('id', 'name')->get();
    }

    public function getPaymentMethod()
    {
        return CmnPaymentType::where('status',1)->select(
            'id',
            'name',
            'type'
        )->get();
    }
}
