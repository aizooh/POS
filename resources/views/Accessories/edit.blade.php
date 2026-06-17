<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">Edit Accessory</h2>

                <form action="{{ route('accessories.update', $accessory) }}" method="POST" class="max-w-lg">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $accessory->name) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $accessory->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Selling Price *</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $accessory->price) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
    <label for="buying_price" class="block text-sm font-medium text-gray-700 mb-1">Buying Price *</label>
    <input type="number" step="0.01" name="buying_price" id="buying_price" value="{{ old('buying_price', $accessory->buying_price) }}" 
           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
    @error('buying_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

                    <div class="mb-4">
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $accessory->stock_quantity) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $accessory->sku) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-black font-bold py-2 px-4 rounded">Update Accessory</button>
                        <a href="{{ route('accessories.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>