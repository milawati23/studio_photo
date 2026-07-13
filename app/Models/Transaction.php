<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'customer_id', 'user_id', 'transaction_date', 
        'total_amount', 'payment_amount', 'change_amount', 'status'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}