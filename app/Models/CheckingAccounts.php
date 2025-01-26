<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckingAccounts extends Model
{
   use HasFactory;
   protected $table = 'checking_accounts';
   protected $guarded = [];

   public function financial_movements(){
      return $this->hasMany(FinancialMovements::class);
   }

   public function store()
   {
      return $this->belongsTo(Stores::class);
   }

   public function created_by_user()
   {
      return $this->belongsTo(Users::class, 'created_by_user_id');
   }

   public function updated_by_user()
   {
      return $this->belongsTo(Users::class, 'updated_by_user_id');
   }

   public function checking_account_balances(){
      return $this->hasMany(CheckingAccountBalances::class);
   }

   public function store_payment_methods(){
      return $this->hasMany(StorePaymentMethods::class);
   }
}
