<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Expense Details</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div><strong>Category:</strong> {{ $expense->category }}</div>
                    <div><strong>Amount:</strong> KSh {{ number_format($expense->amount, 2) }}</div>
                    <div><strong>Date:</strong> {{ $expense->expense_date->format('Y-m-d') }}</div>
                    <div><strong>Payment:</strong> {{ ucfirst($expense->payment_method) }}</div>
                    <div><strong>Description:</strong> {{ $expense->description ?? 'N/A' }}</div>
                    <div><strong>Notes:</strong> {{ $expense->notes ?? 'N/A' }}</div>
                    <div><strong>Recorded by:</strong> {{ $expense->user->name }}</div>
                    <div><strong>Created:</strong> {{ $expense->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('expenses.edit', $expense) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded">Edit</a>
                    <a href="{{ route('expenses.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded ml-2">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>