<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePaymentMethods extends Model
{
    use HasFactory;
    protected $table = 'store_payment_methods';
    public $timestamps = false;
    protected $guarded = [];
    
    public function checking_account()
    {
        return $this->belongsTo(CheckingAccounts::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethods::class);
    }
}
