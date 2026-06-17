<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-blue-500">
                <div class="text-sm text-gray-500">Today's Sales</div>
                <div class="text-2xl font-bold text-blue-600">KSh {{ number_format($todaySales, 2) }}</div>
                <div class="text-sm text-gray-500">{{ $todayCount }} transactions</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-green-500">
                <div class="text-sm text-gray-500">This Week</div>
                <div class="text-2xl font-bold text-green-600">KSh {{ number_format($weekSales, 2) }}</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-yellow-500">
                <div class="text-sm text-gray-500">This Month</div>
                <div class="text-2xl font-bold text-yellow-600">KSh {{ number_format($monthSales, 2) }}</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-purple-500">
                <div class="text-sm text-gray-500">Total Sales</div>
                <div class="text-2xl font-bold text-purple-600">KSh {{ number_format($totalSales, 2) }}</div>
            </div>
        </div>

        <!-- Profit & Expenses Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-red-500">
                <div class="text-sm text-gray-500">Total Expenses</div>
                <div class="text-2xl font-bold text-red-600">KSh {{ number_format($totalExpenses, 2) }}</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-orange-500">
                <div class="text-sm text-gray-500">COGS (All Time)</div>
                <div class="text-2xl font-bold text-orange-600">KSh {{ number_format($cogs, 2) }}</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-green-600">
                <div class="text-sm text-gray-500">Net Profit (All Time)</div>
                <div class="text-2xl font-bold text-green-600">KSh {{ number_format($netProfit, 2) }}</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-green-400">
                <div class="text-sm text-gray-500">This Month Net Profit</div>
                <div class="text-2xl font-bold text-green-500">KSh {{ number_format($monthNetProfit, 2) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Low Stock Alert -->
            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-3">⚠️ Low Stock Alert</h3>
                @if($lowStock->count() > 0)
                    <ul class="space-y-1">
                        @foreach($lowStock as $item)
                            <li class="flex justify-between items-center bg-red-50 p-2 rounded">
                                <span>{{ $item->name }}</span>
                                <span class="font-bold text-red-600">{{ $item->stock_quantity }} left</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-green-600">✅ All items are well stocked!</p>
                @endif
            </div>

            <!-- Top Selling Items -->
            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-3">🏆 Top Selling Items</h3>
                @if($topItems->count() > 0)
                    <ul class="space-y-1">
                        @foreach($topItems as $item)
                            @php
                                $model = $item->item_type === 'App\Models\Accessory' 
                                    ? \App\Models\Accessory::find($item->item_id) 
                                    : \App\Models\Service::find($item->item_id);
                            @endphp
                            @if($model)
                                <li class="flex justify-between items-center border-b py-1">
                                    <span>{{ $model->name }}</span>
                                    <span class="font-bold">{{ $item->total_quantity }} sold</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No sales yet. Start selling!</p>
                @endif
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="mt-6 bg-white shadow rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3">📋 Recent Sales</h3>
            @if($recentSales->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border px-3 py-2 text-left text-sm">Invoice</th>
                                <th class="border px-3 py-2 text-left text-sm">Attendant</th>
                                <th class="border px-3 py-2 text-left text-sm">Amount</th>
                                <th class="border px-3 py-2 text-left text-sm">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                                <tr>
                                    <td class="border px-3 py-2 text-sm">{{ $sale->invoice_number }}</td>
                                    <td class="border px-3 py-2 text-sm">{{ $sale->user->name }}</td>
                                    <td class="border px-3 py-2 text-sm">KSh {{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="border px-3 py-2 text-sm">{{ $sale->sale_date->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No sales recorded yet.</p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('accessories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">+ Add Accessory</a>
            <a href="{{ route('services.create') }}" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold">+ Add Service</a>
            <a href="{{ route('expenses.index') }}" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold">💰 Expenses</a>
            <a href="#" class="bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm font-semibold">🛒 Open POS</a>
            <a href="{{ route('reports') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded text-sm font-semibold">📊 Generate Report</a>
        </div>
    </div>
</x-app-layout>