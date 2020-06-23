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
                <h1 class="stylish-heading">Đăng kí mở cửa hàng</h1>
            </div>

            <div>
				<form action="{{ route('store.register') }}" method="POST">
                    @method('post')
					@csrf
					<div class="form-control">
							<div class="label">Họ và tên chủ cửa hàng</div>
							<input id="name" type="text" name="name" 
								value="{{$user->name}}" placeholder="Nguyễn Văn A" disabled>
					</div>
					<div class="form-control">
							<div class="label">Số điện thoại chủ cửa hàng</div>
							<input id="phone_number" type="number" name="phone_number" 
								value="147852369" disabled>
					</div>
					<div class="form-control">
							<div class="label">Địa chỉ email của chủ cửa hàng</div>
							<input id="email" type="email" name="email" 
								value="{{$user->email}}" disabled>
					</div>
					<div class="form-control">
							<div class="label">Tên cửa hàng</div>
							<input id="name_store" type="text" name="name_store" 
								value="" placeholder="Cửa hàng của tôi" required>
					</div>
					<div class="form-control" style="d">
							<div class="label">Doanh nghiệp của bạn đã có giấy phép kinh doanh chưa?</div>
							<input id="is_license" class="radio-button" type="radio" name="is_license"
							onclick="document.getElementById('no-license').checked = false"
							onchange="document.getElementById('register').disabled = !this.checked;" 
							>Đã có
							<input id ="no-license"class="radio-button" type="radio" name="is_no_license"
							onclick="document.getElementById('is_license').checked = false" 
							onchange="document.getElementById('register').disabled = this.checked;"
							>Chưa có
					</div>
					<div class="form-control">
							<div class="label">Mã số đăng kí kinh doanh</div>
							<input id="id_license" type="text" name="id_license" 
								value="" required>
					</div>
					<div class="form-control">
							<div class="label">Tỉnh, thành phố</div>
							<select id="location" name="location">
							</select>
					</div>
					<div class="form-control">
							<div class="label">Chọn ngành hàng</div>
							<select name="category" id="category">
								@foreach ($categories as $category)
								<option value="{{$category->id}}">{{ $category->name }}</option>
								@endforeach
							</select>
					</div>
					<label style="margin-bottom: 30px; width: 600px";>Bằng cách gửi đơn đăng ký của bạn, bạn đồng ý với <a style="color:#1890ff";>Thỏa thuận dịch vụ </a>của chúng tôi
						và xác nhận rằng thông tin bạn cung cấp đã hoàn chỉnh và chính xác.</label>
					<button id="register" type="submit" class="register-shop-button">Đăng kí</button>
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
