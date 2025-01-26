<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialMovements extends Model
{
    use HasFactory;
    protected $table = "financial_movements";
    protected $guarded = [];

    public function checking_account(){
        return $this->belongsTo(CheckingAccounts::class);
    }

    public function financial_transaction(){
        return $this->belongsTo(FinancialTransactions::class);
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

    public function financial_transaction_installment(){
        return $this->belongsTo(FinancialTransactionInstallments::class);
    }
}
