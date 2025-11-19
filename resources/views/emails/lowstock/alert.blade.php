@component('mail::message')
# Low Stock Alert

Product: **{{ $variant->product->name }}**  
Variant: **{{ $variant->name }}**  
Current Stock: **{{ $variant->stock }}**

This product is running low on stock.  
Please restock soon.

Thanks,  
{{ config('app.name') }}
@endcomponent
