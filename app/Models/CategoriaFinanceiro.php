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

    public function loja()
    {
       return $this->belongsTo(Loja::class);
    }

    public function usuario_cadastrador()
    {
       return $this->belongsTo(User::class, 'cadastrado_usuario_id');
    }

    public function usuario_alterador()
    {
       return $this->belongsTo(User::class, 'alterado_usuario_id');
    }
}
