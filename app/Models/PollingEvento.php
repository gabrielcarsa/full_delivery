<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollingEvento extends Model
{
    use HasFactory;
    protected $table = 'polling_evento';
    protected $guarded = [];

}
