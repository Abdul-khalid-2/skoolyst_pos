<!DOCTYPE html>
<html lang="en">

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
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800">
    <!-- Navigation -->
    @include('website_layouts.header')

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Quality Assurance</h3>
                    <p class="text-gray-600">
                        We provide only genuine OEM and high-quality aftermarket parts that enhance your vehicle's performance
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Fast Delivery</h3>
                    <p class="text-gray-600">
                        Nationwide express shipping with same-day dispatch on orders placed before 3PM
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">24/7 Support</h3>
                    <p class="text-gray-600">
                        Our expert team is available round the clock to answer your queries and provide guidance
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{ $slot }}

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
    </script>
</body>

</html>



welcome.blade.php   


<x-website-layout>

    <!-- Categoryes Section -->
    <section id="products" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Products <span class="text-gradient">Categoryes</span></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Premium quality parts for all major heavy vehicle brands
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Product 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                    <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}"
                        alt="Engine Parts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Engine Components</h3>
                        <p class="text-gray-600 mb-4">
                            All critical engine parts to keep your vehicle running at peak performance
                        </p>
                        <a href="{{ route('product_details') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                    <img src="{{ asset('backend/assets/images/brake_system.jpg') }}"
                        alt="Brake System" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Brake System</h3>
                        <p class="text-gray-600 mb-4">
                            High-quality brake components that ensure your safety on the road
                        </p>
                        <a href="{{ route('product_details') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                    <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}"
                        alt="Suspension Parts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Suspension Parts</h3>
                        <p class="text-gray-600 mb-4">
                            Premium suspension components for a smoother ride and better handling
                        </p>
                        <a href="{{ route('product_details') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Our <span class="text-gradient">Products</span></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Premium quality parts for all major heavy vehicle brands
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Product 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                    <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}"
                        alt="Engine Parts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Engine Components</h3>
                        <p class="text-gray-600 mb-4">
                            All critical engine parts to keep your vehicle running at peak performance
                        </p>
                        <a href="{{ route('product_details') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                    <img src="{{ asset('backend/assets/images/brake_system.jpg') }}"
                        alt="Brake System" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Brake System</h3>
                        <p class="text-gray-600 mb-4">
                            High-quality brake components that ensure your safety on the road
                        </p>
                        <a href="{{ route('product_details') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow transform hover:-translate-y-1">
                    <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}"
                        alt="Suspension Parts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Suspension Parts</h3>
                        <p class="text-gray-600 mb-4">
                            Premium suspension components for a smoother ride and better handling
                        </p>
                        <a href="{{ route('product_details') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('our_products') }}" class="inline-flex items-center px-8 py-3 border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white rounded-md font-medium transition-slow">
                    View All Products <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- Testimonials -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Customer <span class="text-gradient">Testimonials</span></h2>
                <p class="text-lg text-gray-600">
                    What our valued customers say about us
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "I've been purchasing parts from MD Autos for years. Their quality and service are unmatched in the industry."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold">Ali Khan</h4>
                            <p class="text-gray-500 text-sm">Transport Company Owner</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "Their parts last longer than competitors' and the prices are reasonable. Delivery is always on time."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold">Ahmed Raza</h4>
                            <p class="text-gray-500 text-sm">Fleet Maintenance Manager</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "Whenever I need parts for my trucks, MD Autos is my first choice. Their technical support is excellent."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold">Usman Malik</h4>
                            <p class="text-gray-500 text-sm">Logistics Operator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-website-layout>