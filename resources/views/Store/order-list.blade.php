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
        <span>Quản lí đơn hàng</span>
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
                <h1 class="stylish-heading">Quản lí đơn hàng</h1>
			</div>
            <div>
				<table class="table">
					<thead class="thead-dark">
					  <tr >
						<th scope="col">Mã đơn hàng</th>
						<th scope="col">Người đặt</th>
						<th scope="col">Địa chỉ</th>
						<th scope="col">Email</th>
						<th scope="col">Số điện thoại</th>
                        <th scope="col">Chi tiết</th>
                        <th scope="col">Hoàn thành</th>
                        <th scope="col">Hủy</th>
					  </tr>
					</thead>
					<tbody>
                    @foreach($order as $od)  
                    <tr style="text-align: center;">
						<td>{{ $od->id}}</td>
                        <td>{{ $od->billing_name}}</td>
                        <td>{{ $od->billing_address}}</td>
                        <td>{{ $od->billing_email}}</td>
                        <td>{{ $od->billing_phone}}</td>
                        <td style="width: 130px;">
							<a id="register" type="submit" class="detail-shop-button" 
						href = "{{ route('order.detail', $od->id) }}">Chi tiết</a>
                        </td>
                        <td style="width: 140px;"><form action="{{ route('order.finish', $od->id) }}" method="POST">
							@method('post')
							@csrf
							<a id="register" type="submit" class="done-shop-button" 
                        href = "{{ route('order.finish', $od->id) }}">Hoàn thành</a>
                        </form>
                        </td>
                        <td><form action="#" method="POST">
							@method('post')
							@csrf
							<a id="register" type="submit" class="delete-shop-button" 
                        href = "#">Hủy</a>
                        </form>
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
