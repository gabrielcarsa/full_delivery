<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransactions extends Model
{
    use HasFactory;
    protected $table = 'financial_transactions';
    protected $guarded = [];

    public function financial_category(){
        return $this->belongsTo(FinancialCategories::class);
    }

    public function supplier(){
        return $this->belongsTo(Suppliers::class);
    }

    public function customer(){
        return $this->belongsTo(Customers::class);
    }

    public function store(){
        return $this->belongsTo(Stores::class);
    }

    public function created_by_user()
    {
       return $this->belongsTo(Users::class, 'created_by_user_id');
    }
 
    public function updated_by_user()
    {
       return $this->belongsTo(Users::class, 'updated_by_user_id');
    }

    public function financial_transaction_installments(){
        return $this->HasMany(FinancialTransactionInstallments::class);
    }

    public function financial_movement(){
        return $this->hasOne(FinancialMovements::class);
    }

    public function orders(){
        return $this->HasMany(Orders::class);
    }

}
