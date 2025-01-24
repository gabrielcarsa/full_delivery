<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
   use HasFactory;
   protected $table = 'store';

   //RELACIONAMENTOS 
   public function created_by_user()
   {
      return $this->belongsTo(User::class, 'created_by_user_id');
   }

   public function updated_by_user()
   {
      return $this->belongsTo(User::class, 'updated_by_user_id');
   }
   
   public function store_delivery()
   {
      return $this->hasOne(StoreDelivery::class);
   }

   public function ifood_token()
   {
      return $this->HasMany(IfoodToken::class);
   }
   
   public function product_category()
   {
      return $this->hasMany(ProductCategory::class);
   }

   public function categoria_financeiro()
   {
      return $this->hasMany(CategoriaFinanceiro::class);
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

   public function user_loja()
   {
      return $this->HasMany(UserLoja::class);
   }

   public function forma_pagamento_loja()
   {
      return $this->hasMany(FormaPagamentoLoja::class);
   }

}
