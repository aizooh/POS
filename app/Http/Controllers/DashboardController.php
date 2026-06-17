<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Expense;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Sales summaries
        $todaySales = Sale::whereDate('sale_date', Carbon::today())->sum('total_amount');
        $weekSales = Sale::whereBetween('sale_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_amount');
        $monthSales = Sale::whereMonth('sale_date', Carbon::now()->month)->sum('total_amount');
        $totalSales = Sale::sum('total_amount');

        // Sales count
        $todayCount = Sale::whereDate('sale_date', Carbon::today())->count();

        // Expenses
        $totalExpenses = Expense::sum('amount');
        $monthExpenses = Expense::whereMonth('expense_date', Carbon::now()->month)->sum('amount');

        // Cost of Goods Sold (COGS) - from sale_items
        $cogs = SaleItem::sum('buying_price');
        $monthCogs = SaleItem::whereMonth('created_at', Carbon::now()->month)->sum('buying_price');

        // Net Profit
        $netProfit = $totalSales - $totalExpenses - $cogs;
        $monthNetProfit = $monthSales - $monthExpenses - $monthCogs;

        // Low stock accessories
        $lowStock = Accessory::where('stock_quantity', '<', 5)->get();

        // Top selling items (accessories + services)
        $topItems = DB::table('sale_items')
            ->select('item_type', 'item_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_type', 'item_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // Recent sales
        $recentSales = Sale::with('user')->latest()->limit(10)->get();

        return view('dashboard', compact(
            'todaySales',
            'weekSales',
            'monthSales',
            'totalSales',
            'todayCount',
            'totalExpenses',
            'monthExpenses',
            'cogs',
            'monthCogs',
            'netProfit',
            'monthNetProfit',
            'lowStock',
            'topItems',
            'recentSales'
        ));
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $sales = Sale::with(['items.item', 'user'])
            ->whereBetween('sale_date', [$request->start_date, $request->end_date])
            ->get();

        return response()->json([
            'sales' => $sales,
            'total' => $sales->sum('total_amount'),
            'count' => $sales->count(),
        ]);
    }
}