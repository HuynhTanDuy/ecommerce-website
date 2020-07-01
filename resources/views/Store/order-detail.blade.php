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
        <div class="products-section container">
            <div class="sidebar">

                <ul>
                <!-- <li class="active"><a href="{{ route('users.edit') }}"></a></li>
                <li><a href="{{ route('orders.index') }}"></a></li> -->
                </ul>
			</div> <!-- end sidebar -->
			<div class="register-info-section">
            <div class="products-header">
                <h1 class="stylish-heading">Chi tiết đơn hàng {{ $order->order_id }}</h1>
            </div>
            <div>
				<div class="label-bold">Tên người đặt: <span class="label">{{ $order->billing_name }}</span></div>
                <div class="label-bold">Số điện thoại: <span class="label">{{ $order->billing_phone }}</span></div>
                <div class="label-bold">Địa chỉ email: <span class="label">{{ $order->billing_email }}</span></div>
                <div class="label-bold">Mã sản phẩm: <span class="label">{{ $order->product_id }}</span></div>
                <div class="label-bold">Tên sản phẩm: <span class="label">{{ $order->name }}</span></div>
                <div class="label-bold">Số lượng: <span class="label">{{ $order->quantity }}</span></div>
                <div class="label-bold">Đơn giá: <span class="label">{{ $order->price }}</span></div>
                <div class="label-bold">Giảm giá: <span class="label">{{ $order->billing_discount }}</span></div>
                <div class="label-bold">Tổng giá: <span class="label">{{ $order->billing_total }}</span></div>
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
