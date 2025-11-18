<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>
<h2>Invoice #{{ $order->id }}</h2>
<p>Customer: {{ $order->user->name }}</p>
<p>Date: {{ $order->created_at->format('d M Y') }}</p>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Variant</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->variant->variant_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->quantity * $item->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: {{ $order->total_amount }} BDT</h3>

</body>
</html>
