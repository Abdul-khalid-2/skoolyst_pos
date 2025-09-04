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

