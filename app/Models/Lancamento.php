<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;
    protected $table = 'lancamento';
    protected $guarded = [];

    public function categoria_financeiro(){
        return $this->belongsTo(CategoriaFinanceiro::class);
    }

    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
