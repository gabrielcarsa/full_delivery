<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioFuncionamento extends Model
{
    use HasFactory;
    protected $table = 'horario_funcionamento';

      //RELACIONAMENTOS
    
      public function loja()
      {
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

}
