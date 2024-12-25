<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Hóa đơn #{{ $order->id }}</h1>
    <p>Khách hàng: {{ $order->user->name }}</p>
    <p>Ngày đặt hàng: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p>Trạng thái: {{ $order->status }}</p>

    <table>
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

    <p><strong>Tổng cộng: ${{ number_format($order->total_price) }}</strong></p>
</body>

</html>