@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Đăng Ký Tài Khoản</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ url('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Họ và Tên</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Nhập họ và tên của bạn" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Nhập email của bạn" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Mật Khẩu</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Nhập mật khẩu của bạn" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password_confirmation">Xác Nhận Mật Khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Nhập lại mật khẩu của bạn" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-4">Đăng Ký</button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>Bạn đã có tài khoản? <a href="{{ route('login') }}" class="text-primary">Đăng nhập ngay</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection