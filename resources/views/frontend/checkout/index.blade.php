@extends('frontend.layout.master')

@section('title', 'Checkout - ShopMind')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-2xl mx-auto pt-16 pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <h2 class="sr-only">Checkout</h2>

        <form action="{{ route('frontend.checkout.store') }}" method="POST" class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            @csrf
            <div>
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

                    <div class="mt-4">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700">Address</label>
                        <div class="mt-1">
                            <textarea id="shipping_address" name="shipping_address" rows="4" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('shipping_address') }}</textarea>
                        </div>
                        @error('shipping_address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-10 border-t border-gray-200 pt-10">
                    <h2 class="text-lg font-medium text-gray-900">Payment</h2>

                    <fieldset class="mt-4">
                        <legend class="sr-only">Payment type</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="cod" name="payment_method" type="radio" value="cod" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="cod" class="ml-3 block text-sm font-medium text-gray-700"> Cash on Delivery </label>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <!-- Order summary -->
            <div class="mt-10 lg:mt-0">
                <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h3 class="sr-only">Items in your cart</h3>
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($cart->items as $item)
                            <li class="flex py-6 px-4 sm:px-6">
                                <div class="flex-shrink-0">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-20 rounded-md">
                                </div>

                                <div class="ml-6 flex-1 flex flex-col">
                                    <div class="flex">
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm">
                                                <a href="#" class="font-medium text-gray-700 hover:text-gray-800"> {{ $item->product->name }} </a>
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="flex-1 flex items-end justify-between pt-2">
                                        <p class="mt-1 text-sm font-medium text-gray-900">${{ number_format($item->product->price, 2) }} x {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <dl class="border-t border-gray-200 py-6 px-4 space-y-6 sm:px-6">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm">Subtotal</dt>
                            <dd class="text-sm font-medium text-gray-900">${{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm">Shipping</dt>
                            <dd class="text-sm font-medium text-gray-900">$0.00</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                            <dt class="text-base font-medium">Total</dt>
                            <dd class="text-base font-medium text-gray-900">${{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</dd>
                        </div>
                    </dl>

                    <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Confirm Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
