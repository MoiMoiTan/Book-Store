@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset("storage/{$product->image}") }}" alt="{{ $product->name }}" class="img-fluid">
            @else
                <p>Không có ảnh sản phẩm</p>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <p>Giá: {{ $product->price }}</p>
            <p>Loại sản phẩm: {{ $product->category->name }}</p>
            <p class="card-text">Số lượng còn lại: {{ $product->quantity }}</p>
            @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: flex; column-gap: 10px">
                    @csrf
                    <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                    <a href="{{ route('welcome') }}" class="btn btn-primary">Xem thêm sản phẩm</a>
                </form>
            @else
                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.</p>
            @endauth
        </div>
    </div>
</div>
@endsection