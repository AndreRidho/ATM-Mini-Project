@extends('layout')
@section('content')
<x-card class="p-10 max-w-lg mx-auto mt-24">
<header class="text-center">
    <p class="mb-4">{{ $result ? 'Your purchase is successful.' : 'Your purchase is unsuccessful.'}}</p>
</header>

<form method="GET" action="/">
    @csrf

    <div class="flex items-center justify-center">
        <div class="mb-6">
            <button
                type="submit"
                class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
            >
                Back to home
            </button>
        </div>
    </div>
</form>
</x-card>
@endsection
