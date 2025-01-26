<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDeliveries extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'order_deliveries';

    protected $fillable = [];


    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
