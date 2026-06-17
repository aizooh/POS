<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    
public function index()
{
    $accessories = Accessory::where('stock_quantity', '>', 0)->get();
    $services = Service::all();
    $cart = session()->get('cart', []);
    return view('pos.index', compact('accessories', 'services', 'cart'));
}

    public function addItem(Request $request)
    {
        $request->validate([
            'type' => 'required|in:accessory,service',
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        $key = $request->type . '_' . $request->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            if ($request->type === 'accessory') {
                $item = Accessory::findOrFail($request->id);
                $cart[$key] = [
                    'type' => 'accessory',
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'buying_price' => $item->buying_price,
                    'quantity' => $request->quantity,
                    'max_stock' => $item->stock_quantity,
                ];
            } else {
                $item = Service::findOrFail($request->id);
                $cart[$key] = [
                    'type' => 'service',
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'buying_price' => 0,
                    'quantity' => $request->quantity,
                    'max_stock' => 999,
                ];
            }
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
        }
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->key])) {
            $cart[$request->key]['quantity'] = $request->quantity;
        }
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 422);
        }

        $request->validate([
            'payment_method' => 'required|in:cash,card,mpesa',
        ]);

        DB::beginTransaction();

        try {
            // Generate invoice number
            $invoice = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $subtotal = 0;
            $total = 0;
            $items = [];

            foreach ($cart as $key => $item) {
                $subtotal += $item['price'] * $item['quantity'];
                $total += $item['price'] * $item['quantity'];

                if ($item['type'] === 'accessory') {
                    $accessory = Accessory::findOrFail($item['id']);
                    if ($accessory->stock_quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for {$accessory->name}");
                    }
                    $accessory->decrement('stock_quantity', $item['quantity']);
                }

                $items[] = [
                    'item_type' => $item['type'] === 'accessory' ? Accessory::class : Service::class,
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'buying_price' => $item['buying_price'] ?? 0,
                    'subtotal' => $item['price'] * $item['quantity'],
                ];
            }

            // Create sale
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'invoice_number' => $invoice,
                'subtotal' => $subtotal,
                'tax' => 0,
                'discount' => 0,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'sale_date' => now(),
                'notes' => $request->notes ?? null,
            ]);

            // Create sale items
            foreach ($items as $item) {
                SaleItem::create(array_merge($item, ['sale_id' => $sale->id]));
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            // Return receipt view as HTML
            $receipt = view('pos.receipt', compact('sale'))->render();

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'invoice' => $invoice,
                'total' => $total,
                'receipt_html' => $receipt,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function receipt($id)
    {
        $sale = Sale::with('items.item')->findOrFail($id);
        return view('pos.receipt', compact('sale'));
    }
    public function getCart()
{
    return response()->json(['cart' => session()->get('cart', [])]);
}
}