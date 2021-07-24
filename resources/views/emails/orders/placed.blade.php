@component('mail::message')
# Order Received

Thanks for your order.

**Order ID** {{ $order->id }}\
**Order Email** {{ $order->billing_email }}\
**Order Name** {{ $order->billing_name }}\
**Order Total** ${{ $order->billing_total }}

**Items Order**

@foreach($order->products as $product)

Product ID: {{ $product->id }}\
Product Name: {{ $product->name }}\
Product price: ${{ $product->parsePrice() }}\
Product Quantity: {{ $product->pivot->quantity }}

@endforeach




@component('mail::button' , ['url' => config('app.url') , 'color' => 'green'])
Go To Website
@endcomponent

@component('mail::panel')
Thanks you agian for choosing us,<br>
{{ config('app.name') }}
@endcomponent

@endcomponent
