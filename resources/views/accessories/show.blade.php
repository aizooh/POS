<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">{{ $accessory->name }}</h2>

                <div class="space-y-3">
                    <p><strong>SKU:</strong> {{ $accessory->sku ?? 'N/A' }}</p>
                    <p><strong>Price:</strong> Ksh.{{ number_format($accessory->price, 2) }}</p>
                    <p><strong>Stock:</strong> {{ $accessory->stock_quantity }}</p>
                    <p><strong>Description:</strong> {{ $accessory->description ?? 'No description' }}</p>
                    <p><strong>Created:</strong> {{ $accessory->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>Last Updated:</strong> {{ $accessory->updated_at->format('Y-m-d H:i') }}</p>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('accessories.edit', $accessory) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                    <a href="{{ route('accessories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>