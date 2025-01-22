<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaCorrente extends Model
{
   use HasFactory;
   protected $table = 'conta_corrente';
   protected $guarded = [];

   public function movimentacao(){
      return $this->hasMany(Movimentacao::class);
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

   public function saldo(){
      return $this->hasMany(Saldo::class);
   }

   public function forma_pagamento_loja(){
      return $this->hasMany(FormaPagamentoLoja::class);
   }
}
