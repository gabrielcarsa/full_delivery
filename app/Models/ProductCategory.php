<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
    use HasFactory;
    protected $table = 'categoria_produto';
    protected $guarded = [];

    //RELACIONAMENTOS
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function created_by_user()
    {
       return $this->belongsTo(User::class, 'created_by_user_id');
    }
 
    public function updated_by_user()
    {
       return $this->belongsTo(User::class, 'updated_by_user_id');
    }
    
    public function produto()
    {
        return $this->hasMany(Produto::class);
    }
}
