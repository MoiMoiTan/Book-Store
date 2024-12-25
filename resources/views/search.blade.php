@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kết quả tìm kiếm cho "{{ $query }}"</h2>

    @if($products->isEmpty())
        <p>Không tìm thấy sản phẩm nào.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div style="text-align: center;">
                            @if($product->image)
                                <img style="width: 100px; height: 100px; object-fit: cover;"
                                    src="{{ asset("storage/{$product->image}") }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                        </div>
                        <div class="card-body" style="text-align: center;">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="card-text">Giá: {{ number_format($product->price) }} VNĐ</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $products->links() }}
    @endif
</div>
@endsection