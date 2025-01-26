<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckingAccountBalances extends Model
{
    use HasFactory;
    protected $table = 'checking_account_balances';
    protected $guarded = [];

    public function checking_account()
    {
        return $this->belongsTo(CheckingAccount::class);
    }
}
