@extends('layouts.app')
@section('content')
<h1>{{ $product->name }}</h1>
<p>{{ $product->description }}</p>
<p>Quantity: {{ $product->quantity }}</p>
<p>Price: {{ $product->price }}</p>
<p>Quantity: {{ $product->quantity }}</p>
<p>Category: {{ $product->category->name }}</p>
<a href="{{ route('welcome') }}">Back to list</a>
@endsection