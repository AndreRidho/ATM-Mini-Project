@extends('layout')

@section('content')

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

@if(count($products) == 0)
    <p>No products available</p>
@else
    @foreach($products as $product)
        <x-product-card :product="$product" />
    @endforeach
@endif

</div>

@endsection

