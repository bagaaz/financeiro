@extends('layouts.auth')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-smoke">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-md">
            <div class="flex items-center justify-center">
                <img src="{{ asset('/src/logos/logo_vertical.png') }}" alt="Logo Horizontal DevConecta">
            </div>
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4 md:space-y-6">
                    <div>
                        <label for="email-address" class="block mb-2 text-sm font-medium text-gray-900">{{ __('messages.email') }}</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="{{ __('messages.email') }}">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">{{ __('messages.password') }}</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="{{ __('messages.password') }}">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                        <label for="remember-me" class="ml-3 text-sm text-gray-500">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>

                    <div>
                        <a href="#" class="text-sm font-medium text-primary-600 hover:underline">
                            {{ __('messages.forgot_password') }}
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-palatinate hover:bg-palatinateh focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-palatinate">
                        {{ __('messages.sign_in') }}
                    </button>
                </div>
            </form>
            <div class="text-center">
                <p class="text-sm font-light text-gray-500">
                    {{ __('messages.dont_have_account') }}
                    <a href="#" class="font-medium text-primary-600 hover:underline">
                        {{ __('messages.sign_up') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
