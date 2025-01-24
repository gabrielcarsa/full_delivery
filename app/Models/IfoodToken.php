<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IfoodToken extends Model
{
    use HasFactory;
    protected $table = 'ifood_token';

    protected $fillable = ['access_token', 'expires_at', 'refresh_token', 'loja_id'];
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belogsTo(Store::class);
    }
}
