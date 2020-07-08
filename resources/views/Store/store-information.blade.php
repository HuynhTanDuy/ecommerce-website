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
        <div class="products-section container">
            <div class="sidebar">

                <ul>
                <li class="active"><a href="{{ route('users.edit') }}"></a></li>
                <li><a href="{{ route('orders.index') }}"></a></li>
                </ul>
			</div> <!-- end sidebar -->
			<div class="register-shop-section">
            <div class="products-header">
                <h1 class="stylish-heading">Thông tin cửa hàng</h1>
            </div>

            <div>
				<form action="{{ route('store.information-update', $store->id) }}" method="POST">
                    @method('post')
					@csrf
					<div class="form-control">
							<div class="label">Tên cửa hàng</div>
							<input id="name_store" type="text" name="name_store" 
								value="{{$store->name}}" placeholder="Cửa hàng của tôi" required>
                    </div>
                    <div class="form-control">
							<div class="label">Mã số đăng kí kinh doanh</div>
                            <input disabled id="id_license" type="text" 
								value="{{$store->id_license}}" required>
					</div>
					<div class="form-control">
							<div class="label">Tỉnh, thành phố</div>
							<select id="location" name="location">
							</select>
					</div>
					<div class="form-control">
							<div class="label">Ngành hàng</div>
                            <input disabled id="category" type="text" 
								value="{{$category->name}}" required>
					</div>
					<button id="register" type="submit" class="register-shop-button">Cập nhật</button>
				</form>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
@endsection
<script>
window.onload = function getLocation()
	{
		var theUrl= "https://vapi.vnappmob.com/api/province";
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", theUrl, false );
		xmlHttp.send( null );
		var res = JSON.parse(xmlHttp.responseText).results;
		console.log(JSON.stringify(@json($store->location)));
		var option = "";
		res.forEach(rs => {
            if (JSON.stringify(@json($store->location)) == JSON.stringify(rs.province_name)) {
			option = option + '<option selected value="' + rs.province_name + '"> ' +rs.province_name+ ' </option>';
            } else {
                option = option + '<option value="' + rs.province_name + '"> ' +rs.province_name+ ' </option>';

            }
		
		});
		document.getElementById("location").innerHTML = option;
	}

	
</script>
@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
