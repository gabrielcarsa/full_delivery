<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelaLancamento extends Model
{
    use HasFactory;
    protected $table = 'parcela_lancamento';
    protected $guarded = [];

    public function lancamento(){
        return $this->belongsTo(Lancamento::class);
    }
}
