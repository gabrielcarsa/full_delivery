<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;
    protected $table = 'restaurante';

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
 
}
