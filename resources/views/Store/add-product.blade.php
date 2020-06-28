@extends('layout')

@section('title', 'Thêm sản phẩm mới')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
		<span>Quản lí cửa hàng</span>
		<i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Thêm sản phẩm mới</span>
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
					<form action="{{ route('store.add-product-action') }}" method="POST" enctype="multipart/form-data">
							@method('post')
							@csrf
							<div class="form-control">
									<div class="label">Tên sản phẩm</div>
									<input id="name" type="text" name="name" required>
							</div>
							<div class="form-control">
									<div class="label">Slug</div>
									<input id="phone_number" type="text" name="slug" required>
							</div>
							<div class="form-control">
									<div class="label">Chi tiết</div>
									<input id="email" type="text" name="details" required>
							</div>
							<div class="form-control">
									<div class="label">Đơn giá</div>
									<input id="name_store" type="number" name="price" 
									 required>
							</div>
							<div class="form-control">
								<div class="label">Mô tả</div>
								<textarea class="text-area" name="description"></textarea>
							</div>
							<div class="form-control">
								<div class="label">Số lượng có sẵn</div>
								<input id="name_store" type="number" name="quantity" 
									required>
							</div>
							<div class="form-control">
								<div class="label">Hình ảnh</div>
								<input required type="file" name="image" accept="image/*">

							</div>
							<div class="form-control">
								<div class="label">Danh sách ảnh chi tiết sản phẩm</div>
								<input required type="file" name="images[]" multiple accept="image/*">
							</div>
							<button id="register" type="submit" class="add-product-button">Thêm</button>
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
