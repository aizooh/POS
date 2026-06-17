<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'role:admin']);
    // }

    public function index(Request $request)
    {
        $query = Sale::with('user');

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('sale_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('sale_date', '<=', $request->to);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->latest('sale_date')->paginate(20);

        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load('items.item', 'user');
        return view('sales.show', compact('sale'));
    }
}