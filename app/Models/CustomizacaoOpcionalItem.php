<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizacaoOpcionalItem extends Model
{
    use HasFactory;
    protected $table = 'customizacao_opcional_item';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function customizacao_opcional()
    {
        return $this->belongsTo(CustomizacaoOpcional::class);
    }

    public function opcional_item()
    {
        return $this->belongsTo(OpcionalItem::class);
    }
}
