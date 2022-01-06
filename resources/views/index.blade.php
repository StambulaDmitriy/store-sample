@extends('layouts.main')

@section('content')

<h2 class="text-2xl mt-4 font-extrabold tracking-tight text-gray-900">Товары</h2>


<div class="my-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
@forelse($products as $product)
    <div class="group relative">
        <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 p-4 rounded-md overflow-hidden lg:h-80 lg:aspect-none">
            <p>{{ $product->description }}</p>
        </div>
        <div class="mt-4 flex justify-between">
            <div>
                <h3 class="text-sm text-gray-700">
                    <a href="{{ route('show-product',$product->id) }}">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                        {{ $product->name }}
                    </a>
                </h3>
                @if($product->total_quantity > 0)
                    <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Есть в наличии</span>
                @else
                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Нет в наличии</span>
                @endif
            </div>
            <p class="text-sm font-medium text-gray-900">{{ $product->formatted_price }} &#x20bd;</p>
        </div>
    </div>
@empty
    <p>Нет товаров</p>
@endforelse
</div>
<div class="mb-4">
    {{ $products->links('partials.paginator') }}
</div>
@endsection
