@component('mail::message')
# Order Status Updated

Hi {{ $order->user->name }},

Your order **#{{ $order->id }}** status has been updated.

### Previous Status: {{ ucfirst($oldStatus) }}
### New Status: {{ ucfirst($newStatus) }}

@component('mail::button', ['url' => 'https://your-domain.com/orders/'.$order->id])
View Your Order
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
