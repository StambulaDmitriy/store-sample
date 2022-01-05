@extends('layouts.guest')

@section('title','Авторизация')

@section('content')
    <div class="flex flex-col overflow-y-auto md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
            <img aria-hidden="true" class="object-cover w-full h-full"
                 src="{{ asset('images/login-office.jpeg') }}"
                 alt="Office"/>
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700">
                    Login
                </h1>

                <x-auth-validation-errors :errors="$errors"/>

                <form method="POST" action="{{ route('login') }}">
                @csrf

                    <!-- Input[ype="email"] -->
                    <div class="mt-4">
                        <x-label :value="__('Email')"/>
                        <x-input type="email"
                                 id="email"
                                 name="email"
                                 value="{{ old('email') }}"
                                 class="block w-full rounded-md form-input"
                                 required
                                 autofocus/>
                    </div>

                    <!-- Input[ype="password"] -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')"/>
                        <x-input type="password"
                                 id="password"
                                 name="password"
                                 class="block w-full rounded-md form-input"/>
                    </div>

                    <div class="flex mt-6 text-sm">
                        <label class="flex items-center dark:text-gray-400">
                            <input type="checkbox"
                                   name="remember"
                                   class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple">
                            <span class="ml-2">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <x-button class="block w-full">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>

                <hr class="my-8"/>

                    <p class="mt-4">
                        <span>Нет аккаунта?</span>
                        <a class="text-sm font-medium text-primary-600 hover:underline"
                           href="{{ route('register') }}">Зарегистрироваться</a>
                    </p>

            </div>
        </div>
    </div>
@endsection
