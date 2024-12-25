@extends('layouts.app')

@section('title', 'Báo cáo thống kê')

@section('content')
<div class="container">
    <h1 class="mb-4">Báo cáo thống kê</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tổng số đơn hàng</h5>
                    <p class="card-text display-4">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tổng số khách hàng</h5>
                    <p class="card-text display-4">{{ $totalCustomers }}</p>
                </div>
            </div>
        </div>
    </div>

    <h3>Doanh thu theo từng danh mục</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Danh mục</th>
                <th>Tổng doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryRevenue as $revenue)
                <tr>
                    <td>{{ $revenue->category_name }}</td>
                    <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Doanh thu theo ngày</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Tổng doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByDate as $revenue)
                <tr>
                    <td>{{ $revenue->date }}</td>
                    <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Doanh thu theo tháng</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tháng</th>
                <th>Tổng doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByMonth as $revenue)
                <tr>
                    <td>{{ $revenue->month }}/{{ $revenue->year }}</td>
                    <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Doanh thu theo năm</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Năm</th>
                <th>Tổng doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByYear as $revenue)
                <tr>
                    <td>{{ $revenue->year }}</td>
                    <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Doanh thu theo phương thức thanh toán</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Phương thức thanh toán</th>
                <th>Tổng doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByPaymentMethod as $revenue)
                <tr>
                    <td>
                        @switch($revenue->payment_method)
                            @case('cod')
                                Thanh toán khi nhận hàng (COD)
                                @break
                            @case('bank_transfer')
                                Chuyển khoản ngân hàng
                                @break
                            @case('vnpay')
                                Ví VNPay
                                @break
                            @default
                                {{ $revenue->payment_method }}
                        @endswitch
                    </td>
                    <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection