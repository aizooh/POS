<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Accessories Inventory</h2>
                        <a href="{{ route('accessories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded border border-blue-800 shadow-md">
                            + Add Accessory
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">SKU</th>
                                <th class="border px-4 py-2 text-left">Selling Price</th>
                                <th class="border px-4 py-2 text-left">Buying Price</th>
                                <th class="border px-4 py-2 text-left">Profit</th>
                                <th class="border px-4 py-2 text-left">Stock</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accessories as $accessory)
                            <tr class="{{ $accessory->stock_quantity < 5 ? 'bg-red-100' : '' }}">
                                <td class="border px-4 py-2">{{ $accessory->name }}</td>
                                <td class="border px-4 py-2">{{ $accessory->sku ?? '-' }}</td>
                                <td class="border px-4 py-2">KSh {{ number_format($accessory->price, 2) }}</td>
                                <td class="border px-4 py-2">KSh {{ number_format($accessory->buying_price, 2) }}</td>
                                <td class="border px-4 py-2">KSh {{ number_format($accessory->price - $accessory->buying_price, 2) }}</td>
                                <td class="border px-4 py-2">{{ $accessory->stock_quantity }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('accessories.show', $accessory) }}" class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('accessories.edit', $accessory) }}" class="text-yellow-600 hover:underline ml-2">Edit</a>
                                    <form action="{{ route('accessories.destroy', $accessory) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this accessory? This action cannot be undone.')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="border px-4 py-2 text-center">No accessories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $accessories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>