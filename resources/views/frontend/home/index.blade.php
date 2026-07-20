@extends('frontend.layout.master')

@section('title', 'Welcome to ShopMind - Best Ecommerce Store')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Premium Quality</span>
                            <span class="block text-indigo-600 xl:inline">Products for You</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Discover the latest trends in fashion and technology. High-quality products, affordable prices, and fast delivery right to your doorstep.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('frontend.home') }}#shop" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Shop Now
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Featured Product">
        </div>
    </div>

    <!-- Featured Products -->
    <div id="shop" class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Special Offers</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Featured Products
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 transition-transform duration-300 hover:-translate-y-1">
                        <div class="relative h-48">
                            <img src="{{$product->image}}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @if($product->is_sale)
                                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">SALE</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">
                                <a href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="mt-1 text-gray-500 text-sm line-clamp-2">{{ $product->description }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('frontend.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500">No featured products found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- New Arrivals -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">New Arrivals</h2>
                <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">View All &rarr;</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($newArrivals as $product)
                    <div class="group relative">
                        <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden lg:aspect-none group-hover:opacity-75 h-80">
                            <img src="{{$product->image}}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a href="{{ route('frontend.product.show', $product->slug) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $product->is_new ? 'New Arrival' : '' }}</p>
                            </div>
                            <div class="flex flex-col items-end justify-between">
                                <p class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                                <form action="{{ route('frontend.cart.add') }}" method="POST" class="mt-2 relative z-10">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500">No new arrivals found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
