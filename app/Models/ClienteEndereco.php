<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEndereco extends Model
{
    use HasFactory;
    protected $table = 'cliente_endereco';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
