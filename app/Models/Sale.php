<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'subtotal',
        'tax',
        'discount',
        'total_amount',
        'payment_method',
        'payment_status',
        'sale_date',
        'notes',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}