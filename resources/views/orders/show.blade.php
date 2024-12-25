@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
    <p>Khách hàng: {{ $order->buyer_name }}</p>
    <p>Tổng tiền: ${{ number_format($order->total_price) }}</p>
    <p>Phương thức thanh toán:
        @if($order->payment_method == 'cod')
            COD
        @elseif($order->payment_method == 'bank_transfer')
            Chuyển khoản ngân hàng
        @elseif($order->payment_method == 'vnpay')
            Ví VNPay
        @else
            {{ $order->payment_method }}
        @endif
    </p>
    <p>Trạng thái: {{ $order->status }}</p>

    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mb-3">
        @csrf
        @method('PATCH')
        <select name="status" class="form-control d-inline-block w-auto mr-2">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
        </select>
        <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
    </form>

    <h2>Chi tiết sản phẩm</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>${{ number_format($detail->price) }}</td>
                    <td>${{ number_format($detail->quantity * $detail->price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.orders.print-invoice', $order) }}" class="btn btn-success" target="_blank">In hóa đơn</a>
</div>
@endsection