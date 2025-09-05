<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MD Autos | Heavy Vehicle Parts Supplier</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80');
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
        
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
            padding: 8px 0;
        }
        
        .dark .mobile-bottom-nav {
            background: #1f2937;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #6b7280;
        }
        
        .mobile-nav-item.active {
            color: #0ea5e9;
        }
        
        .dark .mobile-nav-item {
            color: #9ca3af;
        }
        
        .dark .mobile-nav-item.active {
            color: #0ea5e9;
        }
        
        .scroll-to-top {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #0ea5e9;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }
        
        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
            bottom: 90px;
        }
        
        .dark .scroll-to-top {
            background: #0369a1;
        }
        
        /* New styles for category cards */
        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            height: 300px;
            transition: all 0.4s ease;
        }
        
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .category-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .category-card:hover .category-image {
            transform: scale(1.1);
        }
        
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            padding: 30px 20px 20px;
            color: white;
            transition: all 0.4s ease;
        }
        
        .category-card:hover .category-overlay {
            padding-bottom: 30px;
            background: linear-gradient(to top, rgba(14, 165, 233, 0.95), transparent);
        }
        
        .category-count {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }
        
        .category-card:hover .category-count {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-5px);
        }
        
        .category-button {
            display: inline-flex;
            align-items: center;
            background: white;
            color: #0ea5e9;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            margin-top: 15px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }
        
        .category-card:hover .category-button {
            opacity: 1;
            transform: translateY(0);
        }
        
        .category-button:hover {
            background: #0ea5e9;
            color: white;
        }
        
        @media (max-width: 768px) {
            .mobile-bottom-nav {
                display: flex;
                justify-content: space-around;
            }
            
            .scroll-to-top.visible {
                bottom: 80px;
            }
            
            .category-card {
                height: 250px;
            }
        }
        
        .dark {
            background-color: #111827;
            color: #e5e7eb;
        }
        
        .dark .bg-white {
            background-color: #1f2937;
        }
        
        .dark .bg-gray-50 {
            background-color: #111827;
        }
        
        .dark .text-gray-600 {
            color: #d1d5db;
        }
        
        .dark .text-gray-800 {
            color: #e5e7eb;
        }
        
        .dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(255, 255, 255, 0.05);
        }
        
        .dark .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(255, 255, 255, 0.1), 0 2px 4px -1px rgba(255, 255, 255, 0.06);
        }

        /* Modal styles with dark theme support */
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
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            color: #111827; /* Default text color */
            margin-bottom: 4rem;
        }

        .dark .modal-content {
            background-color: #1f2937; /* gray-800 */
            color: #e5e7eb; /* gray-200 */
        }

        
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .dark .modal-header {
            border-bottom: 1px solid #374151;
        }
        
        .modal-body {
            padding: 1.5rem;
            flex: 1;
            overflow-y: auto;
        }
        
        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
            position: sticky;
            bottom: 0;
            background: white;
        }
        
        .dark .modal-footer {
            border-top: 1px solid #374151;
            background: #1f2937;
        }
        
        .variant-search {
            margin-bottom: 1rem;
        }
        
        .variant-search-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }
        
        .dark .variant-search-input {
            background-color: #374151;
            border-color: #4b5563;
            color: #e5e7eb;
        }
        
        .variant-option {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 10px;
        }
        
        .dark .variant-option {
            border-color: #374151;
        }
        
        .variant-option:hover {
            border-color: #0ea5e9;
        }
        
        .variant-option.selected {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
        }
        
        .dark .variant-option.selected {
            background-color: #1e3a8a;
        }
        
        .variant-option.out-of-stock {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Fix for quantity input field in dark mode */
        .variant-option input[type="number"] {
            background-color: white;
            color: #1f2937;
        }
        
        .dark .variant-option input[type="number"] {
            background-color: #374151;
            color: #e5e7eb;
            border-color: #4b5563;
        }
        /* Fix for quantity input field in dark mode */
        .variant-option button[type="button"] {
            background-color: white;
            color: #1f2937;
        }
        
        .dark .variant-option button[type="button"] {
            background-color: #374151;
            color: #e5e7eb;
            border-color: #4b5563;
        }

        /* ---------- Selected Variants container ---------- */
        #selected-variants-list {
        background: #ffffff;
        border: 1px solid #e5e7eb; /* gray-200 */
        border-radius: 0.5rem;
        padding: 1rem;
        }

        .dark #selected-variants-list {
        background: #111827; /* gray-900 */
        border-color: #374151; /* gray-700 */
        color: #e5e7eb;       /* gray-200 */
        }

        /* Each selected item row */
        .selected-variant-item {
        display: grid;
        grid-template-columns: 1fr auto auto auto;
        gap: 0.75rem;
        align-items: center;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-bottom: 0.75rem;
        background: #ffffff;
        }

        .dark .selected-variant-item {
        border-color: #374151;
        background: #1f2937; /* gray-800 */
        }

        /* Variant text bits */
        .variant-name { font-weight: 600; }
        .variant-details { font-size: 0.875rem; opacity: 0.9; }
        .variant-price { font-weight: 600; }

        /* ---------- Quantity controls ---------- */
        .variant-quantity {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        }

        .quantity-btn {
        width: 2rem;
        height: 2rem;
        border: 1px solid #d1d5db; /* gray-300 */
        background: #f9fafb;       /* gray-50 */
        color: #111827;            /* gray-900 */
        border-radius: 0.375rem;
        font-weight: 600;
        line-height: 2rem;
        text-align: center;
        cursor: pointer;
        user-select: none;
        }

        .quantity-btn:hover { background: #f3f4f6; }

        .dark .quantity-btn {
        border-color: #4b5563;     /* gray-600 */
        background: #374151;       /* gray-700 */
        color: #e5e7eb;            /* gray-200 */
        }
        .dark .quantity-btn:hover { background: #4b5563; }

        /* Number input */
        .quantity-input {
        width: 64px;
        text-align: center;
        padding: 0.375rem 0.5rem;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #111827;
        border-radius: 0.375rem;
        -moz-appearance: textfield; /* hide spinners in Firefox (we have +/- buttons) */
        }
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;  /* hide spinners in WebKit (we have +/- buttons) */
        margin: 0;
        }

        .dark .quantity-input {
        background: #374151;   /* gray-700 */
        border-color: #4b5563; /* gray-600 */
        color: #e5e7eb;        /* gray-200 */
        }

        /* Remove icon color */
        .remove-variant { cursor: pointer; }
        .remove-variant i { color: #6b7280; }         /* gray-500 */
        .dark .remove-variant i { color: #9ca3af; }   /* gray-400 */
        .remove-variant:hover i { color: #ef4444; }   /* red-500 */

    </style>
        @stack('css')
</head>

<body class="font-sans bg-gray-50 text-gray-800 transition-colors duration-300">
    <!-- Scroll to top button -->
    <div class="scroll-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Navigation -->
    @include('website_layouts.header')
    <!-- Theme Toggle Button -->
    <button id="theme-toggle" class="fixed top-24 right-4 z-50 p-2 bg-white dark:bg-gray-800 rounded-full shadow-md">
        <i class="fas fa-moon dark:hidden"></i>
        <i class="fas fa-sun hidden dark:block"></i>
    </button>

    {{ $slot }}

   
    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <a href="#" class="mobile-nav-item active">
            <i class="fas fa-home text-lg mb-1"></i>
            <span>Home</span>
        </a>
        <a href="#products" class="mobile-nav-item">
            <i class="fas fa-box text-lg mb-1"></i>
            <span>Products</span>
        </a>
        <a href="#contact" class="mobile-nav-item">
            <i class="fas fa-phone text-lg mb-1"></i>
            <span>Contact</span>
        </a>
    </div>

    <!-- Footer -->
    @include('website_layouts.footer')
    
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
            
            // Show/hide scroll to top button
            const scrollButton = document.querySelector('.scroll-to-top');
            if (window.scrollY > 500) {
                scrollButton.classList.add('visible');
            } else {
                scrollButton.classList.remove('visible');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });

                    // Close mobile menu if open
                    document.getElementById('mobile-menu').classList.add('hidden');
                }
            });
        });
        
        // Scroll to top functionality
        document.querySelector('.scroll-to-top').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
        // Check for saved theme preference or respect OS preference
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            htmlElement.classList.add('dark');
        } else {
            htmlElement.classList.remove('dark');
        }
        
        themeToggle.addEventListener('click', function() {
            htmlElement.classList.toggle('dark');
            localStorage.setItem('theme', htmlElement.classList.contains('dark') ? 'dark' : 'light');
        });
        
        // Mobile bottom nav active state
        const mobileNavItems = document.querySelectorAll('.mobile-nav-item');
        mobileNavItems.forEach(item => {
            item.addEventListener('click', function() {
                mobileNavItems.forEach(navItem => navItem.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Product action buttons functionality
        const heartButtons = document.querySelectorAll('.heart-btn');
        heartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.toggle('text-red-500');
            });
        });
        
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                // Add view functionality here
                // alert('View details clicked!');
            });
        });
        
        const cartButtons = document.querySelectorAll('.cart-btn');
        cartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                // Add to cart functionality here
                alert('Added to cart!');
            });
        });
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('js')
</body>
</html>