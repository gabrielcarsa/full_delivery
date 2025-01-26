<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $guarded = [];

    public function financial_transactions(){
        return $this->hasMany(FinancialTransactions::class);
    }

    public function store(){
        return $this->belongsTo(Stores::class);
    }
}
