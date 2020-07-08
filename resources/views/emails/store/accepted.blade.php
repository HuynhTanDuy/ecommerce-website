@component('mail::message')
# Xác nhận đăng ký cửa hàng thành công

Cảm ơn quý khách đã đăng ký mở cửa hàng tại Ecommerce Website.

Xem thêm tại website của chúng tôi

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go to Website
@endcomponent

Cảm ơn vì đã lựa chọn chúng tôi.

Regards,<br>
{{ config('app.name') }}
@endcomponent
