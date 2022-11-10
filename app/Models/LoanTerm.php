<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanTerm extends Model
{
    protected $fillable = ['loan_id', 'payment_date', 'amount', 'paid_amount', 'paid_date', 'status'];

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function customer(){
        return $this->hasOne('App\Models\User','id','customer_id');
    }

    public function loan(){
        return $this->hasOne('App\Models\Loan','id','loan_id');
    }
}
