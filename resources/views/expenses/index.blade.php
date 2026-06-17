<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Expenses</h2>
                        <a href="{{ route('expenses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">+ Add Expense</a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                    @endif

                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Category</th>
                                <th class="border px-4 py-2 text-left">Description</th>
                                <th class="border px-4 py-2 text-left">Amount</th>
                                <th class="border px-4 py-2 text-left">Date</th>
                                <th class="border px-4 py-2 text-left">Payment</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr>
                                <td class="border px-4 py-2">{{ $expense->category }}</td>
                                <td class="border px-4 py-2">{{ $expense->description ?? '-' }}</td>
                                <td class="border px-4 py-2">KSh {{ number_format($expense->amount, 2) }}</td>
                                <td class="border px-4 py-2">{{ $expense->expense_date->format('Y-m-d') }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($expense->payment_method) }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('expenses.show', $expense) }}" class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('expenses.edit', $expense) }}" class="text-yellow-600 hover:underline ml-2">Edit</a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-block ml-2">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this expense?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="border px-4 py-2 text-center">No expenses recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $expenses->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>