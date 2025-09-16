<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'date', 'status', 'total_money', 'customer_id', 'address_id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
