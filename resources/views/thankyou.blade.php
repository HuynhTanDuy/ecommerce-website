@extends('layout')

@section('title', 'Thank You')

@section('extra-css')

@endsection

@section('body-class', 'sticky-footer')

@section('content')

   <div class="thank-you-section">
       <h1>Cảm ơn quý khách <br> đã đặt hàng!</h1>
       <p>Email xác nhận đơn hàng đã được gửi tới email của quý khách</p>
       <div class="spacer"></div>
       <div>
           <a href="{{ url('/') }}" class="button">Trang chủ</a>
       </div>
   </div>




@endsection
