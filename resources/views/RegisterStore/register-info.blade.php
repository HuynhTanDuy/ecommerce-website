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
			<div class="register-info-section">
            <div class="products-header">
                <h1 class="stylish-heading"> Thông tin cửa hàng</h1>
            </div>

            <div>
				<div class="label-bold">Họ và tên chủ cửa hàng: <span class="label">{{ $user->name }}</span></div>
                <div class="label-bold">Số điện thoại đã đăng kí: <span class="label">{{ $user->phone_number }}</span></div>
                <div class="label-bold">Địa chỉ email của chủ cửa hàng: <span class="label">{{ $user->email }}</span></div>
                <div class="label-bold">Tên cửa hàng: <span class="label">{{ $store->name }}</span></div>
                <div class="label-bold">Mã số đăng ký kinh doanh: <span class="label">{{ $store->id_license }}</span></div>
                <div class="label-bold">Địa chỉ kinh doanh: <span class="label">{{ $store->location }}</span></div>
                <div class="label-bold">Ngành hàng: <span class="label">{{ $category->name }}</span></div>

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
		console.log(res);
		var option = "";
		res.forEach(rs => {
			option = option + '<option value="' + rs.province_name + '"> ' +rs.province_name+ ' </option>';
		
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
