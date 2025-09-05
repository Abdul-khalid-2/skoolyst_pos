<x-website-layout>
    @push('css')

    <style>
        .custom-checkbox,
        .custom-radio {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .custom-checkbox input[type="checkbox"],
        .custom-radio input[type="radio"] {
            margin-right: 0.5rem;
        }

        .rating span {
            color: #d1d5db;
        }

        .rating span.active {
            color: #f59e0b;
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
        }

        .product-image-container:hover .product-overlay {
            opacity: 1;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: #333;
            transition: all 0.3s ease;
            transform: translateY(10px);
            opacity: 0;
        }

        .product-image-container:hover .action-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .action-btn:hover {
            background: #0ea5e9;
            color: white;
        }

        .discount-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #ef4444;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            z-index: 10;
        }

        .availability-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            z-index: 10;
        }

        .available {
            background: #10b981;
            color: white;
        }

        .not-available {
            background: #6b7280;
            color: white;
        }
        
        .pagination-link {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
            color: #4b5563;
            transition: all 0.2s;
        }
        
        .pagination-link:hover {
            background-color: #f3f4f6;
        }
        
        .pagination-link.active {
            background-color: #0ea5e9;
            color: white;
            border-color: #0ea5e9;
        }
        
        .pagination-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
    @endpush
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
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm sticky top-24">
                        <!-- Search -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 dark:text-white">Search Products</h3>
                            <div class="relative">
                                <input type="text" id="search-input" placeholder="Search..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 dark:text-white">Categories</h3>
                            <div class="space-y-2" id="category-filters">
                                <!-- Categories will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 dark:text-white">Brands</h3>
                            <div class="space-y-2" id="brand-filters">
                                <!-- Brands will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 dark:text-white">Price Range</h3>
                            <div class="mb-4">
                                <div class="mb-2 flex justify-between">
                                    <span id="price-min-display" class="text-sm text-gray-600 dark:text-gray-300">Rs. 0</span>
                                    <span id="price-max-display" class="text-sm text-gray-600 dark:text-gray-300">Rs. 0</span>
                                </div>
                                <input type="range" id="price-min" min="0" max="100000" value="0" class="w-full mb-2">
                                <input type="range" id="price-max" min="0" max="100000" value="100000" class="w-full">
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 dark:text-white">Availability</h3>
                            <div class="space-y-2">
                                <div class="custom-radio">
                                    <input type="radio" id="availability-all" name="availability" value="all" checked>
                                    <label for="availability-all" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">All Products</label>
                                </div>
                                <div class="custom-radio">
                                    <input type="radio" id="availability-instock" name="availability" value="instock">
                                    <label for="availability-instock" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">In Stock</label>
                                </div>
                                <div class="custom-radio">
                                    <input type="radio" id="availability-outofstock" name="availability" value="outofstock">
                                    <label for="availability-outofstock" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">Out of Stock</label>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 dark:text-white">Customer Rating</h3>
                            <div class="space-y-2" id="rating-filters">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="rating-5" value="5">
                                    <label for="rating-5" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">
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
                                    <input type="checkbox" id="rating-4" value="4">
                                    <label for="rating-4" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">
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
                                    <input type="checkbox" id="rating-3" value="3">
                                    <label for="rating-3" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">
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

                        <button id="apply-filters" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition-slow">
                            Apply Filters
                        </button>
                        <button id="reset-filters" class="w-full mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md transition-slow dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            Reset Filters
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="md:w-3/4">
                    <!-- Sorting and View Options -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <span class="text-gray-600 dark:text-gray-300" id="product-count">Loading products...</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <span class="text-gray-600 dark:text-gray-300 mr-2">Sort by:</span>
                                <select id="sort-options" class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                                    <option value="featured">Featured</option>
                                    <option value="price-low">Price: Low to High</option>
                                    <option value="price-high">Price: High to Low</option>
                                    <option value="newest">Newest</option>
                                    <option value="rating">Customer Rating</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button id="grid-view" class="p-2 rounded-md bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button id="list-view" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Products Container -->
                    <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Products will be populated by JavaScript -->
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-spinner fa-spin text-3xl mb-3"></i>
                            <p>Loading products...</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="mt-12 flex justify-center hidden">
                        <div class="flex items-center space-x-2" id="pagination-container">
                            <!-- Pagination will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
    <script>
        // Global variables to store all products and filtered products
        let allProducts = [];
        let filteredProducts = [];
        let currentPage = 1;
        const productsPerPage = 12;
        let currentView = localStorage.getItem('productView') || 'grid'; // Get saved view or default to grid

        // DOM Ready
        $(document).ready(function() {
            // Set initial view state
            if (currentView === 'grid') {
                $('#grid-view').addClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
                $('#list-view').removeClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
            } else {
                $('#list-view').addClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
                $('#grid-view').removeClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
            }
            
            // Load all products data
            loadProductsData();

            // Initialize event listeners
            initEventListeners();
        });

        // Load all products data via AJAX
        function loadProductsData() {
            $.ajax({
                url: '{{ route("api.products.all") }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        allProducts = response.data.products;
                        filteredProducts = [...allProducts];
                        
                        // Populate filters
                        populateFilters(response.data.filters);
                        
                        // Render initial products
                        renderProducts();
                        
                        // Update product count
                        updateProductCount();
                    } else {
                        $('#products-container').html('<div class="text-center py-12 text-red-500">Error loading products. Please try again.</div>');
                    }
                },
                error: function() {
                    $('#products-container').html('<div class="text-center py-12 text-red-500">Error loading products. Please try again.</div>');
                }
            });
        }

        // Populate filter options
        function populateFilters(filters) {
            // Populate categories
            let categoriesHtml = '';
            filters.categories.forEach(category => {
                categoriesHtml += `
                <div class="custom-checkbox">
                    <input type="checkbox" id="category-${category.id}" value="${category.id}" class="filter-category">
                    <label for="category-${category.id}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">${category.name} (${category.count})</label>
                </div>
            `;
            });
            $('#category-filters').html(categoriesHtml);
            
            // Populate brands
            let brandsHtml = '';
            filters.brands.forEach(brand => {
                brandsHtml += `
                <div class="custom-checkbox">
                    <input type="checkbox" id="brand-${brand.id}" value="${brand.id}" class="filter-brand">
                    <label for="brand-${brand.id}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">${brand.name} (${brand.count})</label>
                </div>
            `;
            });
            $('#brand-filters').html(brandsHtml);
            
            // Set price range
            const minPrice = filters.price_range.min;
            const maxPrice = filters.price_range.max;
            $('#price-min').attr('min', minPrice).attr('max', maxPrice).val(minPrice);
            $('#price-max').attr('min', minPrice).attr('max', maxPrice).val(maxPrice);
            $('#price-min-display').text(`Rs. ${minPrice.toLocaleString()}`);
            $('#price-max-display').text(`Rs. ${maxPrice.toLocaleString()}`);
        }

        // Initialize event listeners
        function initEventListeners() {
            // Search input
            $('#search-input').on('input', debounce(function() {
                applyFilters();
            }, 300));
            
            // Category filters
            $(document).on('change', '.filter-category', applyFilters);
            
            // Brand filters
            $(document).on('change', '.filter-brand', applyFilters);
            
            // Price range
            $('#price-min, #price-max').on('input', function() {
                $('#price-min-display').text(`Rs. ${$('#price-min').val().toLocaleString()}`);
                $('#price-max-display').text(`Rs. ${$('#price-max').val().toLocaleString()}`);
                applyFilters();
            });
            
            // Availability
            $('input[name="availability"]').on('change', applyFilters);
            
            // Rating filters
            $('#rating-filters input').on('change', applyFilters);
            
            // Apply filters button
            $('#apply-filters').on('click', applyFilters);
            
            // Reset filters button
            $('#reset-filters').on('click', resetFilters);
            
            // Sort options
            $('#sort-options').on('change', applyFilters);
            
            // View options
            $('#grid-view').on('click', function() {
                currentView = 'grid';
                localStorage.setItem('productView', 'grid');
                $(this).addClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
                $('#list-view').removeClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
                renderProducts();
            });
            
            $('#list-view').on('click', function() {
                currentView = 'list';
                localStorage.setItem('productView', 'list');
                $(this).addClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
                $('#grid-view').removeClass('bg-primary-100 text-primary-600 dark:bg-primary-800 dark:text-primary-200');
                renderProducts();
            });
        }

        // Apply all filters
        function applyFilters() {
            // Get search term
            const searchTerm = $('#search-input').val().toLowerCase();
            
            // Get selected categories
            const selectedCategories = [];
            $('.filter-category:checked').each(function() {
                selectedCategories.push($(this).val());
            });
            
            // Get selected brands
            const selectedBrands = [];
            $('.filter-brand:checked').each(function() {
                selectedBrands.push($(this).val());
            });
            
            // Get price range
            const minPrice = parseInt($('#price-min').val());
            const maxPrice = parseInt($('#price-max').val());
            
            // Get availability
            const availability = $('input[name="availability"]:checked').val();
            
            // Get selected ratings
            const selectedRatings = [];
            $('#rating-filters input:checked').each(function() {
                selectedRatings.push(parseInt($(this).val()));
            });
            
            // Get sort option
            const sortOption = $('#sort-options').val();
            
            // Filter products
            filteredProducts = allProducts.filter(product => {
                // Search filter
                if (searchTerm && !product.name.toLowerCase().includes(searchTerm) && 
                    !product.description.toLowerCase().includes(searchTerm)) {
                    return false;
                }
                
                // Category filter
                if (selectedCategories.length > 0 && !selectedCategories.includes(product.category_id.toString())) {
                    return false;
                }
                
                // Brand filter
                if (selectedBrands.length > 0 && !selectedBrands.includes(product.brand_id.toString())) {
                    return false;
                }
                
                // Price filter - check against the minimum price of the product
                if (product.price.min < minPrice || product.price.min > maxPrice) {
                    return false;
                }
                
                // Availability filter
                if (availability === 'instock' && !product.in_stock) {
                    return false;
                }
                if (availability === 'outofstock' && product.in_stock) {
                    return false;
                }
                
                // Rating filter
                if (selectedRatings.length > 0) {
                    let ratingMatch = false;
                    for (const rating of selectedRatings) {
                        if (product.rating >= rating && product.rating < rating + 1) {
                            ratingMatch = true;
                            break;
                        }
                    }
                    if (!ratingMatch) return false;
                }
                
                return true;
            });
            
            // Sort products
            sortProducts(sortOption);
            
            // Reset to first page
            currentPage = 1;
            
            // Render products
            renderProducts();
            
            // Update product count
            updateProductCount();
        }

        // Sort products based on selected option
        function sortProducts(sortOption) {
            switch(sortOption) {
                case 'price-low':
                    filteredProducts.sort((a, b) => a.price.min - b.price.min);
                    break;
                case 'price-high':
                    filteredProducts.sort((a, b) => b.price.max - a.price.max);
                    break;
                case 'newest':
                    filteredProducts.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    break;
                case 'rating':
                    filteredProducts.sort((a, b) => b.rating - a.rating);
                    break;
                default: // featured
                    filteredProducts.sort((a, b) => b.featured - a.featured);
                    break;
            }
        }

        // Reset all filters
        function resetFilters() {
            $('#search-input').val('');
            $('.filter-category').prop('checked', false);
            $('.filter-brand').prop('checked', false);
            
            // Get the original price range from the first product or use defaults
            const minPrice = allProducts.length > 0 ? Math.min(...allProducts.map(p => p.price.min)) : 0;
            const maxPrice = allProducts.length > 0 ? Math.max(...allProducts.map(p => p.price.max)) : 100000;
            
            $('#price-min').attr('min', minPrice).attr('max', maxPrice).val(minPrice);
            $('#price-max').attr('min', minPrice).attr('max', maxPrice).val(maxPrice);
            $('#price-min-display').text(`Rs. ${minPrice.toLocaleString()}`);
            $('#price-max-display').text(`Rs. ${maxPrice.toLocaleString()}`);
            
            $('input[name="availability"][value="all"]').prop('checked', true);
            $('#rating-filters input').prop('checked', false);
            $('#sort-options').val('featured');
            
            filteredProducts = [...allProducts];
            currentPage = 1;
            
            renderProducts();
            updateProductCount();
        }

        // Render products based on current view and pagination
        function renderProducts() {
            const startIndex = (currentPage - 1) * productsPerPage;
            const endIndex = startIndex + productsPerPage;
            const productsToShow = filteredProducts.slice(startIndex, endIndex);
            
            let productsHtml = '';
            
            if (productsToShow.length === 0) {
                productsHtml = `
                <div class="col-span-3 text-center py-12 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-search fa-3x mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">No products found</h3>
                    <p>Try adjusting your filters or search terms</p>
                </div>
            `;
            } else {
                productsToShow.forEach(product => {
                    if (currentView === 'grid') {
                        productsHtml += renderProductGrid(product);
                    } else {
                        productsHtml += renderProductList(product);
                    }
                });
            }
            
            $('#products-container').html(productsHtml);
            updatePagination();
        }

        // Render product in grid view
        function renderProductGrid(product) {
            // Handle price display
            let priceHtml = '';
            if (product.has_multiple_prices) {
                priceHtml = `
                    <span class="text-lg font-bold text-primary-600 dark:text-primary-400">
                        ${product.price.formatted}
                    </span>
                `;
            } else {
                priceHtml = `
                    ${product.discount > 0 ? `
                        <span class="text-lg font-bold text-primary-600 dark:text-primary-400">Rs. ${(product.price.min * (1 - product.discount/100)).toLocaleString()}</span>
                        <span class="text-sm text-gray-500 line-through ml-2">Rs. ${product.price.min.toLocaleString()}</span>
                    ` : `
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">Rs. ${product.price.min.toLocaleString()}</span>
                    `}
                `;
            }

            return `
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                    <div class="relative product-image-container">
                        <img src="${product.image || 'backend/assets/images/no_image.png'}" alt="${product.name}" class="w-full h-48 object-cover">
                        <div class="product-overlay">
                            <button class="action-btn heart-btn" title="Add to wishlist" data-product-id="${product.id}">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button class="action-btn view-btn" title="View details" onclick="window.location.href='${product.url}'">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn cart-btn" title="Add to cart" data-product-id="${product.id}">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                        ${product.discount > 0 ? `<div class="discount-badge">${product.discount}% OFF</div>` : ''}
                        <div class="availability-badge ${product.in_stock ? 'available' : 'not-available'}">${product.in_stock ? 'In Stock' : 'Out of Stock'}</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 dark:text-white">${product.name}</h3>
                        <div class="flex items-center mb-2">
                            <div class="rating">
                                ${renderRatingStars(product.rating)}
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">(${product.review_count})</span>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <div>
                                ${priceHtml}
                            </div>
                            <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm" onclick="window.location.href='${product.url}'">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Render product in list view
        function renderProductList(product) {
            // Handle price display
            let priceHtml = '';
            if (product.has_multiple_prices) {
                priceHtml = `
                    <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        ${product.price.formatted}
                    </span>
                `;
            } else {
                priceHtml = `
                    ${product.discount > 0 ? `
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">Rs. ${(product.price.min * (1 - product.discount/100)).toLocaleString()}</span>
                        <span class="text-lg text-gray-500 line-through ml-2">Rs. ${product.price.min.toLocaleString()}</span>
                    ` : `
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">Rs. ${product.price.min.toLocaleString()}</span>
                    `}
                `;
            }

            return `
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card col-span-1 sm:col-span-2 lg:col-span-3">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 relative product-image-container">
                            <img src="${product.image || 'backend/assets/images/no_image.png'}" alt="${product.name}" class="w-full h-48 md:h-full object-cover">
                            <div class="product-overlay">
                                <button class="action-btn heart-btn" title="Add to wishlist" data-product-id="${product.id}">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="action-btn view-btn" title="View details" onclick="window.location.href='${product.url}'">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn cart-btn" title="Add to cart" data-product-id="${product.id}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                            ${product.discount > 0 ? `<div class="discount-badge">${product.discount}% OFF</div>` : ''}
                            <div class="availability-badge ${product.in_stock ? 'available' : 'not-available'}">${product.in_stock ? 'In Stock' : 'Out of Stock'}</div>
                        </div>
                        <div class="md:w-2/3 p-6">
                            <h3 class="text-xl font-bold mb-2 dark:text-white">${product.name}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">${product.short_description}</p>
                            <div class="flex items-center mb-4">
                                <div class="rating">
                                    ${renderRatingStars(product.rating)}
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">(${product.review_count} reviews)</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    ${priceHtml}
                                </div>
                                <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow" onclick="window.location.href='${product.url}'">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Render rating stars
        function renderRatingStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= Math.floor(rating)) {
                    stars += '<span class="active">★</span>';
                } else if (i === Math.ceil(rating) && rating % 1 > 0) {
                    stars += '<span class="active">★</span>';
                } else {
                    stars += '<span>★</span>';
                }
            }
            return stars;
        }

        // Update product count
        function updateProductCount() {
            const startIndex = (currentPage - 1) * productsPerPage + 1;
            const endIndex = Math.min(startIndex + productsPerPage - 1, filteredProducts.length);
            $('#product-count').text(`Showing ${startIndex}-${endIndex} of ${filteredProducts.length} products`);
        }

        // Update pagination
        function updatePagination() {
            const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
            
            if (totalPages <= 1) {
                $('#pagination').addClass('hidden');
                return;
            }
            
            $('#pagination').removeClass('hidden');
            
            let paginationHtml = '';
            
            // Previous button
            if (currentPage > 1) {
                paginationHtml += `<a href="#" class="pagination-link" data-page="${currentPage - 1}"><i class="fas fa-chevron-left"></i></a>`;
            } else {
                paginationHtml += `<span class="pagination-link disabled"><i class="fas fa-chevron-left"></i></span>`;
            }
            
            // Page numbers
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    paginationHtml += `<span class="pagination-link active">${i}</span>`;
                } else {
                    paginationHtml += `<a href="#" class="pagination-link" data-page="${i}">${i}</a>`;
                }
            }
            
            // Next button
            if (currentPage < totalPages) {
                paginationHtml += `<a href="#" class="pagination-link" data-page="${currentPage + 1}"><i class="fas fa-chevron-right"></i></a>`;
            } else {
                paginationHtml += `<span class="pagination-link disabled"><i class="fas fa-chevron-right"></i></span>`;
            }
            
            $('#pagination-container').html(paginationHtml);
            
            // Add click event to pagination links
            $('#pagination-container a').on('click', function(e) {
                e.preventDefault();
                currentPage = parseInt($(this).data('page'));
                renderProducts();
                updateProductCount();
                // Scroll to top of products
                $('html, body').animate({
                    scrollTop: $("#products-container").offset().top - 100
                }, 300);
            });
        }

        // Debounce function for search
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }
    </script>
    @endpush

</x-website-layout>