<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaFinanceiro extends Model
{
    use HasFactory;
    protected $table = 'categoria_financeiro';
    protected $guarded = [];

    public function lancamento(){
        return $this->hasMany(Lancamento::class);
    }
}
