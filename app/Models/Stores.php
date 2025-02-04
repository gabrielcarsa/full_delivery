<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
   use HasFactory;
   protected $table = 'stores';

   //RELACIONAMENTOS 
   public function created_by_user()
   {
      return $this->belongsTo(Users::class, 'created_by_user_id');
   }

   public function updated_by_user()
   {
      return $this->belongsTo(Users::class, 'updated_by_user_id');
   }
   
   public function store_deliveries()
   {
      return $this->hasOne(StoreDeliveries::class);
   }

   public function ifood_tokens()
   {
      return $this->HasMany(IfoodTokens::class, 'store_id');
   }
   
   public function product_categories()
   {
      return $this->hasMany(ProductCategories::class);
   }

   public function store_opening_hours()
   {
      return $this->hasMany(StoreOpeningHours::class);
   }

   public function customers()
   {
      return $this->hasMany(Customer::class);
   }

   public function financial_categories()
   {
      return $this->hasMany(FinancialCategories::class);
   }

   public function orders()
   {
      return $this->hasMany(Orders::class);
   }

   public function store_coupons()
   {
      return $this->hasMany(StoreCoupons::class);
   }

   public function store_tables()
   {
      return $this->hasMany(StoreTables::class);
   }

   public function financial_transactions()
   {
      return $this->hasMany(FinancialTransactions::class);
   }

   public function checking_accounts()
   {
      return $this->hasMany(CheckingAccounts::class);
   }

   public function financial_movements()
   {
      return $this->hasMany(FinancialMovements::class);
   }

   public function store_users()
   {
      return $this->HasMany(StoreUsers::class);
   }

   public function store_payment_methods()
   {
      return $this->hasMany(StorePaymentMethods::class);
   }

}
