<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    use HasFactory;
    protected $table = "movimentacao";
    protected $guarded = [];

    public function conta_corrente(){
        return $this->belongsTo(ContaCorrente::class);
    }

    public function lancamento(){
        return $this->belongsTo(Lancamento::class);
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
        return $this->belongsTo(ParcelaLancamento::class);
    }
}
