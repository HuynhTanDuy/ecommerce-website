@extends('layout')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="auth-pages">
        <div class="auth-left">
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
            <h2>Đã có tài khoản</h2>
            <div class="spacer"></div>

            <form action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}

                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Password" required>

                <div class="login-container">
                    <button type="submit" class="auth-button">Đăng nhập</button>
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lưu tài khoản
                    </label>
                </div>

                <div class="spacer"></div>

                <a href="{{ route('password.request') }}">
                    Quên mật khẩu ?
                </a>

            </form>
        </div>

        <div class="auth-right">
            <h2>Khách hàng mới</h2>
            <div class="spacer"></div>
            <p><strong>Mua nhanh</strong></p>
            <p>Bạn có thể mua hàng mà không cần tạo tài khoản</p>
            <div class="spacer"></div>
            <a href="{{ route('guestCheckout.index') }}" class="auth-button-hollow">Tiếp tục mua hàng</a>
            <div class="spacer"></div>
            &nbsp;
            <div class="spacer"></div>
            <p><strong>Tiết kiệm thời gian</strong></p>
            <p>Tạo tài khoản để tiết kiệm thời gian đặt hàng, mua hàng và dễ dàng theo dõi lịch sử mua hàng</p>
            <div class="spacer"></div>
            <a href="{{ route('register') }}" class="auth-button-hollow">Tạo tài khoản</a>

        </div>
    </div>
</div>
@endsection
