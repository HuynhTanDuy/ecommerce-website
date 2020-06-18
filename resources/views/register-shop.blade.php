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
				<form action="" method="POST">
					<button type="submit" class="register-shop-button">Đăng kí</button>
                </form>
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
