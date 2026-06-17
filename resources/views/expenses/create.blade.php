<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Add Expense</h2>
                    <form action="{{ route('expenses.store') }}" method="POST" class="max-w-lg">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Category *</label>
                            <input type="text" name="category" value="{{ old('category') }}" class="w-full border rounded px-3 py-2" required>
                            @error('category') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Description</label>
                            <textarea name="description" rows="2" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Amount *</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Date *</label>
                            <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Payment Method *</label>
                            <select name="payment_method" class="w-full border rounded px-3 py-2" required>
                                <option value="cash" {{ old('payment_method')=='cash'?'selected':'' }}>Cash</option>
                                <option value="bank" {{ old('payment_method')=='bank'?'selected':'' }}>Bank Transfer</option>
                                <option value="mpesa" {{ old('payment_method')=='mpesa'?'selected':'' }}>M-PESA</option>
                                <option value="card" {{ old('payment_method')=='card'?'selected':'' }}>Card</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Notes</label>
                            <textarea name="notes" rows="2" class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded border border-green-800">Save Expense</button>
                        <a href="{{ route('expenses.index') }}" class="ml-2 text-gray-600">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>