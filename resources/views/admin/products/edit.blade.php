@extends('layouts.app')

@section('title')
    @isset($product)
        Редактирование товара
    @else
        Создание товара
    @endisset
@endsection

@section('content')
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <form
            @isset($product)
                action="{{ route('admin.products.update',$product->id) }}"
            @else
                action="{{ route('admin.products.store') }}"
            @endisset
             method="POST">

            @csrf

            @isset($product)
                @method('PUT')
            @endisset

            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6 mb-4">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" value="{{ old('name') ?? $product->name ?? '' }}" class="@error('name') border-red-600 focus:border-red-400 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-input" placeholder="Название товара">
                        @error('name')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="vendor_code" class="block text-sm font-medium text-gray-700">Артикул</label>
                        <input type="text" name="vendor_code" value="{{ old('vendor_code') ?? $product->vendor_code ?? '' }}" class="@error('vendor_code') border-red-600 focus:border-red-400 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-input" placeholder="1234-5678">
                        @error('vendor_code')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Описание товара</label>
                        <textarea name="description" rows="6" class="@error('description') border-red-600 focus:border-red-400 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md form-textarea" placeholder="Текст описания">{{ old('description') ?? $product->description ?? '' }}
                        </textarea>
                        @error('description')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') ?? $product->price ?? '' }}" class="@error('price') border-red-600 focus:border-red-400 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-input" placeholder="1234.56">
                        @error('price')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Наличие в магазинах</label>
                    <table class="border-collapse">
                        <thead>
                        <tr>
                            <th class="py-1 px-2 text-sm bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Название магазина</th>
                            <th class="py-1 px-2 text-sm bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Количество товара</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($stores as $store)
                            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                <td class="w-full p-2 lg:w-auto text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    {{ $store->name }}
                                </td>
                                <td class="w-full lg:w-auto text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                    <input type="number" name="store_products[{{ $store->id }}]" value="{{ old("store_products")[$store->id] ?? $store->stock_quantity ?? 0 }}" class="block w-full text-sm border-0 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="0">
                                    @error('store_products.'. $store->id)
                                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 inline-flex">
                <button type="submit" class="inline-flex mr-2 justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Сохранить
                </button>
                @isset($product)
                    <button @click.prevent="deleteModalOpen = true; deleteModalAction = '{{ route('admin.products.destroy',$product->id) }}'" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Удалить товар
                    </button>
                @endisset
            </div>
        </form>
    </div>
    <x-delete-modal title="Удалить товар" message="Вы действительно хотите удалить товар? Это действие невозможно будет отменить"/>

@endsection

