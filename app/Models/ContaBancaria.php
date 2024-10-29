<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaBancaria extends Model
{
    use HasFactory;
    protected $table = 'conta_bancaria';
    protected $guarded = [];

    public function lancamento(){
        return $this->hasMany(Lancamento::class);
    }
}
