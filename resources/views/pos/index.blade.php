<x-app-layout>
    <div class="py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Products (2/3) -->
            <div class="lg:w-2/3 bg-white shadow rounded-lg p-4">
                <h2 class="text-2xl font-bold mb-4">Point of Sale</h2>

                <!-- Tabs -->
                <div x-data="{ tab: 'accessories' }">
                    <div class="flex border-b mb-4">
                        <button @click="tab = 'accessories'" 
                                :class="{'border-blue-500 text-blue-600': tab === 'accessories'}"
                                class="px-4 py-2 border-b-2 border-transparent hover:text-blue-600 font-medium">
                            Accessories
                        </button>
                        <button @click="tab = 'services'" 
                                :class="{'border-blue-500 text-blue-600': tab === 'services'}"
                                class="px-4 py-2 border-b-2 border-transparent hover:text-blue-600 font-medium">
                            Services
                        </button>
                    </div>

                    <!-- Accessories List -->
                    <div x-show="tab === 'accessories'" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($accessories as $item)
                        <div class="border rounded-lg p-3 hover:shadow-lg transition">
                            <div class="font-bold text-lg">{{ $item->name }}</div>
                            <div class="text-sm text-gray-600">KSh {{ number_format($item->price, 2) }}</div>
                            <div class="text-xs text-gray-500 mb-2">Stock: {{ $item->stock_quantity }}</div>
                            <button @click="$store.cart.addItem('accessory', {{ $item->id }}, '{{ addslashes($item->name) }}', {{ (float) $item->price }}, {{ (float) ($item->buying_price ?? 0) }}, {{ $item->stock_quantity }})" 
                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-2 rounded">
                                ➕ Add to Cart
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <!-- Services List -->
                    <div x-show="tab === 'services'" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($services as $item)
                        <div class="border rounded-lg p-3 hover:shadow-lg transition">
                            <div class="font-bold text-lg">{{ $item->name }}</div>
                            <div class="text-sm text-gray-600">KSh {{ number_format($item->price, 2) }}</div>
                            <div class="text-xs text-gray-500 mb-2">Duration: {{ $item->duration_minutes ?? 'N/A' }}</div>
                            <button @click="$store.cart.addItem('service', {{ $item->id }}, '{{ addslashes($item->name) }}', {{ (float) $item->price }}, 0, 999)" 
                                    class="w-full bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-1 px-2 rounded">
                                ➕ Add to Cart
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart (1/3) -->
            <div class="lg:w-1/3 bg-white shadow rounded-lg p-4 sticky top-6 h-[calc(100vh-8rem)] flex flex-col"
                 x-data>
                <h3 class="text-xl font-bold border-b pb-2 mb-2">🛒 Cart</h3>
                <div class="flex-1 overflow-y-auto space-y-2">
                    <template x-for="(item, key) in $store.cart.items" :key="key">
                        <div class="flex justify-between items-center border-b pb-1 text-sm">
                            <div>
                                <div class="font-semibold" x-text="item.name"></div>
                                <div>KSh <span x-text="item.price.toFixed(2)"></span> x <span x-text="item.quantity"></span></div>
                            </div>
                            <button @click="$store.cart.removeItem(key)" class="text-red-500 hover:text-red-700">✕</button>
                        </div>
                    </template>
                    <p x-show="Object.keys($store.cart.items).length === 0" class="text-gray-500 text-center py-8">Cart is empty</p>
                </div>
                <div class="border-t pt-2">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total:</span>
                        <span>KSh <span x-text="$store.cart.total.toFixed(2)"></span></span>
                    </div>
                    <div class="mt-2">
                        <select id="payment_method" class="w-full border rounded px-2 py-1 text-sm">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="mpesa">M-PESA</option>
                        </select>
                        <button @click="$store.cart.checkout()" 
                                class="mt-2 w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            ✅ Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Store Definition -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                items: @json($cart ?? []),
                total: 0,

                init() {
                    // Convert prices to numbers
                    for (let key in this.items) {
                        if (this.items[key].price) this.items[key].price = parseFloat(this.items[key].price);
                        if (this.items[key].buying_price) this.items[key].buying_price = parseFloat(this.items[key].buying_price);
                        if (this.items[key].quantity) this.items[key].quantity = parseInt(this.items[key].quantity, 10);
                    }
                    this.calcTotal();
                    console.log('Cart store initialized with:', this.items);
                },

                calcTotal() {
                    this.total = Object.values(this.items).reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                addItem(type, id, name, price, buying_price, max_stock) {
                    const key = type + '_' + id;
                    const currentQty = this.items[key] ? this.items[key].quantity : 0;
                    const newQty = currentQty + 1;
                    if (newQty > max_stock) {
                        alert('Not enough stock.');
                        return;
                    }
                    const newItems = { ...this.items };
                    if (newItems[key]) {
                        newItems[key].quantity = newQty;
                    } else {
                        newItems[key] = {
                            type: type,
                            id: id,
                            name: name,
                            price: parseFloat(price),
                            buying_price: parseFloat(buying_price),
                            quantity: 1,
                            max_stock: max_stock,
                        };
                    }
                    this.items = newItems;
                    this.calcTotal();

                    // Sync with server
                    fetch('{{ route('pos.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ type: type, id: id, quantity: 1 })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Error adding item. Reverting.');
                            const revertItems = { ...this.items };
                            delete revertItems[key];
                            this.items = revertItems;
                            this.calcTotal();
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Network error.');
                    });
                },

                removeItem(key) {
                    if (confirm('Remove this item from cart?')) {
                        const newItems = { ...this.items };
                        delete newItems[key];
                        this.items = newItems;
                        this.calcTotal();
                        fetch('{{ route('pos.remove') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ key: key })
                        });
                    }
                },

                checkout() {
                    if (Object.keys(this.items).length === 0) {
                        alert('Cart is empty.');
                        return;
                    }
                    const method = document.getElementById('payment_method').value;
                    if (!confirm(`Proceed with checkout? Total: KSh ${this.total.toFixed(2)}`)) return;

                    fetch('{{ route('pos.checkout') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ payment_method: method })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const receiptWindow = window.open('', '_blank', 'width=400,height=600');
                            receiptWindow.document.write(data.receipt_html);
                            receiptWindow.document.close();
                            receiptWindow.print();
                            this.items = {};
                            this.calcTotal();
                            alert('Sale completed! Invoice: ' + data.invoice);
                        } else {
                            alert('Error: ' + data.error);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Checkout failed.');
                    });
                }
            });

            // Initialize the store
            Alpine.store('cart').init();
        });
    </script>
</x-app-layout>