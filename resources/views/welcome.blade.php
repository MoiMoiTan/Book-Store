<!-- views/welcome.blade.php -->
<style>
    .card {
        border: none !important;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
    }

    @media (max-width: 960px) {
        .product-row {
            flex-direction: column;
        }

        .product-col {
            width: 100%;
        }
    }
</style>
@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome to Book Store</h1>
    <div class="row product-row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4 product-col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if($product->image)
                                <img src="{{ asset("storage/{$product->image}") }}" alt="{{ $product->name }}"
                                    class="img-fluid" style="width: 275px; height: 200px; object-fit: cover;">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </div>
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-2">{{ $product->description }}</p>
                        <p class="card-text font-weight-bold mb-2">Giá tiền: ${{ number_format($product->price, 2) }}</p>
                        <p class="card-text text-muted mb-3">Loại sản phẩm: {{ optional($product->category)->name }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Hiển thị liên kết phân trang -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection