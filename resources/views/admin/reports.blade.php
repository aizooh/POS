<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">📊 Sales Reports</h2>

                    <form id="reportForm" class="mb-6 flex flex-wrap gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium mb-1">Start Date</label>
                            <input type="date" id="start_date" class="border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">End Date</label>
                            <input type="date" id="end_date" class="border rounded px-3 py-2" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Generate Report</button>
                        <button type="button" id="exportCSV" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">📥 Export CSV</button>
                    </form>

                    <div id="reportResults" class="hidden">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-gray-50 p-4 rounded">
                                <span class="text-sm text-gray-500">Total Sales</span>
                                <div class="text-2xl font-bold" id="totalAmount">KSh 0.00</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded">
                                <span class="text-sm text-gray-500">Number of Sales</span>
                                <div class="text-2xl font-bold" id="totalCount">0</div>
                            </div>
                        </div>
                        <div id="salesTable"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (!startDate || !endDate) {
                alert('Please select both start and end dates.');
                return;
            }

            fetch('{{ route('reports.generate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ start_date: startDate, end_date: endDate })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('reportResults').classList.remove('hidden');
                document.getElementById('totalAmount').textContent = 'KSh ' + data.total.toFixed(2);
                document.getElementById('totalCount').textContent = data.count;

                let html = '<table class="min-w-full border"><thead><tr class="bg-gray-100">';
                html += '<th class="border px-4 py-2">Invoice</th>';
                html += '<th class="border px-4 py-2">Attendant</th>';
                html += '<th class="border px-4 py-2">Amount</th>';
                html += '<th class="border px-4 py-2">Date</th>';
                html += '</tr></thead><tbody>';

                data.sales.forEach(sale => {
                    html += `<tr>
                        <td class="border px-4 py-2">${sale.invoice_number}</td>
                        <td class="border px-4 py-2">${sale.user.name}</td>
                        <td class="border px-4 py-2">KSh ${parseFloat(sale.total_amount).toFixed(2)}</td>
                        <td class="border px-4 py-2">${sale.sale_date}</td>
                    </tr>`;
                });

                html += '</tbody></table>';
                document.getElementById('salesTable').innerHTML = html;
            });
        });
    </script>
    @endpush
</x-app-layout>