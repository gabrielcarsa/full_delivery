<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreUsers extends Model
{
   use HasFactory;
   protected $table = 'store_users';
   protected $guarded = [];

   public function store()
   {
      return $this->belongsTo(Stores::class);
   }

   public function user()
   {
      return $this->belongsTo(Users::class);
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
