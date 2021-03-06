@extends('layouts.guest')

@section('title','Регистрация')


@section('content')
    <div class="flex flex-col overflow-y-auto md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
            <img aria-hidden="true" class="object-cover w-full h-full"
                 src="{{ asset('images/create-account-office.jpeg') }}" alt="Office"/>
        </div>

        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700">
                    Create account
                </h1>

                <x-auth-validation-errors :errors="$errors"/>

                <form method="POST" action="{{ route('register') }}">
                @csrf

                    <div class="mt-4">
                        <x-label for="name" :value="'Имя'"/>
                        <x-input type="text"
                                 id="name"
                                 name="name"
                                 class="block w-full rounded-md form-input"
                                 value="{{ old('name') }}"
                                 required
                                 autofocus/>
                    </div>

                    <div class="mt-4">
                        <x-label for="email" :value="'Email'"/>
                        <x-input name="email"
                                 type="email"
                                 class="block w-full rounded-md form-input"
                                 value="{{ old('email') }}"/>
                    </div>

                    <div class="mt-4">
                        <x-label for="password" :value="'Пароль'"/>
                        <x-input type="password"
                                 name="password"
                                 class="block w-full rounded-md form-input"
                                 required/>
                    </div>

                    <div class="mt-4">
                        <x-label id="password_confirmation" :value="'Подтвердите пароль'"/>
                        <x-input type="password"
                                 name="password_confirmation"
                                 class="block w-full rounded-md form-input"
                                 required/>
                    </div>

                    <div class="mt-4">
                        <x-button class="block w-full">Зарегистрироваться</x-button>
                    </div>
                </form>

                <hr class="my-8"/>

                <p class="mt-4">
                    <span>Есть аккаунт?</span>
                    <a class="text-sm font-medium text-primary-600 hover:underline"
                       href="{{ route('login') }}">Войти</a>
                </p>
            </div>
        </div>
@endsection
