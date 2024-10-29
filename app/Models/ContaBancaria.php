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

    public function movimentacao(){
        return $this->hasMany(Movimentacao::class);
    }

    public function usuarioCadastrador()
    {
       return $this->belongsTo(User::class, 'cadastrado_usuario_id');
    }

    public function usuarioAlterador()
    {
       return $this->belongsTo(User::class, 'alterado_usuario_id');
    }
}
