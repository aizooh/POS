<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        body { font-family: monospace; font-size: 14px; padding: 20px; max-width: 300px; margin: 0 auto; }
        .header { text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .header h2 { margin: 0; }
        .header p { margin: 4px 0; }
        .items { margin: 15px 0; }
        .item { display: flex; justify-content: space-between; padding: 2px 0; }
        .total { border-top: 1px solid #000; padding-top: 10px; margin-top: 10px; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>MAMICAR</h2>
        <p>Tel: 0712 345 678</p>
        <p>Email: mamicar@gmail.com</p>
        <p>Date: {{ $sale->sale_date->format('Y-m-d H:i') }}</p>
        <p>Invoice: {{ $sale->invoice_number }}</p>
        <p>Attendant: {{ $sale->user->name }}</p>
    </div>

    <div class="items">
        @foreach($sale->items as $item)
        <div class="item">
            <span>{{ $item->item->name }} x {{ $item->quantity }}</span>
            <span>KSh {{ number_format($item->subtotal, 2) }}</span>
        </div>
        @endforeach
    </div>

    <div class="total">
        <div class="item"><span>Subtotal</span><span>KSh {{ number_format($sale->subtotal, 2) }}</span></div>
        @if($sale->tax > 0)
        <div class="item"><span>Tax</span><span>KSh {{ number_format($sale->tax, 2) }}</span></div>
        @endif
        @if($sale->discount > 0)
        <div class="item"><span>Discount</span><span>-KSh {{ number_format($sale->discount, 2) }}</span></div>
        @endif
        <div class="item"><span>Total</span><span>KSh {{ number_format($sale->total_amount, 2) }}</span></div>
        <div class="item"><span>Payment</span><span>{{ ucfirst($sale->payment_method) }}</span></div>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>Goods sold are not returnable.</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>