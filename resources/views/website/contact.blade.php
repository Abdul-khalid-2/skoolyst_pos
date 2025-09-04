
<x-website-layout>



<!-- Contact Section -->
<section id="contact" class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-3 dark:text-white">Contact <span class="text-gradient">Us</span></h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Get in touch with our team for inquiries or support. We're here to help!
            </p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Contact Info -->
            <div class="lg:w-2/5 bg-primary-600 text-white p-8 rounded-xl shadow-md">
                <h3 class="text-2xl font-bold mb-6">Get in Touch</h3>
                <p class="mb-8 opacity-90">
                    Have questions about our products or services? Reach out to us using the information below or fill out the form.
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold mb-1">Address</h4>
                            <p class="opacity-90">123 Industrial Area, Karachi, Pakistan</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold mb-1">Phone</h4>
                            <p class="opacity-90">+92 300 1234567</p>
                            <p class="opacity-90">+92 321 7654321</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-bold mb-1">Email</h4>
                            <p class="opacity-90">info@mdautos.com</p>
                            <p class="opacity-90">support@mdautos.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4 class="font-bold mb-1">Business Hours</h4>
                            <p class="opacity-90">Monday - Saturday: 9AM to 6PM</p>
                            <p class="opacity-90">Sunday: Emergency support only</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10">
                    <h4 class="font-bold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 w-10 h-10 rounded-full flex items-center justify-center transition-slow">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 w-10 h-10 rounded-full flex items-center justify-center transition-slow">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 w-10 h-10 rounded-full flex items-center justify-center transition-slow">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 w-10 h-10 rounded-full flex items-center justify-center transition-slow">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="lg:w-3/5">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md">
                    <h3 class="text-2xl font-bold mb-6 dark:text-white">Send Us a Message</h3>
                    <form class="grid md:grid-cols-2 gap-6">
                        <div class="md:col-span-1">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Full Name</label>
                            <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Your name" required>
                        </div>
                        <div class="md:col-span-1">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email Address</label>
                            <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Your email" required>
                        </div>
                        <div class="md:col-span-1">
                            <label for="phone" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Phone Number</label>
                            <input type="tel" id="phone" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Your phone number">
                        </div>
                        <div class="md:col-span-1">
                            <label for="subject" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Subject</label>
                            <select id="subject" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="product">Product Information</option>
                                <option value="support">Technical Support</option>
                                <option value="warranty">Warranty Claim</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="message" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Message</label>
                            <textarea id="message" rows="5" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Your message" required></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition-slow flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Map -->
                <div class="bg-white dark:bg-gray-800 p-4 mt-6 rounded-xl shadow-md">
                    <h4 class="text-xl font-bold mb-4 dark:text-white">Our Location</h4>
                    <div class="aspect-video bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                        <!-- Replace with actual map embed code -->
                        <div class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
                            <i class="fas fa-map-marked-alt text-4xl text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</x-website-layout>