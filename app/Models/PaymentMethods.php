<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;
    protected $table = 'payment_methods';
    public $timestamps = false;

    public function store_payment_methods()
    {
        return $this->hasMany(StorePaymentMethods::class);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}
