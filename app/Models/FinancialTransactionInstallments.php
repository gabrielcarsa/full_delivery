<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransactionInstallments extends Model
{
    use HasFactory;
    protected $table = 'financial_transaction_installments';
    protected $guarded = [];

    public function financial_transaction(){
        return $this->belongsTo(FinancialTransactions::class);
    }

    public function financial_movement(){
        return $this->hasOne(FinancialMovements::class);
    }

    public function created_by_user()
    {
       return $this->belongsTo(Users::class, 'created_by_user_id');
    }
 
    public function updated_by_user()
    {
       return $this->belongsTo(Users::class, 'updated_by_user_id');
    }

    public function marked_down_by_user()
    {
       return $this->belongsTo(Users::class, 'marked_down_by_user_id');
    }
}
