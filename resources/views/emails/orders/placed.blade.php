@component('mail::message')
# Xác nhận đơn hàng

Cảm ơn quý khách đã đặt hàng tại Ecommerce Website.

# THÔNG TIN ĐƠN HÀNG

**Mã đơn hàng:** {{ $order->id }}

**Email:** {{ $order->billing_email }}

**Họ tên Khách hàng:** {{ $order->billing_name }}

**Tổng tiền:** ${{ round($order->billing_total / 100, 2) }}

**Chi tiết đơn hàng**

@foreach ($order->products as $product)
Tên: {{ $product->name }} <br>
Giá: ${{ round($product->price / 100, 2)}} <br>
Số lượng: {{ $product->pivot->quantity }} <br>
@endforeach

Xem thêm tại website của chúng tôi

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go to Website
@endcomponent

Cảm ơn vì đã lựa chọn chúng tôi.

Regards,<br>
{{ config('app.name') }}
@endcomponent
