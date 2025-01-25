<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCoupons extends Model
{
   use HasFactory;
   protected $table = 'store_coupons';

   public function created_by_user()
   {
      return $this->belongsTo(Users::class, 'created_by_user_id');
   }

   public function updated_by_user()
   {
      return $this->belongsTo(Users::class, 'updated_by_user_id');
   }
   
   public function store()
   {
      return $this->belongsTo(Stores::class);
   }

   public function store_coupon_uses()
   {
      return $this->hasMany(StoreCouponUses::class);
   }
}
