<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'first_name', 'last_name', 'address', 'apartment', 'city',
        'postal_code', 'country', 'subtotal', 'shipping', 'total',
        'payment_method', 'payment_status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
