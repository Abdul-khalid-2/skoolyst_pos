<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Engine Components | MD Autos</title>
    
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
        .transition-slow {
            transition: all 0.5s ease;
        }
        
        .text-gradient {
            background: linear-gradient(90deg, #0ea5e9, #0c4a6e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .product-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        
        .product-gallery img {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .product-gallery img:hover {
            opacity: 0.8;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
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
                    <img class="h-12 w-auto" src="{{ asset('backend/assets/images/MDLogo.jpg') }}" alt="MD Autos Logo">
                </div>
                
                <!-- Nav items -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        Home
                    </a>
                    <a href="#products" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        Products
                    </a>
                    <a href="#about" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        About
                    </a>
                    <a href="#contact" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        Contact
                    </a>
                    <a href="{{ route('login') }}" class="ml-4 px-4 py-2 rounded-md bg-secondary-600 text-white font-medium hover:bg-secondary-700 transition-slow">
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
    </nav>

    <!-- Product Detail Section -->
    <section class="pt-32 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6 text-sm text-gray-600">
                <a href="" class="hover:text-primary-600">Home</a> 
                <span class="mx-2">/</span>
                <a href="" class="hover:text-primary-600">Products</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 font-medium">Engine Components</span>
            </div>
            
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Product Images -->
                <div class="lg:w-1/2">
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <img id="main-image" src="{{ asset('backend/assets/images/Engine_Components.jpg') }}" 
                             alt="Engine Components" class="w-full h-96 object-contain rounded-lg">
                        
                        <div class="product-gallery">
                            <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}" 
                                 alt="Engine Components" class="border rounded-md h-20 object-cover" 
                                 onclick="changeImage(this.src)">
                            <img src="{{ asset('backend/assets/images/engine_part1.jpg') }}" 
                                 alt="Engine Part 1" class="border rounded-md h-20 object-cover" 
                                 onclick="changeImage(this.src)">
                            <img src="{{ asset('backend/assets/images/engine_part2.jpg') }}" 
                                 alt="Engine Part 2" class="border rounded-md h-20 object-cover" 
                                 onclick="changeImage(this.src)">
                            <img src="{{ asset('backend/assets/images/engine_part3.jpg') }}" 
                                 alt="Engine Part 3" class="border rounded-md h-20 object-cover" 
                                 onclick="changeImage(this.src)">
                        </div>
                    </div>
                    
                    <!-- Product badges -->
                    <div class="flex flex-wrap gap-3 mt-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> In Stock
                        </span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            <i class="fas fa-truck mr-1"></i> Free Shipping
                        </span>
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                            <i class="fas fa-shield-alt mr-1"></i> 1 Year Warranty
                        </span>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="lg:w-1/2">
                    <h1 class="text-3xl font-bold mb-2">Heavy Duty Engine Components Kit</h1>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-gray-600 text-sm">4.7 (24 reviews)</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i> 15 in stock
                        </span>
                    </div>
                    
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-gray-900">$249.99</span>
                        <span class="ml-2 text-lg text-gray-500 line-through">$299.99</span>
                        <span class="ml-2 bg-red-100 text-red-800 text-sm font-medium px-2 py-0.5 rounded">17% OFF</span>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Key Features:</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                <span>Compatible with all major heavy vehicle brands</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                <span>Manufactured from high-grade materials</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                <span>Precision engineered for optimal performance</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                <span>Corrosion resistant coating</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                <span>Includes all necessary gaskets and seals</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Compatibility:</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">Volvo</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">Scania</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">Mercedes</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">MAN</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">DAF</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <div class="mr-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <div class="flex border rounded-md">
                                <button class="px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200" onclick="updateQuantity(-1)">-</button>
                                <input type="number" id="quantity" value="1" min="1" class="w-12 text-center border-0 focus:ring-0">
                                <button class="px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200" onclick="updateQuantity(1)">+</button>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <button class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition-slow">
                                <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-truck text-xl mr-3 text-primary-600"></i>
                            <div>
                                <p class="font-medium">Free Delivery</p>
                                <p class="text-sm">Estimated delivery 2-4 business days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Tabs -->
            <div class="mt-16">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="openTab('description')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-primary-500 text-primary-600">
                            Description
                        </button>
                        <button onclick="openTab('specifications')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Specifications
                        </button>
                        <button onclick="openTab('reviews')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Reviews (24)
                        </button>
                        <button onclick="openTab('shipping')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Shipping & Returns
                        </button>
                    </nav>
                </div>
                
                <div class="py-8">
                    <!-- Description Tab -->
                    <div id="description" class="tab-content active">
                        <h3 class="text-xl font-bold mb-4">Product Description</h3>
                        <p class="text-gray-600 mb-6">
                            Our Heavy Duty Engine Components Kit is designed for professional mechanics and fleet owners who demand reliability and performance. This comprehensive kit includes all the essential components needed for engine maintenance and repair of heavy vehicles.
                        </p>
                        <p class="text-gray-600 mb-6">
                            Each component is manufactured to exact OEM specifications using premium materials that withstand the toughest operating conditions. The kit includes pistons, connecting rods, bearings, gaskets, and seals - all precision-engineered for perfect fit and optimal performance.
                        </p>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium mb-2">Kit Includes:</h4>
                                <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                    <li>Piston set (6 cylinders)</li>
                                    <li>Connecting rods</li>
                                    <li>Main bearings</li>
                                    <li>Rod bearings</li>
                                    <li>Complete gasket set</li>
                                    <li>Seal kit</li>
                                    <li>Thrust washers</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-medium mb-2">Benefits:</h4>
                                <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                    <li>Extended engine life</li>
                                    <li>Improved fuel efficiency</li>
                                    <li>Reduced oil consumption</li>
                                    <li>Lower emissions</li>
                                    <li>Quieter operation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div id="specifications" class="tab-content">
                        <h3 class="text-xl font-bold mb-4">Technical Specifications</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Part Number</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">EC-7890-HD</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Material</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">High-grade aluminum alloy, steel</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Weight</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18.5 kg</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Warranty</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 year or 50,000 km</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Manufacturer</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">MD Autos Premium Parts</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Country of Origin</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Germany</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Reviews Tab -->
                    <div id="reviews" class="tab-content">
                        <h3 class="text-xl font-bold mb-6">Customer Reviews</h3>
                        
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="mr-4">
                                    <span class="text-4xl font-bold">4.7</span>
                                    <span class="text-gray-500">/5</span>
                                </div>
                                <div>
                                    <div class="flex items-center mb-1">
                                        <div class="flex text-yellow-400 mr-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="text-sm text-gray-600">Based on 24 reviews</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                        <span>93% of customers recommend this product</span>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                                <i class="fas fa-pen mr-2"></i> Write a Review
                            </button>
                        </div>
                        
                        <div class="space-y-8">
                            <!-- Review 1 -->
                            <div class="border-b pb-6">
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 mr-3">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="font-medium">Excellent quality</h4>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span>By Ali K. on October 12, 2023</span>
                                    <span class="mx-2">•</span>
                                    <span>Verified Purchase</span>
                                </div>
                                <p class="text-gray-600">
                                    These engine components exceeded my expectations. The fit was perfect and the quality is superior to OEM parts I've used in the past. My truck is running smoother than ever.
                                </p>
                            </div>
                            
                            <!-- Review 2 -->
                            <div class="border-b pb-6">
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 mr-3">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="font-medium">Great value for money</h4>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span>By Usman M. on September 28, 2023</span>
                                    <span class="mx-2">•</span>
                                    <span>Verified Purchase</span>
                                </div>
                                <p class="text-gray-600">
                                    I was hesitant at first because of the price, but these parts are worth every penny. The complete kit saved me time and money compared to buying individual components.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping Tab -->
                    <div id="shipping" class="tab-content">
                        <h3 class="text-xl font-bold mb-4">Shipping & Returns</h3>
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-medium mb-3">Shipping Information</h4>
                                <ul class="space-y-3 text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-truck text-primary-600 mt-1 mr-3"></i>
                                        <span>Free standard shipping on all orders</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-clock text-primary-600 mt-1 mr-3"></i>
                                        <span>Processing time: 1-2 business days</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-map-marker-alt text-primary-600 mt-1 mr-3"></i>
                                        <span>Delivery time: 2-5 business days depending on location</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-box-open text-primary-600 mt-1 mr-3"></i>
                                        <span>International shipping available with additional charges</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-medium mb-3">Return Policy</h4>
                                <ul class="space-y-3 text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-undo text-primary-600 mt-1 mr-3"></i>
                                        <span>30-day money back guarantee</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-tag text-primary-600 mt-1 mr-3"></i>
                                        <span>Items must be unused and in original packaging</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-exchange-alt text-primary-600 mt-1 mr-3"></i>
                                        <span>Free returns for defective items</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-info-circle text-primary-600 mt-1 mr-3"></i>
                                        <span>Contact us within 7 days of delivery for returns</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-8">Related Products</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Related Product 1 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                        <img src="{{ asset('backend/assets/images/brake_system.jpg') }}" 
                             alt="Brake System" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">Brake System Kit</h3>
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400 mr-1 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-gray-500 text-sm">(18)</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-lg font-bold text-gray-900">$189.99</span>
                                <span class="ml-2 text-sm text-gray-500 line-through">$219.99</span>
                            </div>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                                View Details <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Related Product 2 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                        <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}" 
                             alt="Suspension Parts" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">Suspension Kit</h3>
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400 mr-1 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-gray-500 text-sm">(32)</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-lg font-bold text-gray-900">$279.99</span>
                            </div>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                                View Details <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Related Product 3 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                        <img src="{{ asset('backend/assets/images/cooling_system.jpg') }}" 
                             alt="Cooling System" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">Cooling System Kit</h3>
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400 mr-1 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="text-gray-500 text-sm">(12)</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-lg font-bold text-gray-900">$159.99</span>
                                <span class="ml-2 text-sm text-gray-500 line-through">$199.99</span>
                            </div>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                                View Details <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-slow">Home</a></li>
                        <li><a href="#products" class="text-gray-400 hover:text-white transition-slow">Products</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-slow">About Us</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-slow">Contact</a></li>
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
        
        // Change product image
        function changeImage(src) {
            document.getElementById('main-image').src = src;
        }
        
        // Update quantity
        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);
            quantity += change;
            if (quantity < 1) quantity = 1;
            quantityInput.value = quantity;
        }
        
        // Tab functionality
        function openTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-primary-500', 'text-primary-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabId).classList.add('active');
            
            // Add active class to clicked tab button
            event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
            event.currentTarget.classList.add('border-primary-500', 'text-primary-600');
        }
        
        // Navbar shadow on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
    </script>
</body>
</html>