<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoja extends Model
{
    use HasFactory;
    protected $table = 'user_loja';
    protected $guarded = [];

    public function loja()
    {
       return $this->belongsTo(Loja::class);
    }
    public function user()
    {
       return $this->belongsTo(User::class);
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
