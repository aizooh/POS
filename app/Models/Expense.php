<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'description',
        'amount',
        'expense_date',
        'payment_method',
        'receipt',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get total expenses for a given period
    public static function totalForPeriod($startDate, $endDate)
    {
        return self::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');
    }
}