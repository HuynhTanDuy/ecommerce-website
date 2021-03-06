@extends('layout')
@section('title', 'Reset Password')
@section('content')
<div class="container">
    <div class="auth-pages">
        <div class="auth-left">
            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session()->get('status') }}
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
            <h2>Quên mật khẩu ?</h2>
            <div class="spacer"></div>
            <form action="{{ route('password.email') }}" method="POST">
                {{ csrf_field() }}
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                <div class="login-container">
                    <button type="submit" class="auth-button">Gửi link reset mật khẩu</button>
                </div>


            </form>
        </div>
        <div class="auth-right">
            <h2>Quên mật khẩu</h2>
            <div class="spacer"></div>
            <p>Lấy lại mật khẩu bằng email đã đăng ký của tài khoản</p>
            <div class="spacer"></div>
            <p>Vui lòng làm theo hướng dẫn trong mail nhận được!</p>
        </div>
    </div>
</div>
@endsection

