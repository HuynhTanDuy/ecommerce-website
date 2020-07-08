@extends('layout')

@section('title', 'Sign Up for an Account')

@section('content')
<div class="container">
    <div class="auth-pages">
        <div>
            @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
            @endif @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h2>Tạo tài khoản</h2>
            <div class="spacer"></div>

            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>

                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>

                <input id="password" type="password" class="form-control" name="password" placeholder="Password" placeholder="Password" required>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"
                    required>

                <div class="login-container">
                    <button type="submit" class="auth-button">Tạo tài khoản</button>
                    <div class="already-have-container">
                        <p><strong>Đã có tài khoản?</strong></p>
                        <a href="{{ route('login') }}">Đăng nhập</a>
                    </div>
                </div>

            </form>
        </div>

        <div class="auth-right">
            <h2>Khách hàng mới</h2>
            <div class="spacer"></div>
            <p><strong>Tiết kiệm thời gian</strong></p>
            <p>Tạo tài khoản giúp bạn thanh toán nhanh hơn trong tương lại, dễ dàng theo dõi tình trạng và lịch sử mua hàng và cải thiện trải nghiệm sử dụng của chính bạn.</p>

            &nbsp;
            <div class="spacer"></div>
            <p><strong>Nhiều ưu đãi hấp dẫn</strong></p>
            <p>Tận hưởng nhiều ưu đãi, sự kiện trên hệ thống của chúng tôi</p>
        </div>
    </div> <!-- end auth-pages -->
</div>
@endsection
