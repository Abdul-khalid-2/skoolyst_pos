
<x-website-layout>


    <!-- Features Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Quality Assurance</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        We provide only genuine OEM and high-quality aftermarket parts that enhance your vehicle's performance
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Fast Delivery</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Nationwide express shipping with same-day dispatch on orders placed before 3PM
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">24/7 Support</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Our expert team is available round the clock to answer your queries and provide guidance
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section - NEW DESIGN -->
    <section id="categories" class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3 dark:text-white">Products <span class="text-gradient">Categories</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Browse our premium quality parts organized by category
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Category 1 -->
                <div class="category-card shadow-md">
                    <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}" 
                         alt="Engine Components" class="category-image">
                    <div class="category-overlay">
                        <h3 class="text-xl font-bold">Engine Components</h3>
                        <div class="category-count">42 products</div>
                        <p class="text-sm mt-2 opacity-90">All critical engine parts for peak performance</p>
                        <a href="{{ route('product_details') }}" class="category-button">
                            Explore <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Category 2 -->
                <div class="category-card shadow-md">
                    <img src="{{ asset('backend/assets/images/brake_system.jpg') }}" 
                         alt="Brake System" class="category-image">
                    <div class="category-overlay">
                        <h3 class="text-xl font-bold">Brake System</h3>
                        <div class="category-count">28 products</div>
                        <p class="text-sm mt-2 opacity-90">High-quality brake components for safety</p>
                        <a href="{{ route('product_details') }}" class="category-button">
                            Explore <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Category 3 -->
                <div class="category-card shadow-md">
                    <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}" 
                         alt="Suspension Parts" class="category-image">
                    <div class="category-overlay">
                        <h3 class="text-xl font-bold">Suspension Parts</h3>
                        <div class="category-count">35 products</div>
                        <p class="text-sm mt-2 opacity-90">Premium components for smoother rides</p>
                        <a href="{{ route('product_details') }}" class="category-button">
                            Explore <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3 dark:text-white">Our <span class="text-gradient">Products</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Premium quality parts for all major heavy vehicle brands
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
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

                <!-- Product 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                    <div class="relative product-image-container">
                        <img src="{{ asset('backend/assets/images/brake_system.jpg') }}"
                            alt="Brake System" class="w-full h-48 object-cover">
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
                        <div class="availability-badge available">In Stock</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 dark:text-white">Brake System</h3>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">$79.99</span>
                            <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                    <div class="relative product-image-container">
                        <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}"
                            alt="Suspension Parts" class="w-full h-48 object-cover">
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
                        <div class="discount-badge">20% OFF</div>
                        <div class="availability-badge available">In Stock</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 dark:text-white">Suspension Parts</h3>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">$219.99</span>
                            <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('our_products') }}" class="inline-flex items-center px-8 py-3 border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white rounded-md font-medium transition-slow dark:border-primary-500 dark:text-primary-500 dark:hover:bg-primary-500 dark:hover:text-white">
                    View All Products <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}" 
                         alt="About MD Autos" class="rounded-xl shadow-md w-full">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-6">About <span class="text-gradient">MD Autos</span></h2>
                    <p class="text-gray-600 mb-4">
                        MD Autos is a leading supplier of heavy vehicle parts with decades of experience in the automotive industry. Our mission is to provide our customers with the highest quality parts at competitive prices.
                    </p>
                    <p class="text-gray-600 mb-6">
                        Our team of experienced professionals will help you find the right parts for your specific needs. We source parts only from authorized and trusted manufacturers to ensure you receive the best products available.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Genuine OEM and premium aftermarket parts</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Competitive pricing with volume discounts</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Fast nationwide delivery</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Expert technical advice and support</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="#contact" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-md font-medium transition-slow">
                            Get in Touch <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3 dark:text-white">Customer <span class="text-gradient">Testimonials</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    What our valued customers say about us
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        "I've been purchasing parts from MD Autos for years. Their quality and service are unmatched in the industry."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold dark:text-white">Ali Khan</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Transport Company Owner</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        "Their parts last longer than competitors' and the prices are reasonable. Delivery is always on time."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold dark:text-white">Ahmed Raza</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Fleet Maintenance Manager</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        "Whenever I need parts for my trucks, MD Autos is my first choice. Their technical support is excellent."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold dark:text-white">Usman Malik</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Logistics Operator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-website-layout>