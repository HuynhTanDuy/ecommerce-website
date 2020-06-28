@extends('layout')

@section('title', 'My Profile')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Profile</span>
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
        <div class="store-section container" style="max-width:1200px">
			<div class="register-info-section">
            <div class="products-header">
                <h1 class="stylish-heading"> Quản lí cửa hàng</h1>
			</div>
            <div>
				<table class="table">
					<thead class="thead-dark">
					  <tr >
						<th scope="col" style="max-width: 50px;">Mã SP</th>
						<th scope="col" style="width: 200px;">Người đặt</th>
						<th scope="col" style="width:350px">Địa chỉ</th>
						<th scope="col">Email</th>
						<th scope="col">Số điện thoại</th>
                        <th scope="col">Đơn giá</th>
						<th scope="col">Số lượng</th>
						<th scope="col">Giảm giá</th>
						<th scope="col">Tổng giá</th>
                        <th scope="col">Hủy</th>
					  </tr>
					</thead>
					<tbody>
                    
                    @foreach($order as $od)
                    <tr style="
					  text-align: center;
				  ">
						<td>{{ $od->product_id}}</td>
                        <td>{{ $od->billing_name}}</td>
                        <td>{{ $od->billing_address}}</td>
                        <td>{{ $od->billing_email}}</td>
                        <td>{{ $od->billing_phone}}</td>
                        <td>{{ $od->price}}</td>
                        <td>{{ $od->quantity}}</td>
                        <td>{{ $od->billing_discount}}</td>
                        <td>{{ $od->billing_total}}</td>
                        <td><form action="#" method="POST">
							@method('post')
							@csrf
							<a id="register" type="submit" class="delete-shop-button" 
						href = "#">Hủy</a>
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
