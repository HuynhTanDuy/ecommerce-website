@extends('layout')

@section('title', 'My Profile')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Trang chủ</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <a href="{{route('store.my-store')}}">Cửa hàng</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Chi tiết đơn hàng</span>
    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="store-section container">
			<div class="register-info-section">
            <div class="products-header">
                <h1 class="stylish-heading">Chi tiết đơn hàng {{ $order->order_id }}</h1>
            </div>
            <div>
				<div class="label-bold">Tên người đặt: <span class="label">{{ $order->billing_name }}</span></div>
                <div class="label-bold">Số điện thoại: <span class="label">{{ $order->billing_phone }}</span></div>
                <div class="label-bold">Địa chỉ: <span class="label">{{ $order->billing_address }}</span></div>
                <div class="label-bold">Địa chỉ email: <span class="label">{{ $order->billing_email }}</span></div>
                <div class="label-bold">Thành phố: <span class="label">{{ $order->billing_city }}</span></div>
                <div class="label-bold">Mã giảm giá: <span class="label">{{ $order->billing_discount_code }}</span></div>

            </div>

            <div style="margin-top: 50px">
				<table class="table">
					<thead class="thead-dark">
					  <tr >
						<th scope="col">Mã SP</th>
						<th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Thành tiền</th>
					  </tr>
					</thead>
					<tbody>
                        @foreach ($products as $product)
                            <tr style="text-align: center;">
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->order_quantity}}</td>
                                <td>{{presentPrice($product->price)}}</td>
                                <td>{{presentPrice($product->price * $product->order_quantity)}}</td>
                            </tr>
                            
                        @endforeach
                      
					</tbody>
                </table>
            </div>
            <div style="font-size: 32px; text-align: end;">
                {{-- <div class="label-bold" >Giảm giá: <span style="color: #224dea">{{presentPrice($order->billing_discount)}}</span></div> --}}
                <div class="label-bold">Tổng giá: <span style="color: #224dea">{{presentPrice($total)}}</span></div>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
