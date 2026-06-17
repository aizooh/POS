<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Sales History</h2>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('sales.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium mb-1">From</label>
                            <input type="date" name="from" value="{{ request('from') }}" class="border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">To</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Payment</label>
                            <select name="payment_method" class="border rounded px-3 py-2">
                                <option value="">All</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="mpesa" {{ request('payment_method') == 'mpesa' ? 'selected' : '' }}>M-PESA</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Filter</button>
                        <a href="{{ route('sales.index') }}" class="text-gray-600 hover:text-gray-900 py-2">Clear</a>
                    </form>

                    @if($sales->count() > 0)
                        <table class="min-w-full border">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 py-2 text-left">Invoice</th>
                                    <th class="border px-4 py-2 text-left">Attendant</th>
                                    <th class="border px-4 py-2 text-left">Total</th>
                                    <th class="border px-4 py-2 text-left">Payment</th>
                                    <th class="border px-4 py-2 text-left">Date</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                <tr>
                                    <td class="border px-4 py-2">{{ $sale->invoice_number }}</td>
                                    <td class="border px-4 py-2">{{ $sale->user->name }}</td>
                                    <td class="border px-4 py-2">KSh {{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="border px-4 py-2 capitalize">{{ $sale->payment_method }}</td>
                                    <td class="border px-4 py-2">{{ $sale->sale_date->format('Y-m-d H:i') }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $sales->links() }}</div>
                    @else
                        <p class="text-gray-500 text-center py-8">No sales found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>