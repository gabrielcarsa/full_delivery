<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldo';
    protected $guarded = [];

    public function conta_corrente()
    {
        return $this->belongsTo(ContaCorrente::class);
    }
}
