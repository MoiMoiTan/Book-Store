@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Đơn hàng đã được tạo thành công</h1>
    <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
    <p><strong>Tên người mua:</strong> {{ $buyerName }}</p>
    <p><strong>Số điện thoại:</strong> {{ $phone }}</p>
    <p><strong>Địa chỉ:</strong> {{ $address }}</p>
    <p><strong>Phương thức thanh toán:</strong> {{ $paymentMethod }}</p>
    <p><strong>Thời gian đặt hàng:</strong> {{ $orderTime->format('d/m/Y H:i:s') }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>
                <td><strong>${{ number_format($totalPrice, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
    <a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
</div>
@endsection