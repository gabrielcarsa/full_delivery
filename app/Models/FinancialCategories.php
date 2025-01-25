<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialCategories extends Model
{
   use HasFactory;
   protected $table = 'financial_categories';
   protected $guarded = [];

   public function financial_transactions(){
      return $this->hasMany(FinancialTransactions::class);
   }

   public function stores()
   {
      return $this->belongsTo(Loja::class);
   }

   public function created_by_user()
   {
      return $this->belongsTo(Users::class, 'created_by_user_id');
   }

   public function updated_by_user()
   {
      return $this->belongsTo(Users::class, 'updated_by_user_id');
   }
}
