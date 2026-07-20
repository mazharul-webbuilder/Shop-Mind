@extends('frontend.layout.master')

@section('title', $product->name . ' - ShopMind')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            <!-- Left Column: Image -->
            <div class="w-full">
                <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                    <img src="{{ $product->image ?? 'https://placehold.co/600x600?text=' . urlencode($product->name) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-center object-cover">
                </div>
            </div>

            <!-- Right Column: Product Details -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0 flex flex-col">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $product->name }}</h1>

                    <div class="mt-3 flex items-center justify-between">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl font-bold text-indigo-600">${{ number_format($product->price, 2) }}</p>

                        <!-- Stock Badge -->
                        <div>
                            @if($product->quantity > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    In Stock ({{ $product->quantity }} units)
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="mt-6">
                    <h3 class="sr-only">Reviews</h3>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="{{ $i <= $product->rating ? 'text-yellow-400' : 'text-gray-200' }} h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="sr-only">{{ $product->rating }} out of 5 stars</p>
                        <span class="ml-3 text-sm font-medium text-gray-500">{{ $product->rating_count }} reviews</span>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-sm font-bold text-gray-900">Description</h3>
                    <div class="mt-4 prose prose-sm text-gray-600">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>

                <form class="mt-8 border-t border-gray-200 pt-8" action="{{ route('frontend.cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex items-center space-x-4">
                        <div class="w-24">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <select id="quantity" name="quantity" class="block w-full rounded-lg border-gray-300 py-2.5 text-base leading-5 font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition ease-in-out">
                                @for($i = 1; $i <= min(10, $product->quantity); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="flex-1 mt-6">
                            <button type="submit"
                                    @if($product->quantity <= 0) disabled @endif
                                    class="w-full bg-indigo-600 border border-transparent rounded-lg py-3 px-8 flex items-center justify-center text-base font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-wide">
                                Add to Bag
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Product Metadata / Accordion -->
                <div class="mt-12 border-t border-gray-200" x-data="{ open: 1 }">
                    <div class="py-6 border-b border-gray-200">
                        <button type="button" @click="open = open === 1 ? 0 : 1" class="group relative w-full flex justify-between items-center text-left" aria-controls="disclosure-1" aria-expanded="false">
                            <span :class="open === 1 ? 'text-indigo-600' : 'text-gray-900'" class="text-sm font-bold">Product Specifications</span>
                            <span class="ml-6 flex items-center">
                                <svg :class="open === 1 ? 'rotate-180' : 'rotate-0'" class="h-5 w-5 text-gray-400 group-hover:text-gray-500 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="open === 1" class="mt-4 prose prose-sm text-gray-500" id="disclosure-1">
                            <ul role="list" class="space-y-2">
                                <li class="flex items-center">
                                    <span class="font-medium text-gray-900 w-24">SKU:</span>
                                    <span>SM-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="font-medium text-gray-900 w-24">Category:</span>
                                    <span>General Merchandise</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="font-medium text-gray-900 w-24">Sold:</span>
                                    <span>{{ $product->sold }} units</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="py-6 border-b border-gray-200">
                        <button type="button" @click="open = open === 2 ? 0 : 2" class="group relative w-full flex justify-between items-center text-left">
                            <span :class="open === 2 ? 'text-indigo-600' : 'text-gray-900'" class="text-sm font-bold">Shipping & Returns</span>
                            <span class="ml-6 flex items-center">
                                <svg :class="open === 2 ? 'rotate-180' : 'rotate-0'" class="h-5 w-5 text-gray-400 group-hover:text-gray-500 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="open === 2" class="mt-4 text-sm text-gray-500">
                            <p>Free shipping on orders over $100. Delivered within 3-5 business days. 30-day return policy for unused items.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
