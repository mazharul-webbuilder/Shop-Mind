<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ShopMind - Ecommerce')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='0.9em' font-size='80' text-anchor='middle' x='50'%3E🛍️%3C/text%3E%3C/svg%3E">
    <link rel="apple-touch-icon"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='0.9em' font-size='80' text-anchor='middle' x='50'%3E🛍️%3C/text%3E%3C/svg%3E">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="/" class="text-2xl font-bold text-indigo-600">
                                ShopMind
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('frontend.home') }}"
                                class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('frontend.home') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                Home
                            </a>
                            <a href="{{ route('frontend.home') }}#shop"
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Shop
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <a href="{{ route('frontend.cart.index') }}" id="cart-trigger-btn"
                            class="text-gray-500 hover:text-gray-700 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span id="cart-badge-count"
                                class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
                        </a>

                        @auth
                            <!-- User Dropdown -->
                            <div class="relative" id="user-menu-wrapper">
                                <button id="user-menu-btn" type="button"
                                    class="flex items-center rounded-full p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition-colors duration-150"
                                    aria-haspopup="true" aria-expanded="false">
                                    <!-- Avatar Icon -->
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>

                                <!-- Dropdown Panel -->
                                <div id="user-menu-dropdown"
                                    class="absolute right-0 mt-2 w-52 origin-top-right rounded-2xl bg-white shadow-xl ring-1 ring-black/5 focus:outline-none invisible opacity-0 scale-95 transition-all duration-150 ease-out z-50"
                                    role="menu" aria-orientation="vertical">
                                    <!-- User info header -->
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Signed in as
                                        </p>
                                        <p class="text-sm font-semibold text-gray-800 truncate mt-0.5">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>

                                    <!-- Menu items -->
                                    <div class="py-1.5">
                                        <a href="{{ route('frontend.orders.index') }}"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                                            role="menuitem">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            My Orders
                                        </a>
                                    </div>

                                    <!-- Logout -->
                                    <div class="border-t border-gray-100 py-1.5">
                                        <form method="POST" action="{{ route('frontend.logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                                role="menuitem">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Guest Auth Buttons -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('frontend.login') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors duration-150">
                                    Sign in
                                </a>
                                <a href="{{ route('frontend.register') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors duration-150">
                                    Get started
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} ShopMind. All rights reserved.
                    </div>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-gray-500">About</a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">Contact</a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mini Cart Drawer -->
    <div id="mini-cart-drawer" class="fixed inset-0 z-50 invisible transition-all duration-300" style="display: none;"
        aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div id="mini-cart-backdrop"
            class="fixed inset-0 bg-gray-500/0 backdrop-blur-none transition-all duration-300 pointer-events-none"
            aria-hidden="true"></div>

        <div id="mini-cart-wrapper" class="fixed inset-0 overflow-hidden cursor-pointer">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <!-- Panel -->
                    <div id="mini-cart-panel"
                        class="pointer-events-auto w-screen max-w-md translate-x-full transform transition-all duration-300 ease-in-out bg-white shadow-2xl flex flex-col cursor-default"
                        style="height: 100vh; max-height: 100vh; display: flex; flex-direction: column;">
                        <!-- Header -->
                        <div class="px-6 py-6 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2" id="slide-over-title">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Your Shopping Cart
                            </h2>
                            <button type="button" id="close-mini-cart"
                                class="rounded-xl p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-50 transition-colors">
                                <span class="sr-only">Close panel</span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Items List Container -->
                        <div class="px-6 py-4 divide-y divide-gray-100" id="mini-cart-items-container"
                            style="flex: 1 1 0%; min-height: 0px; overflow-y: auto; scrollbar-gutter: stable;">
                            <div class="flex flex-col items-center justify-center h-full text-center py-10"
                                id="mini-cart-loading">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mb-4"></div>
                                <p class="text-gray-500 text-sm">Loading your cart...</p>
                            </div>
                        </div>

                        <!-- Footer & Actions -->
                        <div class="border-t border-gray-100 px-6 py-6 bg-slate-50 space-y-4">
                            <div class="flex justify-between text-base font-bold text-gray-900">
                                <span>Subtotal</span>
                                <span id="mini-cart-subtotal">$0.00</span>
                            </div>
                            <p class="text-xs text-gray-500">Shipping and taxes calculated at checkout.</p>
                            <div class="grid grid-cols-2 gap-3 pt-2">
                                <a href="{{ route('frontend.cart.index') }}"
                                    class="w-full flex items-center justify-center px-4 py-3 border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-all uppercase tracking-wider">
                                    View Cart
                                </a>
                                <a href="{{ route('frontend.checkout.index') }}"
                                    class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-all uppercase tracking-wider">
                                    Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.ai-support.bot')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartTrigger = document.getElementById('cart-trigger-btn');
            const drawer = document.getElementById('mini-cart-drawer');
            const backdrop = document.getElementById('mini-cart-backdrop');
            const panel = document.getElementById('mini-cart-panel');
            const closeBtn = document.getElementById('close-mini-cart');
            const itemsContainer = document.getElementById('mini-cart-items-container');
            const subtotalEl = document.getElementById('mini-cart-subtotal');
            const badgeEl = document.getElementById('cart-badge-count');

            // Local cache for the cart state (Stale-While-Revalidate)
            let localCartState = null;

            // Function to open drawer
            function openCart() {
                drawer.style.display = 'block';
                setTimeout(() => {
                    drawer.classList.remove('invisible');
                    backdrop.classList.remove('bg-gray-500/0', 'pointer-events-none');
                    backdrop.classList.add('bg-gray-500/50');
                    panel.classList.remove('translate-x-full');
                    panel.classList.add('translate-x-0');
                }, 10);
                fetchCart();
            }

            // Function to close drawer
            function closeCart() {
                backdrop.classList.remove('bg-gray-500/50');
                backdrop.classList.add('bg-gray-500/0', 'pointer-events-none');
                panel.classList.remove('translate-x-0');
                panel.classList.add('translate-x-full');
                setTimeout(() => {
                    drawer.classList.add('invisible');
                    drawer.style.display = 'none';
                }, 300);
            }

            // Event listeners
            if (cartTrigger) {
                cartTrigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    openCart();
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeCart);
            }

            if (backdrop) {
                backdrop.addEventListener('click', closeCart);
            }

            const wrapper = document.getElementById('mini-cart-wrapper');
            if (wrapper) {
                wrapper.addEventListener('click', function (e) {
                    // If the element has been detached from the DOM during render, or is within the panel, do not close the cart.
                    if (!document.body.contains(e.target) || panel.contains(e.target)) {
                        return;
                    }
                    closeCart();
                });
            }

            // Fetch Cart from Server (SWR pattern)
            function fetchCart(isBackground = false) {
                // If we have cached state, render it instantly to prevent layout shift or delay
                if (localCartState) {
                    renderCart(localCartState);
                } else if (!isBackground) {
                    // Show loading spinner ONLY if no cache is available and it's a manual open
                    itemsContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-center py-10" id="mini-cart-loading">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mb-4"></div>
                        <p class="text-gray-500 text-sm">Loading your cart...</p>
                    </div>
                `;
                }

                fetch('{{ route("frontend.cart.index") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localCartState = data.cart;
                            renderCart(data.cart);
                            updateBadge(data.cart_count);
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching cart:', err);
                        if (!localCartState && !isBackground) {
                            itemsContainer.innerHTML = `<p class="text-center text-red-500 py-6">Failed to load cart.</p>`;
                        }
                    });
            }

            // Pre-fetch cart on page load for instant drawer display when clicked
            fetchCart(true);

            // Update Header Badge Count
            function updateBadge(count) {
                if (badgeEl) {
                    badgeEl.innerText = count;
                }
            }

            // Render Cart HTML
            function renderCart(cart) {
                if (!cart.items || cart.items.length === 0) {
                    itemsContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">Your cart is empty</p>
                        <a href="/" class="mt-4 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                            Continue Shopping &rarr;
                        </a>
                    </div>
                `;
                    subtotalEl.innerText = '$0.00';
                    return;
                }

                let total = 0;
                let itemsHtml = '<div class="space-y-4 pt-2">';

                cart.items.forEach(item => {
                    const product = item.product;
                    if (!product) return;
                    const subtotal = item.quantity * product.price;
                    total += subtotal;

                    itemsHtml += `
                    <div class="flex items-center gap-4 py-4">
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl border border-gray-100 bg-gray-50">
                            <img src="${product.image}" alt="${product.name}" class="h-full w-full object-cover object-center">
                        </div>

                        <div class="flex flex-1 flex-col">
                            <div class="flex justify-between text-sm font-semibold text-gray-900">
                                <h3 class="line-clamp-1 hover:text-indigo-600">
                                    <a href="/product/${product.slug}">${product.name}</a>
                                </h3>
                                <p class="ml-4">$${(product.price * item.quantity).toFixed(2)}</p>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">$${Number(product.price).toFixed(2)} each</p>

                            <div class="flex flex-1 items-end justify-between text-sm mt-2">
                                <!-- Quantity Controls -->
                                <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50">
                                    <button type="button" class="px-2 py-1 text-gray-500 hover:text-gray-700 decrease-qty-btn" data-item-id="${item.id}" data-qty="${item.quantity}">
                                        -
                                    </button>
                                    <span class="px-3 text-xs font-bold text-gray-800">${item.quantity}</span>
                                    <button type="button" class="px-2 py-1 text-gray-500 hover:text-gray-700 increase-qty-btn" data-item-id="${item.id}" data-qty="${item.quantity}">
                                        +
                                    </button>
                                </div>

                                <!-- Remove Button -->
                                <button type="button" class="text-xs font-semibold text-red-500 hover:text-red-700 remove-item-btn flex items-center gap-1" data-item-id="${item.id}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                });

                itemsHtml += '</div>';
                itemsContainer.innerHTML = itemsHtml;
                subtotalEl.innerText = `$${total.toFixed(2)}`;

                // Attach event listeners
                document.querySelectorAll('.decrease-qty-btn').forEach(btn => {
                    btn.onclick = function () {
                        const itemId = this.dataset.itemId;
                        const currentQty = parseInt(this.dataset.qty);
                        if (currentQty > 1) {
                            updateQuantity(itemId, currentQty - 1);
                        } else {
                            removeItem(itemId);
                        }
                    };
                });

                document.querySelectorAll('.increase-qty-btn').forEach(btn => {
                    btn.onclick = function () {
                        const itemId = this.dataset.itemId;
                        const currentQty = parseInt(this.dataset.qty);
                        updateQuantity(itemId, currentQty + 1);
                    };
                });

                document.querySelectorAll('.remove-item-btn').forEach(btn => {
                    btn.onclick = function () {
                        removeItem(this.dataset.itemId);
                    };
                });
            }

            // Update Quantity via AJAX with Optimistic UI updates
            function updateQuantity(itemId, qty) {
                // Optimistic update
                if (localCartState && localCartState.items) {
                    const item = localCartState.items.find(i => i.id == itemId);
                    if (item) {
                        item.quantity = qty;
                        renderCart(localCartState);
                    }
                }

                fetch(`/cart/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: qty })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localCartState = data.cart;
                            renderCart(data.cart);
                            updateBadge(data.cart_count);
                        }
                    })
                    .catch(err => console.error('Error updating quantity:', err));
            }

            // Remove Item via AJAX with Optimistic UI updates
            function removeItem(itemId) {
                // Optimistic update
                if (localCartState && localCartState.items) {
                    localCartState.items = localCartState.items.filter(i => i.id != itemId);
                    renderCart(localCartState);
                }

                fetch(`/cart/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localCartState = data.cart;
                            renderCart(data.cart);
                            updateBadge(data.cart_count);
                        }
                    })
                    .catch(err => console.error('Error removing item:', err));
            }

            // Intercept all "Add to Cart" forms globally (Snappy UI + Button Loader)
            document.addEventListener('submit', function (e) {
                const form = e.target.closest('form');
                if (form && form.getAttribute('action') && form.getAttribute('action').includes('/cart/add')) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const submitBtn = form.querySelector('button[type="submit"]');

                    let originalText = '';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        originalText = submitBtn.innerHTML;
                        // Inject a clean spinner with mx-auto
                        submitBtn.innerHTML = `
                        <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    `;
                    }

                    // Snap the badge count up optimistically (+1) to feel instantly responsive
                    if (badgeEl) {
                        const currentCount = parseInt(badgeEl.innerText) || 0;
                        badgeEl.innerText = currentCount + 1;
                    }

                    fetch(form.getAttribute('action'), {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                            if (data.success) {
                                localCartState = data.cart;
                                updateBadge(data.cart_count);
                                renderCart(data.cart);
                                showToast(data.message || 'Product added to cart!');
                            }
                        })
                        .catch(err => {
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                            // Revert the optimistic badge addition on error
                            if (badgeEl) {
                                const currentCount = parseInt(badgeEl.innerText) || 1;
                                badgeEl.innerText = Math.max(0, currentCount - 1);
                            }
                            console.error('Error adding to cart:', err);
                            showToast('Failed to add product to cart.', 'error');
                        });
                }
            });

            // User menu dropdown toggle
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');
            const userMenuChevron = document.getElementById('user-menu-chevron');

            if (userMenuBtn && userMenuDropdown) {
                userMenuBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isOpen = !userMenuDropdown.classList.contains('invisible');
                    if (isOpen) {
                        closeUserMenu();
                    } else {
                        openUserMenu();
                    }
                });

                function openUserMenu() {
                    userMenuDropdown.classList.remove('invisible', 'opacity-0', 'scale-95');
                    userMenuDropdown.classList.add('opacity-100', 'scale-100');
                    userMenuBtn.setAttribute('aria-expanded', 'true');
                    if (userMenuChevron) userMenuChevron.classList.add('rotate-180');
                }

                function closeUserMenu() {
                    userMenuDropdown.classList.add('invisible', 'opacity-0', 'scale-95');
                    userMenuDropdown.classList.remove('opacity-100', 'scale-100');
                    userMenuBtn.setAttribute('aria-expanded', 'false');
                    if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');
                }

                // Close on outside click
                document.addEventListener('click', function (e) {
                    const wrapper = document.getElementById('user-menu-wrapper');
                    if (wrapper && !wrapper.contains(e.target)) {
                        closeUserMenu();
                    }
                });

                // Close on Escape
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeUserMenu();
                });
            }

            // Toast helper
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `fixed bottom-4 right-4 z-[60] px-4 py-3 rounded-xl shadow-lg text-sm font-semibold text-white transition-all duration-300 transform translate-y-10 opacity-0 flex items-center gap-2 ${type === 'error' ? 'bg-red-600' : 'bg-green-600'}`;
                toast.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'error' ? 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'}"></path>
                </svg>
                ${message}
            `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove('translate-y-10', 'opacity-0');
                }, 10);

                setTimeout(() => {
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        });
    </script>
</body>

</html>