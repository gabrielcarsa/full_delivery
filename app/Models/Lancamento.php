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

    public function loja(){
        return $this->belongsTo(Loja::class);
    }

    public function usuarioCadastrador()
    {
       return $this->belongsTo(User::class, 'cadastrado_usuario_id');
    }

    public function usuarioAlterador()
    {
       return $this->belongsTo(User::class, 'alterado_usuario_id');
    }

    public function parcela_lancamento(){
        return $this->HasMany(ParcelaLancamento::class);
    }

    public function movimentacao(){
        return $this->hasOne(Movimentacao::class);
    }

}
