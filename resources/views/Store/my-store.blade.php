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

    <div class="container" style="max-width: 1700px;">
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
        <div class="store-section container" style="max-width:1700px">
			<div class="register-info-section">
            <div class="products-header">
                <h1 class="stylish-heading"> Quản lí cửa hàng</h1>
            </div>

            <div>
				<table class="table">
					<thead class="thead-dark">
					  <tr >
						<th scope="col" style="max-width: 50px;">Mã SP</th>
						<th scope="col" style="width: 200px;">Tên</th>
						<th scope="col">Đơn giá</th>
						<th scope="col" style="width: 130px;">Số lượng hàng có sẵn</th>
						<th scope="col" style="width:350px">Ảnh đại diện sản phẩm</th>
						<th scope="col">Danh sách ảnh sản phầm</th>
						<th scope="col">Chi tiết</th>
						<th scope="col">Mô tả</th>
						<th scope="col">Sửa</th>
						<th scope="col">Xoá</th>
					  </tr>
					</thead>
					<tbody>
						@foreach( $products as $product)
					  <tr style="
					  text-align: center;
				  ">
						<th scope="row">{{ $product->id}}</th>
						<td>{{ $product->name }}</td>
						<td>{{ $product->price }}</td>
						<td>{{ $product->quantity }}</td>
						<td><img src="{{ $product->image }}"></td>
						<td>@mdo</td>
						<td>...</td>
						<td>...</td>
						<td><button id="register" style ="padding: 10px 32px;"class="register-shop-button">Sửa</button></td>
						<td><button id="register" class="delete-shop-button">Xoá</button></td>
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
