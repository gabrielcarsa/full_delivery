<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDeliveries extends Model
{
    use HasFactory;
    protected $table = 'store_deliveries';
    protected $guarded = [];
    public $timestamps = false;

    public function store()
    {
       return $this->belongsTo(Stores::class);
    }
 
}
