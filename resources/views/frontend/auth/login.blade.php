@extends('frontend.layout.master')

@section('title', 'Login - ShopMind')

@section('content')
<div class="min-h-[calc(100vh-10rem)] flex items-center justify-center bg-slate-50 relative overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
    <!-- Decorative background blobs -->
    <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
    <div class="absolute bottom-0 right-0 translate-x-1/4 translate-y-1/4 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>

    <!-- Unified Form Card -->
    <div class="w-full max-w-md bg-white/95 backdrop-blur-md py-10 px-8 shadow-2xl rounded-3xl relative z-10 border-0">
        <!-- Logo and Heading -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-indigo-600 p-3 rounded-2xl shadow-lg mb-4 text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Welcome Back
            </h2>
            <p class="mt-2 text-sm text-gray-500">
                Or
                <a href="{{ route('frontend.register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                    create a new account
                </a>
            </p>
        </div>

        <form class="space-y-5" action="{{ route('frontend.login.post') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">
                    Email Address
                </label>
                <input id="email" name="email" type="email" autocomplete="email" required
                       value="{{ old('email') }}" placeholder="Enter your email address"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 font-medium ml-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5 ml-1">
                    <label for="password" class="block text-sm font-semibold text-gray-700">
                        Password
                    </label>
                    <div class="text-sm">
                        <a href="" class="font-semibold text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                            Forgot password?
                        </a>
                    </div>
                </div>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       placeholder="Enter your password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200">
                @error('password')
                    <p class="mt-1.5 text-xs text-red-600 font-medium ml-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center ml-1">
                <input id="remember" name="remember" type="checkbox"
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md transition duration-150 ease-in-out">
                <label for="remember" class="ml-2 block text-sm text-gray-900 font-medium">
                    Remember me
                </label>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-2xl shadow-lg text-base font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform active:scale-[0.98] transition-all duration-200 uppercase tracking-widest">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>
@endsection
