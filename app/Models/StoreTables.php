<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTables extends Model
{
   use HasFactory;
   public $timestamps = false;
   protected $table = 'store_tables';

   public function store()
   {
      return $this->belongsTo(Stores::class);
   }

   public function orders()
   {
      return $this->hasMany(Orders::class);
   }
}
