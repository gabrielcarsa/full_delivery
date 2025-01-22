<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{
   use HasFactory;
   protected $table = 'loja';

   //RELACIONAMENTOS 

   public function usuarioCadastrador()
   {
      return $this->belongsTo(User::class, 'cadastrado_usuario_id');
   }

   public function usuarioAlterador()
   {
      return $this->belongsTo(User::class, 'alterado_usuario_id');
   }

   public function categorias()
   {
      return $this->hasMany(CategoriaProduto::class);
   }

   public function pedidos()
   {
      return $this->hasMany(Pedido::class);
   }

   public function horarios()
   {
      return $this->hasMany(HorarioFuncionamento::class);
   }

   public function cupons()
   {
      return $this->hasMany(Cupom::class);
   }

   public function mesa()
   {
      return $this->hasMany(Mesa::class);
   }

   public function lancamento()
   {
      return $this->hasMany(Lancamento::class);
   }

   public function conta_corrente()
   {
      return $this->hasMany(ContaCorrente::class);
   }

   public function movimentacao()
   {
      return $this->hasMany(Movimentacao::class);
   }
   
   public function ifood_token()
   {
      return $this->HasMany(IfoodToken::class);
   }
   
   public function user_loja()
   {
      return $this->HasMany(UserLoja::class);
   }

   public function forma_pagamento_loja()
   {
      return $this->hasMany(FormaPagamentoLoja::class);
   }

}
