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
<p>Customer: {{ $order->user->name ?? 'N/A' }}</p>
<p>Date: {{ optional($order->created_at)->format('d M Y') }}</p>

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
            <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
            <td>{{ $item->variant->attribute ?? 'N/A' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->quantity * $item->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: {{ $order->total }} BDT</h3>

</body>
</html>
