<x-website-layout>
    @push('css')
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
        
        .variant-option {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .variant-option:hover {
            border-color: #0ea5e9;
        }
        
        .variant-option.selected {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
        }
        
        .variant-option.out-of-stock {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    @endpush

    <!-- Product Detail Section -->
    <section class="pt-32 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6 text-sm text-gray-600" id="breadcrumb">
                <div class="flex items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    <span>Loading product...</span>
                </div>
            </div>
            
            <div class="flex flex-col lg:flex-row gap-12" id="product-container">
                <!-- Loading state -->
                <div class="w-full text-center py-12">
                    <i class="fas fa-spinner fa-spin text-4xl text-primary-600 mb-4"></i>
                    <p class="text-gray-600">Loading product details...</p>
                </div>
            </div>
            
            <!-- Product Tabs -->
            <div class="mt-16" id="tabs-container" style="display: none;">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="openTab('description')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-primary-500 text-primary-600">
                            Description
                        </button>
                        <button onclick="openTab('specifications')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Specifications
                        </button>
                        <button onclick="openTab('reviews')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Reviews (<span id="review-count">0</span>)
                        </button>
                        <button onclick="openTab('shipping')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Shipping & Returns
                        </button>
                    </nav>
                </div>
                
                <div class="py-8">
                    <!-- Description Tab -->
                    <div id="description" class="tab-content active">
                        <div id="description-content"></div>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div id="specifications" class="tab-content">
                        <h3 class="text-xl font-bold mb-4">Technical Specifications</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="specs-table">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Specifications will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Reviews Tab -->
                    <div id="reviews" class="tab-content">
                        <div id="reviews-content"></div>
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
                                        <span>Free standard shipping on all orders over $100</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-clock text-primary-600 mt-1 mr-3"></i>
                                        <span>Processing time: 1-2 business days</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-map-marker-alt text-primary-600 mt-1 mr-3"></i>
                                        <span>Delivery time: 2-5 business days depending on location</span>
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <div class="mt-16" id="related-products-container" style="display: none;">
                <h2 class="text-2xl font-bold mb-8">Related Products</h2>
                <div class="grid md:grid-cols-3 gap-8" id="related-products">
                    <!-- Related products will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Variants Modal -->
    <div class="modal" id="variants-modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Select Variant</h3>
                    <button onclick="closeModal('variants-modal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="variants-content" class="mb-6">
                    <!-- Variants will be populated by JavaScript -->
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button onclick="closeModal('variants-modal')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button id="select-variant-btn" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                        Select Variant
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        // Global variables
        let productData = null;
        let variantsData = [];
        let selectedVariant = null;
        let currentProductId = {{ $productId ?? 'null' }};


        // DOM Ready
        $(document).ready(function() {
            if (currentProductId) {
                loadProductData(currentProductId);
            } else {
                // Handle case where no product ID is provided
                $('#product-container').html(`
                    <div class="w-full text-center py-12">
                        <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                        <p class="text-gray-600">Product not found</p>
                        <a href="/products" class="mt-4 inline-block px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                            Browse Products
                        </a>
                    </div>
                `);
            }
        });

        // Load product data via AJAX
        function loadProductData(productId) {
            $.ajax({
                url: '{{ route("api.productsvariant.detail", ":id") }}'.replace(':id', productId),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        productData = response.data.product;
                        variantsData = response.data.variants || [];
                        
                        // Render product details
                        renderProductDetails();
                        
                        // Show tabs and related products sections
                        $('#tabs-container').show();
                        $('#related-products-container').show();
                        
                        // Load related products
                        loadRelatedProducts(productData.category_id, productId);
                    } else {
                        showError('Failed to load product details');
                    }
                },
                error: function(xhr, status, error) {
                    showError('Error loading product: ' + error);
                }
            });
        }

        // Render product details
        function renderProductDetails() {
            if (!productData) return;
            
            // Update breadcrumb
            $('#breadcrumb').html(`
                <a href="/" class="hover:text-primary-600">Home</a> 
                <span class="mx-2">/</span>
                <a href="/products" class="hover:text-primary-600">Products</a>
                <span class="mx-2">/</span>
                <a href="/products?category=${productData.category_id}" class="hover:text-primary-600">${productData.category_name || 'Category'}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 font-medium">${productData.name}</span>
            `);
            
            // Prepare image gallery
            const images = productData.image_paths && productData.image_paths.length > 0 
                ? JSON.parse(productData.image_paths) 
                : ['/backend/assets/images/no_image.png'];
            
            const imageGallery = images.map((img, index) => `
                <img src="${img}" alt="${productData.name}" class="border rounded-md h-20 object-cover" 
                     onclick="changeImage('${img}')">
            `).join('');
            
            // Prepare price display
            let priceHtml = '';
            if (variantsData.length > 0) {
                const minPrice = Math.min(...variantsData.map(v => v.selling_price));
                const maxPrice = Math.max(...variantsData.map(v => v.selling_price));
                
                if (minPrice === maxPrice) {
                    priceHtml = `
                        <span class="text-3xl font-bold text-gray-900">Rs. ${minPrice.toLocaleString()}</span>
                    `;
                } else {
                    priceHtml = `
                        <span class="text-3xl font-bold text-gray-900">Rs. ${minPrice.toLocaleString()} - Rs. ${maxPrice.toLocaleString()}</span>
                    `;
                }
                
                // Add variant selection button
                priceHtml += `
                    <button onclick="openVariantModal()" class="ml-4 px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200">
                        View Variants <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                `;
            } else {
                priceHtml = `
                    <span class="text-3xl font-bold text-gray-900">Rs. ${productData.price?.min.toLocaleString() || '0'}</span>
                    ${productData.discount > 0 ? `
                        <span class="ml-2 text-lg text-gray-500 line-through">Rs. ${(productData.price?.min / (1 - productData.discount/100)).toLocaleString()}</span>
                        <span class="ml-2 bg-red-100 text-red-800 text-sm font-medium px-2 py-0.5 rounded">${productData.discount}% OFF</span>
                    ` : ''}
                `;
            }
            
            // Prepare features list
            const features = productData.description ? productData.description.split('\n').filter(f => f.trim()) : [];
            const featuresHtml = features.map(feature => `
                <li class="flex items-start">
                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                    <span>${feature}</span>
                </li>
            `).join('');
            
            // Prepare compatibility badges
            const compatibilityHtml = productData.compatibility ? `
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">Compatibility:</h3>
                    <div class="flex flex-wrap gap-2">
                        ${productData.compatibility.split(',').map(brand => `
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">${brand.trim()}</span>
                        `).join('')}
                    </div>
                </div>
            ` : '';
            
            // Render product container
            $('#product-container').html(`
                <!-- Product Images -->
                <div class="lg:w-1/2">
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <img id="main-image" src="${images[0]}" alt="${productData.name}" class="w-full h-96 object-contain rounded-lg">
                        
                        <div class="product-gallery">
                            ${imageGallery}
                        </div>
                    </div>
                    
                    <!-- Product badges -->
                    <div class="flex flex-wrap gap-3 mt-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> ${productData.stock_quantity > 0 ? 'In Stock' : 'Out of Stock'}
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
                    <h1 class="text-3xl font-bold mb-2">${productData.name}</h1>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            ${renderRatingStars(productData.rating || 0)}
                        </div>
                        <span class="text-gray-600 text-sm">${(productData.rating || 0).toFixed(1)} (${productData.review_count || 0} reviews)</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i> ${productData.stock_quantity || 0} in stock
                        </span>
                    </div>
                    
                    <div class="mb-6">
                        ${priceHtml}
                    </div>
                    
                    ${features.length > 0 ? `
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Key Features:</h3>
                        <ul class="space-y-2">
                            ${featuresHtml}
                        </ul>
                    </div>
                    ` : ''}
                    
                    ${compatibilityHtml}
                    
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
                            <button onclick="addToCart()" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition-slow">
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
            `);
            
            // Populate description tab
            $('#description-content').html(productData.description || '<p class="text-gray-600">No description available.</p>');
            
            // Populate specifications tab
            const specsHtml = `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SKU</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${productData.sku || 'N/A'}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Category</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${productData.category_name || 'N/A'}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Brand</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${productData.brand_name || 'N/A'}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Status</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${productData.status || 'N/A'}</td>
                </tr>
            `;
            $('#specs-table tbody').html(specsHtml);
            
            // Populate reviews tab
            $('#review-count').text(productData.review_count || 0);
            $('#reviews-content').html(`
                <h3 class="text-xl font-bold mb-6">Customer Reviews</h3>
                ${productData.review_count > 0 ? `
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="mr-4">
                                <span class="text-4xl font-bold">${(productData.rating || 0).toFixed(1)}</span>
                                <span class="text-gray-500">/5</span>
                            </div>
                            <div>
                                <div class="flex items-center mb-1">
                                    <div class="flex text-yellow-400 mr-2">
                                        ${renderRatingStars(productData.rating || 0)}
                                    </div>
                                    <span class="text-sm text-gray-600">Based on ${productData.review_count} reviews</span>
                                </div>
                            </div>
                        </div>
                        
                        <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            <i class="fas fa-pen mr-2"></i> Write a Review
                        </button>
                    </div>
                ` : `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-comment-slash text-4xl mb-3"></i>
                        <p>No reviews yet. Be the first to review this product!</p>
                        <button class="mt-4 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            <i class="fas fa-pen mr-2"></i> Write a Review
                        </button>
                    </div>
                `}
            `);
        }

        // Load related products
        function loadRelatedProducts(categoryId, excludeProductId) {
            $.ajax({
                url: '{{ route("api.productsvariant.related", ":categoryId") }}'.replace(':categoryId', categoryId) + `?exclude=${excludeProductId}`,

                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        const relatedProductsHtml = response.data.map(product => `
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                                <img src="${product.image || '/backend/assets/images/no_image.png'}" 
                                     alt="${product.name}" class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2">${product.name}</h3>
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400 mr-1 text-sm">
                                            ${renderRatingStars(product.rating || 0)}
                                        </div>
                                        <span class="text-gray-500 text-sm">(${product.review_count || 0})</span>
                                    </div>
                                    <div class="mb-4">
                                        <span class="text-lg font-bold text-gray-900">Rs. ${product.price?.min.toLocaleString() || '0'}</span>
                                        ${product.discount > 0 ? `
                                            <span class="ml-2 text-sm text-gray-500 line-through">Rs. ${(product.price?.min / (1 - product.discount/100)).toLocaleString()}</span>
                                        ` : ''}
                                    </div>
                                    <a href="/products/${product.slug}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                                        View Details <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        `).join('');
                        
                        $('#related-products').html(relatedProductsHtml);
                    } else {
                        $('#related-products-container').hide();
                    }
                },
                error: function() {
                    $('#related-products-container').hide();
                }
            });
        }

        // Open variant modal
        function openVariantModal() {
            if (variantsData.length === 0) return;
            
            const variantsHtml = variantsData.map(variant => `
                <div class="variant-option ${variant.current_stock <= 0 ? 'out-of-stock' : ''} ${selectedVariant && selectedVariant.id === variant.id ? 'selected' : ''}" 
                     data-variant-id="${variant.id}" onclick="selectVariant(${variant.id})">
                    <div class="flex justify-between items-center">
                        <h4 class="font-medium">${variant.name}</h4>
                        <span class="font-bold">Rs. ${variant.selling_price.toLocaleString()}</span>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>SKU: ${variant.sku}</p>
                        <p>Stock: ${variant.current_stock} available</p>
                    </div>
                </div>
            `).join('');
            
            $('#variants-content').html(variantsHtml);
            
            // If no variant is selected yet, select the first available one
            if (!selectedVariant) {
                const availableVariant = variantsData.find(v => v.current_stock > 0);
                if (availableVariant) {
                    selectVariant(availableVariant.id);
                }
            }
            
            openModal('variants-modal');
        }

        // Select variant
        function selectVariant(variantId) {
            const variant = variantsData.find(v => v.id === variantId);
            if (!variant || variant.current_stock <= 0) return;
            
            selectedVariant = variant;
            
            // Update UI to show selected variant
            $('.variant-option').removeClass('selected');
            $(`.variant-option[data-variant-id="${variantId}"]`).addClass('selected');
        }

        // Add to cart
        function addToCart() {
            const quantity = parseInt($('#quantity').val());
            
            if (variantsData.length > 0 && !selectedVariant) {
                openVariantModal();
                return;
            }
            
            const productToAdd = selectedVariant ? {
                id: selectedVariant.id,
                name: productData.name,
                variant: selectedVariant.name,
                price: selectedVariant.selling_price,
                quantity: quantity,
                image: productData.image_paths ? JSON.parse(productData.image_paths)[0] : '/backend/assets/images/no_image.png'
            } : {
                id: productData.id,
                name: productData.name,
                price: productData.price?.min || 0,
                quantity: quantity,
                image: productData.image_paths ? JSON.parse(productData.image_paths)[0] : '/backend/assets/images/no_image.png'
            };
            
            // Here you would typically add to cart via AJAX
            console.log('Adding to cart:', productToAdd);
            
            // Show success message
            showMessage('Product added to cart successfully!', 'success');
        }

        // Utility functions
        function changeImage(src) {
            $('#main-image').attr('src', src);
        }

        function updateQuantity(change) {
            const quantityInput = $('#quantity');
            let quantity = parseInt(quantityInput.val());
            quantity += change;
            if (quantity < 1) quantity = 1;
            quantityInput.val(quantity);
        }

        function openTab(tabId) {
            $('.tab-content').removeClass('active');
            $('.tab-button').removeClass('border-primary-500 text-primary-600').addClass('border-transparent text-gray-500');
            $(`#${tabId}`).addClass('active');
            $(event.currentTarget).removeClass('border-transparent text-gray-500').addClass('border-primary-500 text-primary-600');
        }

        function openModal(modalId) {
            $(`#${modalId}`).addClass('active');
        }

        function closeModal(modalId) {
            $(`#${modalId}`).removeClass('active');
        }

        function renderRatingStars(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            
            for (let i = 1; i <= 5; i++) {
                if (i <= fullStars) {
                    stars += '<i class="fas fa-star"></i>';
                } else if (i === fullStars + 1 && hasHalfStar) {
                    stars += '<i class="fas fa-star-half-alt"></i>';
                } else {
                    stars += '<i class="far fa-star"></i>';
                }
            }
            
            return stars;
        }

        function showMessage(message, type = 'info') {
            // Create toast notification
            const toast = $(`
                <div class="fixed top-4 right-4 z-50 px-4 py-2 rounded-md shadow-md text-white ${type === 'success' ? 'bg-green-500' : 'bg-blue-500'}">
                    <div class="flex items-center">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} mr-2"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `);
            
            $('body').append(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.fadeOut(() => toast.remove());
            }, 3000);
        }

        function showError(message) {
            $('#product-container').html(`
                <div class="w-full text-center py-12">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                    <p class="text-gray-600">${message}</p>
                    <a href="/products" class="mt-4 inline-block px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                        Browse Products
                    </a>
                </div>
            `);
        }
    </script>
    @endpush
</x-website-layout>