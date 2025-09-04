<x-website-layout>

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
                        <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                            <div class="relative product-image-container">
                                <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}"
                                    alt="Engine Parts" class="w-full h-48 object-cover">
                                <div class="product-overlay">
                                    <button class="action-btn heart-btn" title="Add to wishlist">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <button class="action-btn view-btn" title="View details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn cart-btn" title="Add to cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                                <div class="discount-badge">10% OFF</div>
                                <div class="availability-badge available">In Stock</div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2 dark:text-white">Engine Components</h3>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">$149.99</span>
                                    <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm">
                                        View Details
                                    </button>
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
</x-website-layout>