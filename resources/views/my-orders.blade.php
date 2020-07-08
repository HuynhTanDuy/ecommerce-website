@extends('layout')

@section('title', 'Quản lí cửa hàng')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Trang chủ</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <a href="{{route('store.my-store')}}">Cửa hàng</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Lịch sử đặt hàng</span>
    @endcomponent

    <div class="container" style="max-width:1600px">
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
        <div class="store-section container" style="max-width:1200px">
			<div class="register-info-section">
                    <div class="products-header">
                            <h1 class="stylish-heading">Đơn hàng đang giao</h1>
                        </div>
                        <div>
                            <table class="table">
                                <thead class="thead-dark">
                                  <tr >
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Địa chỉ giao</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Mã giảm giá</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Chi tiết</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($orders_delivering as $od)  
                                <tr style="text-align: center;">
                                    <td>{{ $od->id}}</td>
                                    <td>{{ $od->billing_address}}</td>
                                    <td>{{ $od->billing_email}}</td>
                                    <td>{{ $od->billing_phone}}</td>
                                    <td>{{ $od->billing_discount_code}}</td>
                                    <td>{{ $od->created_at}}</td>
                                    <td>{{ $od->billing_total}}</td>
                                    <td style="width: 130px;">
                                        <a id="register" type="submit" class="detail-shop-button" 
                                    href = "{{ route('orders.show', $od->id) }}">Chi tiết</a>
                                    </td>
                                   
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
            <div class="products-header">
                <h1 style="margin-top: 60px; margin-bottom: 0;" class="stylish-heading">Lịch sử đặt hàng</h1>
            </div>
            <div>
				<table class="table">
					<thead class="thead-dark">
					  <tr >
						<th scope="col">Mã đơn hàng</th>
						<th scope="col">Địa chỉ giao</th>
						<th scope="col">Email</th>
						<th scope="col">Số điện thoại</th>
                        <th scope="col">Mã giảm giá</th>
                        <th scope="col">Ngày đặt</th>
                        <th scope="col">Ngày giao</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Chi tiết</th>
					  </tr>
					</thead>
					<tbody>
                    @foreach($orders_finished as $od)  
                    <tr style="text-align: center;">
						<td>{{ $od->id}}</td>
                        <td>{{ $od->billing_address}}</td>
                        <td>{{ $od->billing_email}}</td>
                        <td>{{ $od->billing_phone}}</td>
                        <td>{{ $od->billing_discount_code}}</td>
                        <td>{{ $od->created_at}}</td>
                        <td>{{ $od->updated_at}}</td>
                        <td>{{ $od->billing_total}}</td>
                        <td style="width: 130px;">
							<a id="register" type="submit" class="detail-shop-button" 
						href = "{{ route('orders.show', $od->id) }}">Chi tiết</a>
                        </td>
                       
                    </tr>
                    @endforeach
					</tbody>
				</table>
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
