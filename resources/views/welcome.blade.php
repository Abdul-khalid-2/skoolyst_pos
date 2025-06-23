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
        
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
                <a href="#home" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    Home
                </a>
                <a href="#products" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    Products
                </a>
                <a href="#about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    About
                </a>
                <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    Contact
                </a>
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-secondary-600 hover:bg-secondary-700 transition-slow">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 md:pt-32 md:pb-24 hero-bg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">MD AUTOS</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Your trusted supplier of genuine heavy vehicle parts and components
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('our_products') }}" class="px-8 py-3 bg-secondary-600 hover:bg-secondary-700 rounded-md text-white font-medium transition-slow">
                        Our Products
                    </a>
                    <a href="#contact" class="px-8 py-3 border-2 border-white hover:bg-white hover:text-gray-900 rounded-md text-white font-medium transition-slow">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

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

    <!-- Stats Section -->
    <section class="py-16 bg-primary-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">15+</div>
                    <div class="text-lg">Years in Business</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">5000+</div>
                    <div class="text-lg">Happy Customers</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">10K+</div>
                    <div class="text-lg">Parts in Stock</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-lg">Customer Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Contact <span class="text-gradient">Us</span></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Get in touch with our team for inquiries or support
                </p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-12">
                <!-- Contact Info -->
                <div class="md:w-1/2 bg-gray-900 text-white p-8 rounded-xl">
                    <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                    <p class="mb-8 opacity-90">
                        Use the information below to reach us or fill out the form.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Address</h4>
                                <p class="opacity-90">123 Industrial Area, Karachi, Pakistan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Phone</h4>
                                <p class="opacity-90">+92 300 1234567</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Email</h4>
                                <p class="opacity-90">info@mdautos.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Business Hours</h4>
                                <p class="opacity-90">Monday - Saturday: 9AM to 6PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h4 class="font-bold mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-white hover:text-primary-300 transition-slow">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="#" class="text-white hover:text-primary-300 transition-slow">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </a>
                            <a href="#" class="text-white hover:text-primary-300 transition-slow">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-white hover:text-primary-300 transition-slow">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="md:w-1/2">
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h3 class="text-2xl font-bold mb-6">Send Us a Message</h3>
                        <form>
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Your name">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Your email">
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                                <input type="tel" id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Your phone number">
                            </div>
                            <div class="mb-6">
                                <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Your message"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition-slow">
                                Send Message <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h3 class="text-lg font-medium text-gray-500">Trusted by leading brands</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                <div class="flex justify-center">
                    <img src="https://via.placeholder.com/150x80?text=Brand+1" alt="Brand 1" class="h-12 opacity-70 hover:opacity-100 transition-slow">
                </div>
                <div class="flex justify-center">
                    <img src="https://via.placeholder.com/150x80?text=Brand+2" alt="Brand 2" class="h-12 opacity-70 hover:opacity-100 transition-slow">
                </div>
                <div class="flex justify-center">
                    <img src="https://via.placeholder.com/150x80?text=Brand+3" alt="Brand 3" class="h-12 opacity-70 hover:opacity-100 transition-slow">
                </div>
                <div class="flex justify-center">
                    <img src="https://via.placeholder.com/150x80?text=Brand+4" alt="Brand 4" class="h-12 opacity-70 hover:opacity-100 transition-slow">
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