<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Sale #{{ $sale->invoice_number }}</h2>
                        <a href="{{ route('sales.index') }}" class="text-gray-600 hover:text-gray-900">← Back</a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded">
                        <div><strong>Invoice:</strong> {{ $sale->invoice_number }}</div>
                        <div><strong>Date:</strong> {{ $sale->sale_date->format('Y-m-d H:i') }}</div>
                        <div><strong>Attendant:</strong> {{ $sale->user->name }}</div>
                        <div><strong>Payment Method:</strong> {{ ucfirst($sale->payment_method) }}</div>
                        <div><strong>Status:</strong> {{ ucfirst($sale->payment_status) }}</div>
                        <div><strong>Total:</strong> <span class="font-bold">KSh {{ number_format($sale->total_amount, 2) }}</span></div>
                    </div>

                    <h3 class="text-lg font-semibold mb-3">Items</h3>
                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Item</th>
                                <th class="border px-4 py-2 text-left">Type</th>
                                <th class="border px-4 py-2 text-left">Qty</th>
                                <th class="border px-4 py-2 text-left">Unit Price</th>
                                <th class="border px-4 py-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->item->name ?? 'Deleted' }}</td>
                                <td class="border px-4 py-2 capitalize">{{ class_basename($item->item_type) }}</td>
                                <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                <td class="border px-4 py-2">KSh {{ number_format($item->unit_price, 2) }}</td>
                                <td class="border px-4 py-2">KSh {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 text-right font-bold text-lg">
                        Total: KSh {{ number_format($sale->total_amount, 2) }}
                    </div>

                    <div class="mt-6">
                        <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">🖨️ Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>