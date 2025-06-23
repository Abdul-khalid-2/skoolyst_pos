<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MD Autos | Heavy Vehicle Parts Catalog</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .transition-slow {
            transition: all 0.5s ease;
        }
        
        .text-gradient {
            background: linear-gradient(90deg, #0ea5e9, #0c4a6e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        /* Custom checkbox style */
        .custom-checkbox input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }
        
        .custom-checkbox label {
            position: relative;
            cursor: pointer;
            padding-left: 30px;
        }
        
        .custom-checkbox label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 4px;
            background: white;
        }
        
        .custom-checkbox input[type="checkbox"]:checked + label:before {
            background: #0ea5e9;
            border-color: #0ea5e9;
        }
        
        .custom-checkbox label:after {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 5px;
            top: 2px;
            font-size: 12px;
            color: white;
            opacity: 0;
        }
        
        .custom-checkbox input[type="checkbox"]:checked + label:after {
            opacity: 1;
        }
        
        /* Custom radio button */
        .custom-radio input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .custom-radio label {
            position: relative;
            cursor: pointer;
            padding-left: 30px;
        }
        
        .custom-radio label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            background: white;
        }
        
        .custom-radio input[type="radio"]:checked + label:before {
            border-color: #0ea5e9;
        }
        
        .custom-radio label:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 6px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #0ea5e9;
            opacity: 0;
        }
        
        .custom-radio input[type="radio"]:checked + label:after {
            opacity: 1;
        }
        
        /* Star rating */
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: left;
        }
        
        .rating > span {
            display: inline-block;
            position: relative;
            width: 1.1em;
            color: #ddd;
        }
        
        .rating > span:hover:before,
        .rating > span:hover ~ span:before {
            content: "\2605";
            position: absolute;
            color: #f8d64e;
        }
        
        .rating > span.active:before,
        .rating > span.active ~ span:before {
            content: "\2605";
            position: absolute;
            color: #f8d64e;
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-800">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50 transition-slow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <img class="h-12 w-auto" src="{{ asset('backend/assets/images/MDLogo.jpg') }}" alt="MD Autos Logo">&nbsp;&nbsp; <span style="font-size: 30px;color:#0ea5e9;margin-bottom:-2%"> MD-Autos</span> 
                </div>
                
                <!-- Nav items -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        Home
                    </a>
                    <a href="/" class="px-4 py-2 rounded-md text-primary-600 font-medium hover:bg-gray-100 transition-slow">
                        Products
                    </a>
                    <a href="/" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        About
                    </a>
                    <a href="/" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        Contact
                    </a>
                    <a href="/" class="ml-4 px-4 py-2 rounded-md bg-secondary-600 text-white font-medium hover:bg-secondary-700 transition-slow">
                        Login
                    </a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 focus:outline-none transition-slow" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    Home
                </a>
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-primary-600 hover:bg-gray-100 transition-slow">
                    Products
                </a>
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    About
                </a>
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    Contact
                </a>
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-secondary-600 hover:bg-secondary-700 transition-slow">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="pt-24 pb-16 md:pt-32 md:pb-24 bg-primary-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Our Products</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Premium quality parts for all major heavy vehicle brands
                </p>
                <div class="flex justify-center">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="/" class="inline-flex items-center text-sm font-medium text-primary-200 hover:text-white">
                                    <i class="fas fa-home mr-2"></i>
                                    Home
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <span class="ml-1 text-sm font-medium text-white md:ml-2">Products</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="md:w-1/4">
                    <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24">
                        <!-- Search -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4">Search Products</h3>
                            <div class="relative">
                                <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4">Categories</h3>
                            <div class="space-y-2">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="engine-parts" checked>
                                    <label for="engine-parts" class="text-gray-700 hover:text-primary-600">Engine Parts</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="brake-system">
                                    <label for="brake-system" class="text-gray-700 hover:text-primary-600">Brake System</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="suspension">
                                    <label for="suspension" class="text-gray-700 hover:text-primary-600">Suspension</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="transmission">
                                    <label for="transmission" class="text-gray-700 hover:text-primary-600">Transmission</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="electrical">
                                    <label for="electrical" class="text-gray-700 hover:text-primary-600">Electrical</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="cooling">
                                    <label for="cooling" class="text-gray-700 hover:text-primary-600">Cooling System</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Brands -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4">Brands</h3>
                            <div class="space-y-2">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="volvo">
                                    <label for="volvo" class="text-gray-700 hover:text-primary-600">Volvo</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="scania">
                                    <label for="scania" class="text-gray-700 hover:text-primary-600">Scania</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="mercedes">
                                    <label for="mercedes" class="text-gray-700 hover:text-primary-600">Mercedes</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="man">
                                    <label for="man" class="text-gray-700 hover:text-primary-600">MAN</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="hino">
                                    <label for="hino" class="text-gray-700 hover:text-primary-600">Hino</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4">Price Range</h3>
                            <div class="mb-4">
                                <div id="price-slider" class="mb-4"></div>
                                <div class="flex justify-between">
                                    <span id="price-min" class="text-sm text-gray-600">Rs. 500</span>
                                    <span id="price-max" class="text-sm text-gray-600">Rs. 50,000</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Availability -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4">Availability</h3>
                            <div class="space-y-2">
                                <div class="custom-radio">
                                    <input type="radio" id="in-stock" name="availability" checked>
                                    <label for="in-stock" class="text-gray-700 hover:text-primary-600">In Stock</label>
                                </div>
                                <div class="custom-radio">
                                    <input type="radio" id="out-of-stock" name="availability">
                                    <label for="out-of-stock" class="text-gray-700 hover:text-primary-600">Out of Stock</label>
                                </div>
                                <div class="custom-radio">
                                    <input type="radio" id="all" name="availability">
                                    <label for="all" class="text-gray-700 hover:text-primary-600">All Products</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Rating -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4">Customer Rating</h3>
                            <div class="space-y-2">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="rating-5">
                                    <label for="rating-5" class="text-gray-700 hover:text-primary-600">
                                        <div class="rating">
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="rating-4">
                                    <label for="rating-4" class="text-gray-700 hover:text-primary-600">
                                        <div class="rating">
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span>★</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="rating-3">
                                    <label for="rating-3" class="text-gray-700 hover:text-primary-600">
                                        <div class="rating">
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span class="active">★</span>
                                            <span>★</span>
                                            <span>★</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <button class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                            Apply Filters
                        </button>
                        <button class="w-full mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md transition-slow">
                            Reset Filters
                        </button>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="md:w-3/4">
                    <!-- Sorting and View Options -->
                    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <span class="text-gray-600">Showing 1-12 of 86 products</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <span class="text-gray-600 mr-2">Sort by:</span>
                                <select class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <option>Featured</option>
                                    <option>Price: Low to High</option>
                                    <option>Price: High to Low</option>
                                    <option>Newest</option>
                                    <option>Best Selling</option>
                                    <option>Customer Rating</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="p-2 rounded-md bg-primary-100 text-primary-600">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="p-2 rounded-md hover:bg-gray-100">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Products -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Product 1 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}" alt="Turbocharger" class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-secondary-600 text-white text-xs font-bold px-2 py-1 rounded-full">NEW</span>
                                </div>
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Turbocharger</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.8</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">For Volvo, Scania, Mercedes</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 24,500</span> --}}
                                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 2 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/brake_system.jpg') }}" alt="Brake Pads" class="w-full h-48 object-cover">
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Brake Pads Set</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.5</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">For Hino, MAN, Isuzu</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 8,750</span> --}}
                                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 3 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}" alt="Shock Absorber" class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full">BESTSELLER</span>
                                </div>
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Shock Absorber</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.9</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">Heavy Duty for All Models</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 12,300</span> --}}
                                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 4 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}" alt="Fuel Injector" class="w-full h-48 object-cover">
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Fuel Injector</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.7</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">For Volvo D13 Engine</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 32,000</span> --}}
                                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 5 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/brake_system.jpg') }}" alt="Air Brake Chamber" class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-secondary-600 text-white text-xs font-bold px-2 py-1 rounded-full">SALE</span>
                                </div>
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Air Brake Chamber</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.6</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">Standard & Long Stroke</p>
                                <div class="flex justify-between items-center">
                                    <div>
                                        {{-- <span class="text-lg font-bold text-primary-600">Rs. 6,500</span> --}}
                                        <span class="text-sm text-gray-500 line-through ml-2">Rs. 7,800</span>
                                    </div>
                                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 6 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}" alt="Leaf Spring" class="w-full h-48 object-cover">
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Leaf Spring Set</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.4</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">Heavy Duty for Trailers</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 18,200</span> --}}
                                    <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full">Low Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 7 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}" alt="Water Pump" class="w-full h-48 object-cover">
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Water Pump</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.3</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">For Scania, Mercedes, MAN</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 9,800</span> --}}
                                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 8 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/brake_system.jpg') }}" alt="Brake Drum" class="w-full h-48 object-cover">
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Brake Drum</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.5</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">Heavy Duty Cast Iron</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 14,500</span> --}}
                                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 9 -->
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-slow">
                            <div class="relative">
                                <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}" alt="Tie Rod End" class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-secondary-600 text-white text-xs font-bold px-2 py-1 rounded-full">LIMITED</span>
                                </div>
                                <div class="absolute top-2 left-2">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-primary-100 hover:text-primary-600 transition-slow">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold">Tie Rod End</h3>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-gray-600 ml-1">4.2</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">For All Heavy Vehicles</p>
                                <div class="flex justify-between items-center">
                                    {{-- <span class="text-lg font-bold text-primary-600">Rs. 3,200</span> --}}
                                    <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full">Only 3 Left</span>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    {{-- <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button> --}}
                                    
                                    <a href="{{ route('product_details') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md transition-slow">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        <nav class="inline-flex rounded-md shadow-sm">
                            <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-primary-600 font-medium">1</a>
                            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">2</a>
                            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">3</a>
                            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">4</a>
                            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">5</a>
                            <a href="#" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-primary-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Can't Find What You're Looking For?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Our inventory is constantly updated. Contact us with your part requirements and we'll source it for you.
            </p>
            <a href="/" class="inline-flex items-center px-8 py-3 bg-white hover:bg-gray-100 text-primary-600 rounded-md font-medium transition-slow">
                Contact Our Team <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h4 class="text-xl font-bold mb-4">MD AUTOS</h4>
                    <p class="text-gray-400 mb-4">
                        Your trusted supplier of heavy vehicle parts and components
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-slow">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-slow">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-slow">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-slow">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-400 hover:text-white transition-slow">Home</a></li>
                        <li><a href="/" class="text-gray-400 hover:text-white transition-slow">Products</a></li>
                        <li><a href="/" class="text-gray-400 hover:text-white transition-slow">About Us</a></li>
                        <li><a href="/" class="text-gray-400 hover:text-white transition-slow">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Products -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Products</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-slow">Engine Parts</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-slow">Brake System</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-slow">Suspension</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-slow">Transmission</a></li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Newsletter</h4>
                    <p class="text-gray-400 mb-4">
                        Subscribe to our newsletter for the latest offers and updates
                    </p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 w-full rounded-l-md focus:outline-none text-gray-900">
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-r-md transition-slow">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">
                    &copy; 2025 MD Autos. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-slow">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-slow">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.querySelector('[aria-controls="mobile-menu"]').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        
        // Navbar shadow on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
        
        // Initialize price slider (you would need to include a slider library like noUiSlider for this to work)
        // This is just a placeholder for the functionality
        function initPriceSlider() {
            // In a real implementation, you would initialize a slider here
            console.log("Price slider would be initialized here");
            document.getElementById('price-min').textContent = "Rs. 500";
            document.getElementById('price-max').textContent = "Rs. 50,000";
        }
        
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            initPriceSlider();
            
            // Rating stars interaction
            document.querySelectorAll('.rating span').forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.parentElement;
                    const stars = rating.querySelectorAll('span');
                    const clickedIndex = Array.from(stars).indexOf(this);
                    
                    stars.forEach((s, index) => {
                        if (index <= clickedIndex) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>