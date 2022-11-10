<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['customer_id', 'amount', 'terms', 'status'];

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function customer(){
        return $this->hasOne('App\Models\User','id','customer_id');
    }

    public function terms(){
        return $this->hasMany('App\Models\LoanTerm','loan_id','id');
    }
}
