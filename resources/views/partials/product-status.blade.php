@if($product->stores_count == 1)
    <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Товар только в одном магазине</span>
@endif
@if($product->total_quantity > 500)
    <span title="Всего товаров: {{ $product->total_quantity ?? 0 }}" class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Много</span>
@endif
@if($product->total_quantity > 0 && $product->total_quantity < 5)
    <span title="Всего товаров: {{ $product->total_quantity ?? 0 }}" class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">Мало</span>
@endif
