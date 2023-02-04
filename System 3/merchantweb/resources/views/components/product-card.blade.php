@props(['product'])
@php($id = $product->id)
<x-card>
    <div class="flex">
        <div>
            <h3 class="text-2xl">
                {{$product->name}}
            </h3>
            <div class="text-xl font-bold mb-4">RM {{$product->price}}</div>
            <form method="get" action="/products/{{$product->id}}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Buy</button>
            </form>
        </div>
    </div>
</x-card>
