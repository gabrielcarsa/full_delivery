<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePollingEvents extends Model
{
    use HasFactory;
    protected $table = 'store_polling_events';
    protected $guarded = [];

}
