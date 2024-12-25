<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách đơn hàng</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->buyer_name }}</td>
                    <td>${{ number_format($order->total_price) }}</td>
                    <td>
                        @switch($order->payment_method)
                            @case('cod')
                                <span class=""><i class="fas fa-truck"></i> COD (Thanh toán khi nhận hàng)</span>
                                @break
                            @case('vnpay')
                                <span class=""><i class="fas fa-credit-card"></i> Chuyển khoản VNPay</span>
                                @break
                            @case('bank_transfer')
                                <span class=""><i class="fas fa-university"></i> Chuyển khoản ngân hàng</span>
                                @break
                            @default
                                <span class=""><i class="fas fa-question-circle"></i> Không xác định ({{ $order->payment_method }})</span>
                        @endswitch
                    </td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">Chi tiết</a>
                        <a href="{{ route('admin.orders.print-invoice', $order) }}" class="btn btn-sm btn-success"
                            target="_blank">In hóa đơn</a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection