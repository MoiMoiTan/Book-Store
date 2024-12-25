<!-- views/welcome.blade.php -->
@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome to Our Store</h1>
    <div class="card-deck">
        @section('title', 'Admin Dashboard')
        @section('content')
        <div class=“container“>
            <div class="bg-blue p-4">
                <h1>Admin Dashboard</h1>

            </div>

            <div class="container-fluid">
                <div class="row flex-nowrap">
                    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark pb-4">
                        <div
                            class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                            <a href="/"
                                class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                                <span class="fs-5 d-none d-sm-inline">Menu</span>
                            </a>
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">
                                <li>
                                    <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
                                        </li>
                                        <li>
                                            <a class="nav-link"
                                                href="{{ route('admin.categories.index') }}">Categories</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ route('admin.reports.index') }}">Sales
                                                figures</a>
                                        </li>
                                    </ul>
                                </li>

                        </div>
                    </div>
                    <div class="col py-3">
                        <p>Chào mừng đến với trang quản trị! Tại đây, bạn có thể quản lý đơn hàng, danh muc, sản phẩm và
                            nhiều
                            chức
                            năng khác.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</div>
<!-- Hiển thị liên kết phân trang -->
<div class="d-flex justify-content-center">
</div>
</div>
@endsection