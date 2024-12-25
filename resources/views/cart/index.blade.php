@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Giỏ hàng của bạn</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form action="{{ route('cart.updateAll') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Danh mục</th>
                                        <th>Thành tiền</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php    $totalCart = 0; @endphp
                                    @foreach($cartItems as $item)
                                                @php
                                                    $totalItem = $item->quantity * $item->product->price;
                                                    $totalCart += $totalItem;
                                                @endphp
                                                <tr>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>
                                                        <input type="number" name="quantities[{{ $item->product_id }}]" value="{{ $item->quantity }}"
                                                            min="1" style="width: 60px;">
                                                    </td>
                                                    <td>${{ number_format($item->product->price) }}</td>
                                                    <td>{{ $item->product->category->name }}</td>
                                                    <td>${{ number_format($totalItem) }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-item"
                                                            data-product-id="{{ $item->product_id }}">Xoá</button>
                                                    </td>
                                                </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="3" class="text-end"><strong>Tổng tiền giỏ hàng:</strong></td>
                                        <td><strong class="text-primary">${{ number_format($totalCart) }}</strong></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sync-alt"></i> Cập nhật giỏ hàng
                                </button>
                                <a href="{{ route('welcome') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-shopping-cart"></i> Tiếp tục mua sắm
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Thông tin thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cart.process') }}" method="POST" id="checkout-form">
                            @csrf
                            <div class="mb-3">
                                <label for="buyer_name" class="form-label">Tên người mua:</label>
                                <input type="text" name="buyer_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại:</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ:</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="payment_method" class="form-label">Phương thức thanh toán:</label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="">Chọn phương thức thanh toán</option>
                                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                    <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                                    <option value="vnpay">Ví VNPay</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100 btn-checkout">
                                <i class="fas fa-check-circle"></i> Xác nhận thanh toán
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <p class="lead">Giỏ hàng của bạn trống.</p>
            <a href="{{ route('welcome') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-cart"></i> Bắt đầu mua sắm
            </a>
        </div>
    @endif
</div>

<style>
    .table th {
        font-weight: 600;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .btn-checkout:hover {
        transform: translateY(-1px);
        transition: transform 0.2s;
    }
</style>
@endsection