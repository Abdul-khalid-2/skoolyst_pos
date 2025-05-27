<!DOCTYPE html>
<html lang="ur" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ایم ڈی آٹوز | بھاری گاڑیوں کے پرزے</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'urdu': ['Noto Nastaliq Urdu', 'serif'],
                        'sans': ['Inter', 'sans-serif'],
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
        .urdu-text {
            font-family: 'Noto Nastaliq Urdu', serif;
            line-height: 2;
        }
        
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
        }
        
        /* Smooth transitions */
        .transition-slow {
            transition: all 0.5s ease;
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-800">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50 transition-slow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
               
                
                <!-- Nav items on right with login first -->
                <div class="hidden md:flex items-center space-x-1 space-x-reverse">
                    <!-- Login button first -->
                    <a href="{{ route('login') }}" class="ml-4 px-4 py-2 rounded-md bg-secondary-600 text-white font-medium hover:bg-secondary-700 transition-slow">
                        لاگ ان
                    </a>
                    <!-- <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary-600 hover:bg-primary-700 transition-slow">
                        register
                    </a> -->
                    <!-- Other nav items -->
                    <a href="#contact" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        رابطہ
                    </a>
                    <a href="#about" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        ہمارے بارے میں
                    </a>
                    <a href="#products" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        مصنوعات
                    </a>
                    <a href="#home" class="px-4 py-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                        ہوم
                    </a>
                </div>
                 <!-- Logo on left -->
                <div class="flex-shrink-0 flex items-center">
                    <img class="h-12 w-auto" src="{{ asset('Backend/assets/images/MDLogo.jpg') }}" alt="MD Autos Logo">
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
                    ہوم
                </a>
                <a href="#products" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    مصنوعات
                </a>
                <a href="#about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    ہمارے بارے میں
                </a>
                <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-100 transition-slow">
                    رابطہ
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary-600 hover:bg-primary-700 transition-slow">
                    register
                </a>
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-secondary-600 hover:bg-secondary-700 transition-slow">
                    لاگ ان
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 md:pt-32 md:pb-24 hero-bg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">MD AUTOS</h1>
                <p class="text-xl md:text-2xl mb-8 urdu-text max-w-3xl mx-auto">
                    بھاری گاڑیوں کے اصل اور معیاری پرزوں کی ایک قابل اعتماد فراہم کنندہ
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#products" class="px-8 py-3 bg-secondary-600 hover:bg-secondary-700 rounded-md text-white font-medium transition-slow">
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
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-primary-600 mb-4">
                        <i class="fas fa-shield-alt text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Quality Assurance</h3>
                    <p class="urdu-text text-gray-600">
                        ہم صرف معیاری اور اصل پرزے فراہم کرتے ہیں جو آپ کی گاڑی کی کارکردگی کو بہتر بناتے ہیں
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-primary-600 mb-4">
                        <i class="fas fa-truck text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Fast Delivery</h3>
                    <p class="urdu-text text-gray-600">
                        ملک بھر میں تیز ترین ترسیل کی سہولت، آرڈر پر فوری کارروائی
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-primary-600 mb-4">
                        <i class="fas fa-headset text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">24/7 Support</h3>
                    <p class="urdu-text text-gray-600">
                        ہمارا ماہر عملہ ہر وقت آپ کے سوالات کے جوابات دینے اور رہنمائی کرنے کے لیے موجود ہے
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Our Products</h2>
                <p class="text-lg text-gray-600 urdu-text max-w-2xl mx-auto">
                    ہماری مصنوعات کی ایک جھلک
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Product 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow">
                    <img src="{{ asset('Backend/assets/images/Engine_Components.jpg') }}" 
                         alt="Engine Parts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Engine Components</h3>
                        <p class="text-gray-600 mb-4 urdu-text">
                            انجن کے تمام اہم پرزے جو آپ کی گاڑی کو بہترین حالت میں چلانے میں مدد دیتے ہیں
                        </p>
                        <a href="#" class="inline-block px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details
                        </a>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow">
                    <img src="{{ asset('Backend/assets/images/brake_system.jpg') }}" 
                         alt="Brake System" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Brake System</h3>
                        <p class="text-gray-600 mb-4 urdu-text">
                            اعلیٰ معیار کے بریک سسٹم کے پرزے جو آپ کی حفاظت کو یقینی بناتے ہیں
                        </p>
                        <a href="#" class="inline-block px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details
                        </a>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow">
                    <img src="{{ asset('Backend/assets/images/Suspension_Parts.jpg') }}" 
                         alt="Suspension Parts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Suspension Parts</h3>
                        <p class="text-gray-600 mb-4 urdu-text">
                            گاڑی کے معیار کو برقرار رکھنے والے معیاری تعلی پرزے
                        </p>
                        <a href="#" class="inline-block px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-block px-8 py-3 border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white rounded-md font-medium transition-slow">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <img src="{{ asset('Backend/assets/images/Engine_Components.jpg') }}" 
                         alt="About MD Autos" class="rounded-xl shadow-md w-full">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-6">About MD Autos</h2>
                    <p class="text-gray-600 mb-4 urdu-text">
                        ایم ڈی آٹوز بھاری گاڑیوں کے پرزوں کی ایک معروف کمپنی ہے جو کئی سالوں سے معیاری پرزے فراہم کر رہی ہے۔ ہمارا مشن ہمارے گاہکوں کو بہترین معیار کے پرزے مناسب قیمت پر فراہم کرنا ہے۔
                    </p>
                    <p class="text-gray-600 mb-6 urdu-text">
                        ہمارے پاس تجربہ کار عملہ ہے جو آپ کو صحیح پرزے منتخب کرنے میں مدد فراہم کرے گا۔ ہم صرف مستند اور قابل اعتماد سپلائرز سے پرزے حاصل کرتے ہیں تاکہ آپ کو بہترین مصنوعات مل سکیں۔
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="urdu-text text-gray-600">معیاری اور اصل پرزے</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="urdu-text text-gray-600">مناسب قیمتیں</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="urdu-text text-gray-600">تیز ترین ترسیل</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="urdu-text text-gray-600">ماہرانہ مشورہ</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Customer Reviews</h2>
                <p class="text-lg text-gray-600 urdu-text">
                    ہمارے گاہکوں کے تاثرات
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 mb-6 urdu-text">
                        میں کئی سالوں سے ایم ڈی آٹوز سے پرزے خرید رہا ہوں۔ ان کا معیار اور سروس بہترین ہے۔
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold">Ali Khan</h4>
                            <p class="text-gray-500 text-sm">Transport Company Owner</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 mb-6 urdu-text">
                        ان کے پرزے دیرپا ہوتے ہیں اور قیمت بھی مناسب ہوتی ہے۔ ترسیل کا نظام بھی بہت اچھا ہے۔
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold">Ahmed Raza</h4>
                            <p class="text-gray-500 text-sm">Mechanic</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 mb-6 urdu-text">
                        جب بھی مجھے کسی پرزے کی ضرورت ہوتی ہے، میں ایم ڈی آٹوز کو ہی ترجیح دیتا ہوں۔
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold">Usman Malik</h4>
                            <p class="text-gray-500 text-sm">Fleet Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-12">
                <!-- Contact Info -->
                <div class="md:w-1/2 bg-primary-800 text-white p-8 rounded-xl">
                    <h3 class="text-2xl font-bold mb-6">رابطہ کی معلومات</h3>
                    <p class="mb-8 urdu-text opacity-90">
                        ہم سے رابطہ کرنے کے لیے درج ذیل معلومات استعمال کریں یا فارم کو بھریں۔
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">پتہ</h4>
                                <p class="opacity-90 urdu-text"> 123 انڈسٹریل ایریا، کراچی، پاکستان </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1"> فون </h4>
                                <p class="opacity-90">+92 300 1234567</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">  ای میل  </h4>
                                <p class="opacity-90">info@mdautos.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1"> کام کے اوقات </h4>
                                <p class="opacity-90">پیر - ہفتہ: صبح 9 بجے سے شام 6 بجے تک</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h4 class="font-bold mb-4"> ہمیں فالو کریں۔ </h4>
                        <div class="flex space-x-4 space-x-reverse">
                            <a href="#" class="text-white hover:text-primary-200 transition-slow">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="#" class="text-white hover:text-primary-200 transition-slow">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </a>
                            <a href="#" class="text-white hover:text-primary-200 transition-slow">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-white hover:text-primary-200 transition-slow">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="md:w-1/2">
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h3 class="text-2xl font-bold mb-6">Contact Form</h3>
                        <form>
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="آپ کا نام">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="آپ کا ای میل">
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                                <input type="tel" id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="آپ کا فون نمبر">
                            </div>
                            <div class="mb-6">
                                <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="آپ کا پیغام"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-md transition-slow">
                                Send Message
                            </button>
                        </form>
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
                    <p class="text-gray-400 mb-4 urdu-text">
                        بھاری گاڑیوں کے پرزوں کی ایک قابل اعتماد فراہم کنندہ
                    </p>
                    <div class="flex space-x-4 space-x-reverse">
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
                    <h4 class="text-lg font-bold mb-4">Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-slow">Home</a></li>
                        <li><a href="#products" class="text-gray-400 hover:text-white transition-slow">Products</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-slow">About</a></li>
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
                        <li><a href="#" class="text-gray-400 hover:text-white transition-slow">All Products</a></li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Newsletter</h4>
                    <p class="text-gray-400 mb-4 urdu-text">
                        تازہ ترین پیشکشوں اور اپ ڈیٹس کے لیے سبسکرائب کریں
                    </p>
                    <form class="flex">
                        <input type="email" placeholder="آپ کا ای میل" class="px-4 py-2 w-full rounded-l-md focus:outline-none text-gray-900">
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-r-md transition-slow">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">
                    &copy; 2023 MD Autos. All rights reserved.
                </p>
                <p class="text-gray-400">
                    Designed with <i class="fas fa-heart text-red-500"></i> for heavy vehicles
                </p>
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
