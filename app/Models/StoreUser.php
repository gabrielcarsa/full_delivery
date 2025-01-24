<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreUser extends Model
{
   use HasFactory;
   protected $table = 'store_user';
   protected $guarded = [];

   public function store()
   {
      return $this->belongsTo(Store::class);
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function created_by_user()
   {
      return $this->belongsTo(User::class, 'created_by_user_id');
   }

   public function updated_by_user()
   {
      return $this->belongsTo(User::class, 'updated_by_user_id');
   }
 
}
