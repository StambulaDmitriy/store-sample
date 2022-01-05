@extends('layouts.app')

@section('title')
    @isset($store)
        Редактирование магазина
    @else
        Создание магазина
    @endisset
@endsection

@section('content')
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <form
            @isset($store)
                action="{{ route('admin.stores.update',$store->id) }}"
            @else
                action="{{ route('admin.stores.store') }}"
            @endisset
            method="POST">

            @csrf

            @isset($store)
                @method('PUT')
            @endisset

            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" value="{{ old('name') ?? $store->name ?? '' }}" class="@error('name') border-red-600 focus:border-red-400 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-input" placeholder="Название магазина">
                        @error('name')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="vendor_code" class="block text-sm font-medium text-gray-700">График работы</label>
                        <input type="text" name="schedule" value="{{ old('schedule') ?? $store->schedule ?? '' }}" class="@error('schedule') border-red-600 focus:border-red-400 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-input" placeholder="ПН-ВС с 9:00 до 18:00">
                        @error('schedule')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="vendor_code" class="block text-sm font-medium text-gray-700">Адрес</label>
                        <input type="text" name="address" value="{{ old('address') ?? $store->address ?? '' }}" class="@error('address') border-red-600 focus:border-red-400 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-input" placeholder="г. Донецк, ул. Университетская, 1">
                        @error('address')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="price" class="block text-sm font-medium text-gray-700">Контактный телефон</label>
                        <input type="text" name="phone" value="{{ old('phone') ?? $store->phone ?? '' }}" class="@error('phone') border-red-600 focus:border-red-400 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-input" placeholder="+380710000000">
                        @error('phone')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6">
                        <label for="price" class="block mb-1 text-sm font-medium text-gray-700">Расположение на карте</label>
                        <input type="hidden" name="coordinate_lat" value="{{ old('coordinate_lat') ?? $store->coordinate_lat ?? '' }}">
                        <input type="hidden" name="coordinate_long" value="{{ old('coordinate_long') ?? $store->coordinate_long ?? '' }}">
                        @if($errors->has('coordinate_long') || $errors->has('coordinate_lat'))
                            <span class="text-xs text-red-600 dark:text-red-400">Расположение магазина обязательно для заполнения</span>
                        @endif
                        <div id="map" style="width: 600px; height: 400px"></div>

                    </div>
                </div>

            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 inline-flex">
                <button type="submit" class="inline-flex mr-2 justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Сохранить
                </button>
                @isset($store)
                    <button @click.prevent="deleteModalOpen = true; deleteModalAction = '{{ route('admin.stores.destroy',$store->id) }}'" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Удалить магазин
                    </button>
                @endisset
            </div>
        </form>

        <x-delete-modal title="Удалить магазин" message="Вы действительно хотите удалить магазин? Это действие невозможно будет отменить"/>


    </div>

@endsection

@push('head')
    <script src="https://api-maps.yandex.ru/2.1/?apikey={{ config('maps.api_key') }}&lang=ru_RU" type="text/javascript"></script>
@endpush

@push('footer-scripts')
    <script type="text/javascript">
        ymaps.ready(init);
        function init(){
            // Создание карты.
            var oldLat = {{ empty(old('coordinate_lat') ?? $store->coordinate_lat ?? '') ? 'undefined' : old('coordinate_lat') ?? $store->coordinate_lat}};
            var oldLong = {{ empty(old('coordinate_long') ?? $store->coordinate_long ?? '') ? 'undefined' : old('coordinate_long') ?? $store->coordinate_long }};

            var myPlacemark, myMap = new ymaps.Map("map", {
                center: [48.020631, 37.802839],
                zoom: 12,
                controls: ['searchControl', 'zoomControl', 'fullscreenControl']
            });

            if (oldLat !== undefined && oldLong !== undefined) {
                myPlacemark = createPlacemark([oldLat,oldLong]);
                myMap.geoObjects.add(myPlacemark);
                myMap.setCenter([oldLat, oldLong],16);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function (e) {
                    e.get('target').properties.set('iconCaption', e.get('target').geometry.getCoordinates());

                    updateInputs(e.get('target').geometry.getCoordinates());
                });

            }

            myMap.events.add("click", function(e)
            {
                var coords = e.get('coords');
                updateInputs(coords);

                // Если метка уже создана – просто передвигаем ее.
                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function (e) {
                        e.get('target').properties.set('iconCaption', e.get('target').geometry.getCoordinates());

                        updateInputs(e.get('target').geometry.getCoordinates());
                    });
                }
            });

            function createPlacemark(coords) {
                return new ymaps.Placemark(coords, {
                    iconCaption: coords
                }, {
                    preset: 'islands#violetDotIconWithCaption',
                    draggable: true
                });
            }

            function updateInputs(coords) {
                document.querySelector('input[name=coordinate_lat]').value = coords[0];
                document.querySelector('input[name=coordinate_long]').value = coords[1];
            }
        }
    </script>
@endpush


