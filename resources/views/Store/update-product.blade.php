@extends('layout')

@section('title', 'Thêm sản phẩm mới')

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
        <div class="products-section container">
			<div class="sidebar">
	
				<ul>
				  <li class="active"><a href="{{ route('users.edit') }}"></a></li>
				  <li><a href="{{ route('orders.index') }}"></a></li>
				</ul>
			</div> <!-- end sidebar -->
			<div class="my-profile">
				<div class="products-header">
					<h1 class="stylish-heading">Thêm sản phẩm mới</h1>
				</div>
				<div class="add-product-section">
					<form action="{{ route('store.update-product-action', $product->id) }}" method="POST">
							@method('post')
							@csrf
							<div class="form-control">
									<div class="label">Tên sản phẩm</div>
									<input id="name" type="text" name="name" value="{{ $product->name}}" required>
							</div>
							<div class="form-control">
									<div class="label">Slug</div>
									<input id="phone_number" type="text" name="slug" value="{{ $product->slug}}" required>
							</div>
							<div class="form-control">
									<div class="label">Chi tiết</div>
									<input id="email" type="text" name="details" value="{{ $product->details}}" required>
							</div>
							<div class="form-control">
									<div class="label">Đơn giá</div>
                                    <input id="name_store" type="number" name="price" 
                                    value="{{ $product->price}}"
									 required>
							</div>
							<div class="form-control">
								<div class="label">Mô tả</div>
								<textarea class="text-area" name="description">{{ $product->description}}</textarea>
							</div>
							<div class="form-control">
								<div class="label">Số lượng có sẵn</div>
								<input id="name_store" type="number" name="quantity" value="{{ $product->quantity}}"
									required>
							</div>
							<div class="form-control">
                                <div class="label">Hình ảnh</div>
                                <img src="{{ $product->image}}">

							</div>
							<div class="form-control">
                                <div class="label">Danh sách ảnh chi tiết sản phẩm</div>
                                @foreach( $images as $img)
                                    <img src = "{{$img}}">
                                    @endforeach
							</div>
							<button id="register" type="submit" class="add-product-button">Cập nhật</button>
					</form>
				</div>
            <div>
                
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
