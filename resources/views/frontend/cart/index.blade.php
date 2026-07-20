@extends('frontend.layout.master')

@section('title', 'Your Shopping Cart - ShopMind')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Shopping Cart</h1>

        <div class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
            <section aria-labelledby="cart-heading" class="lg:col-span-7">
                <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                    @forelse($cart->items as $item)
                        <li class="flex py-6 sm:py-10">
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                    <div>
                                        <div class="flex justify-between">
                                            <h3 class="text-sm">
                                                <a href="{{ route('frontend.product.show', $item->product->slug) }}" class="font-medium text-gray-700 hover:text-gray-800">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-sm font-medium text-gray-900">${{ number_format($item->product->price, 2) }}</p>
                                    </div>

                                    <div class="mt-4 sm:mt-0 sm:pr-9">
                                        <form action="{{ route('frontend.cart.update', $item->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            <label for="quantity-{{ $item->id }}" class="sr-only">Quantity, {{ $item->product->name }}</label>
                                            <select id="quantity-{{ $item->id }}" name="quantity" onchange="this.form.submit()" class="max-w-full rounded-md border border-gray-300 py-1.5 text-base leading-5 font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </form>

                                        <div class="absolute top-0 right-0">
                                            <form action="{{ route('frontend.cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span>In stock</span>
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="py-12 text-center">
                            <p class="text-gray-500">Your cart is empty.</p>
                            <div class="mt-6">
                                <a href="{{ route('frontend.home') }}" class="text-indigo-600 font-medium hover:text-indigo-500">Continue Shopping &rarr;</a>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </section>

            <!-- Order summary -->
            <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">${{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="flex items-center text-sm text-gray-600">
                            <span>Shipping estimate</span>
                        </dt>
                        <dd class="text-sm font-medium text-gray-900">$0.00</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="text-base font-medium text-gray-900">Order total</dt>
                        <dd class="text-base font-medium text-gray-900">${{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="{{ route('frontend.checkout.index') }}" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500 text-center block">
                        Checkout
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
