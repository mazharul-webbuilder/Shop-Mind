@extends('frontend.layout.master')

@section('title', 'My Orders - ShopMind')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:pb-24 lg:px-8">
        <div class="max-w-xl">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">Order history</h1>
            <p class="mt-2 text-sm text-gray-500">Check the status of recent orders, manage returns, and download invoices.</p>
        </div>

        <div class="mt-16">
            <h2 class="sr-only">Recent orders</h2>

            <div class="space-y-20">
                @forelse($orders as $order)
                    <div>
                        <div class="bg-gray-50 rounded-lg py-6 px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-6 lg:space-x-8">
                            <dl class="divide-y divide-gray-200 space-y-4 text-sm text-gray-600 flex-auto md:divide-y-0 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-4 lg:w-1/2 lg:flex-none lg:gap-x-8">
                                <div class="flex justify-between md:block">
                                    <dt class="font-medium text-gray-900">Date placed</dt>
                                    <dd class="md:mt-1">
                                        <time datetime="{{ $order->created_at->format('Y-m-d') }}">{{ $order->created_at->format('M d, Y') }}</time>
                                    </dd>
                                </div>
                                <div class="flex justify-between pt-4 md:block md:pt-0">
                                    <dt class="font-medium text-gray-900">Order number</dt>
                                    <dd class="md:mt-1">{{ $order->order_number }}</dd>
                                </div>
                                <div class="flex justify-between pt-4 md:block md:pt-0">
                                    <dt class="font-medium text-gray-900">Total amount</dt>
                                    <dd class="md:mt-1 font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</dd>
                                </div>
                            </dl>
                            <div class="mt-6 flex items-center space-x-4 divide-x divide-gray-200 border-t border-gray-200 pt-4 text-sm font-medium sm:ml-4 sm:mt-0 sm:border-none sm:pt-0">
                                <div class="flex-1 flex justify-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 uppercase">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <table class="mt-4 w-full text-gray-500 sm:mt-6">
                            <caption class="sr-only">Products</caption>
                            <thead class="sr-only text-sm text-gray-500 text-left sm:not-only">
                                <tr>
                                    <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">Product</th>
                                    <th scope="col" class="hidden w-1/5 pr-8 py-3 font-normal sm:table-cell">Price</th>
                                    <th scope="col" class="hidden pr-8 py-3 font-normal sm:table-cell">Status</th>
                                    <th scope="col" class="w-0 py-3 font-normal text-right">Info</th>
                                </tr>
                            </thead>
                            <tbody class="border-b border-gray-200 divide-y divide-gray-200 text-sm">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="py-6 pr-8">
                                            <div class="flex items-center">
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-center object-cover rounded mr-6">
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                                    <div class="mt-1 sm:hidden">${{ number_format($item->price, 2) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hidden py-6 pr-8 sm:table-cell">${{ number_format($item->price, 2) }} x {{ $item->quantity }}</td>
                                        <td class="hidden py-6 pr-8 sm:table-cell">{{ ucfirst($order->status) }}</td>
                                        <td class="py-6 font-medium text-right whitespace-nowrap">
                                            <a href="{{ route('frontend.product.show', $item->product->slug) }}" class="text-indigo-600 hover:text-indigo-500">View product<span class="hidden lg:inline"> again</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">You haven't placed any orders yet.</p>
                        <a href="{{ route('frontend.home') }}" class="mt-6 inline-block text-indigo-600 font-medium hover:text-indigo-500">Start shopping &rarr;</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
