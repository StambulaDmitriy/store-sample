@extends('layouts.app')

@section('title','Настройки')

@section('content')
    @if ($message = Session::get('success'))
        <div class="inline-flex w-full mb-4 overflow-hidden bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-center w-12 bg-green-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
                    </path>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Успех</span>
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <div class="p-4 bg-white rounded-lg shadow-md">

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <x-label for="name" :value="'Имя'"/>
                    <x-input type="text"
                             id="name"
                             name="name"
                             class="block w-full rounded-md form-input"
                             value="{{ old('name', auth()->user()->name) }}"
                             required/>
                    @error('name')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label for="email" :value="'Email'"/>
                    <x-input name="email"
                             type="email"
                             class="block w-full rounded-md form-input"
                             value="{{ old('email', auth()->user()->email) }}"
                             required/>
                    @error('email')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label for="password" :value="'Новый пароль'"/>
                    <x-input type="password"
                             name="password"
                             class="block w-full rounded-md form-input"
                             required/>
                    @error('password')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label id="password_confirmation" :value="'Повторите новый пароль'"/>
                    <x-input type="password"
                             name="password_confirmation"
                             class="block w-full rounded-md form-input"
                             required/>
                </div>

                <div class="mt-4">
                    <x-button class="block w-full">Сохранить</x-button>
                </div>
            </form>

        </div>
        <div class="p-4 bg-white rounded-lg shadow-md">
            <form action="{{ route('admin.profile.update-settings') }}" method="POST">
                @csrf
                @method('PUT')


                <x-label for="datatables_update_rate_ms" :value="'Частота обновления таблиц с данными, мс.'"/>
                <x-input type="text"
                         name="datatables_update_rate_ms"
                         class="block w-full rounded-md form-input"
                         value="{{ old('datatables_update_rate_ms') ?? Auth::user()->settings->datatables_update_rate_ms ?? 0 }}"
                         />
                @error('datatables_update_rate_ms')
                <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                @enderror

                <div class="mt-4">
                    <x-button class="block w-full">Сохранить</x-button>
                </div>

            </form>
        </div>
    </div>


@endsection
