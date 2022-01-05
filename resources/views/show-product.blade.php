@extends('layouts.main')

@section('content')
    <div class="bg-white">
        <div class="pt-6">
            <div class="max-w-2xl mx-auto pt-10 pb-16 px-4 sm:px-6 lg:max-w-7xl lg:pt-16 lg:pb-24 lg:px-8 lg:grid lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8">
                <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                        {{ $product->name }}
                    </h1>
                </div>

                <!-- Options -->
                <div class="mt-4 lg:mt-0 lg:row-span-3">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl text-gray-900">Цена: {{ $product->formatted_price }}  &#x20bd;</p>

                    <ul class="mt-4 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach($stores as $store)
                            <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600">
                                {{ $store->name }}
                                @if($store->stock_quantity > 0)
                                    <span class="float-right bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Есть в наличии</span>
                                @else
                                    <span class="float-right bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Нет в наличии</span>
                                @endif
                            </li>

                        @endforeach
                    </ul>

                </div>

                <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <!-- Description and details -->
                    <div>
                        <div class="space-y-6">
                            <p class="text-base text-gray-900">{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h2 class="font-medium mb-4 text-gray-900">Наличие товара в магазинах на карте</h2>

                        <div id="map" style="width: 600px; height: 400px"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <script src="https://api-maps.yandex.ru/2.1/?apikey={{ config('maps.api_key') }}&lang=ru_RU" type="text/javascript"></script>
@endpush

@push('footer-scripts')
    <script type="text/javascript">

        var myMap,objectManager;

        // Дождёмся загрузки API и готовности DOM.
        ymaps.ready(init);

        function init () {
            myMap = new ymaps.Map('map', {
                center: [48.020631, 37.802839],
                zoom: 12,
            }, {
                searchControlProvider: 'yandex#search'
            });
            objectManager = new ymaps.ObjectManager({
                // Чтобы метки начали кластеризоваться, выставляем опцию.
                clusterize: true,
                // ObjectManager принимает те же опции, что и кластеризатор.
                gridSize: 32,
                clusterDisableClickZoom: true
            });

            objectManager.objects.options.set('preset', 'islands#greenDotIcon');
            objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
            myMap.geoObjects.add(objectManager);


            axios.get('{{ route('api.products.stock-placemarks',$product->id) }}')
                .then(function (response) {
                    objectManager.add(response.data);
                    myMap.setBounds(myMap.geoObjects.getBounds())
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        }
    </script>
@endpush
