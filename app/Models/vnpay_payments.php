<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vnpay_payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'vnp_Amount',
        'vnp_BankCode',
        'vnp_CardType',
        'vnp_OrderInfo',
        'vnp_PayDate',
        'vnp_ResponseCode',
        'vnp_TmnCode',
        'vnp_TransactionNo',
        'vnp_TransactionStatus',
        'vnp_TxnRef',
        'vnp_SecureHash',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'vnp_TxnRef');
    }
}
