<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Coupon Aggregator - Save More!</title>
    <meta name="description" content="Find the best coupons and discount codes for your favorite brands">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ffbe0b',
                        secondary: '#3a86ff',
                        accent: '#fb5607',
                        dark: '#1e293b',
                        light: '#f8fafc'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        };
    </script>
    
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 shadow-lg sticky top-0 z-50 h-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <div class=" flex items-center justify-center">
                    <i class="fas fa-tag text-white text-2xl mr-2"></i>
                    <span class="text-white font-bold text-xl mr-6 pr-4">CouponHub</span>
                </div>
                <div class="hidden md:flex space-x-6 items-center justify-center">
                    <a href="index.php" class="text-white hover:bg-white hover:bg-opacity-20 px-3 py-2 rounded-md text-sm font-medium transition">Home</a>
                    <a href="search.php" class="text-white hover:bg-white hover:bg-opacity-20 px-3 py-2 rounded-md text-sm font-medium transition">Search</a>
                    <a href="reviews.php" class="text-white hover:bg-white hover:bg-opacity-20 px-3 py-2 rounded-md text-sm font-medium transition">Reviews</a>
                    <a href="contact.php" class="text-white hover:bg-white hover:bg-opacity-20 px-3 py-2 rounded-md text-sm font-medium transition">Contact</a>
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
    <?php if(isset($_SESSION['username'])): ?>
        <a href="add_coupon.php" class="flex items-center justify-center w-10 h-10 rounded-full bg-white bg-opacity-20 text-white hover:bg-opacity-30 transition">
            <i class="fas fa-plus"></i>
        </a>
        
        
        <span class="text-white font-medium">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="text-red-300 hover:text-red-100 px-3 py-2 rounded-md text-sm font-medium transition">Logout</a>
    <?php else: ?>
        
        <a href="login.php" class="text-white hover:bg-white hover:bg-opacity-20 px-3 py-2 rounded-md text-sm font-medium transition">Login</a>
        <a href="register.php" class="bg-white text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-opacity-90 transition">Register</a>
    <?php endif; ?>
</div>
        </div>
    </div>
</nav>

<div class="w-full h-screen relative bg-[url('images/banner2.png')] bg-contain bg-center bg-no-repeat">
</div>




    


    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800     mb-4 font-poppins">🔥 Trending Coupons</h2>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">Most popular coupons this week</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    
            <div class="bg-black rounded-xl shadow-md overflow-hidden">
                <div class="relative">
                    <img src="images/amazon.jpg" alt="Amazon" class="w-full h-48 object-cover rounded-full">
                    <div class="absolute top-4 right-4 bg-accent text-white text-sm font-bold px-3 py-1 rounded-full">
                        20% OFF
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <img src="https://logo.clearbit.com/amazon.com" alt="Amazon" class="w-10 h-10 rounded-lg mr-3">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Amazon</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">On Electronics & Home Appliances</p>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm text-gray-500">Use code:</span>
                            <span class="font-mono font-bold text-primary ml-2">SAVE20</span>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="far fa-clock mr-1"></i> Expires: 30/06/2025
                        </div>
                    </div>
                    <button class="w-full bg-secondary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-copy mr-2"></i> Copy Code
                    </button>
                    <div class="mt-3 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span><i class="fas fa-users mr-1"></i> 124 used today</span>
                        <span class="text-green-500"><i class="fas fa-check-circle mr-1"></i> Verified</span>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-black rounded-2xl shadow-md overflow-hidden coupon-card">
                <div class="relative">
                    <img src="images/myntra.jpg" alt="Myntra" class="w-full h-48 object-cover">
                    <div class="absolute top-4 right-4 bg-green-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                        NEW
                    </div>
                    <div class="absolute top-4 left-4 bg-primary text-dark text-sm font-bold px-3 py-1 rounded-full">
                        30% OFF
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <img src="https://logo.clearbit.com/myntra.com" alt="Myntra" class="w-10 h-10 rounded-full mr-3">
                        <h3 class="text-xl font-bold text-white">Myntra</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">On Fashion & Accessories</p>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Use code:</span>
                            <span class="font-mono font-bold text-primary ml-2">STYLE30</span>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="far fa-clock mr-1"></i> Expires: 15/07/2025
                        </div>
                    </div>
                    <button class="w-full bg-secondary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-copy mr-2"></i> Copy Code
                    </button>
                    <div class="mt-3 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span><i class="fas fa-users mr-1"></i> 89 used today</span>
                        <span class="text-green-500"><i class="fas fa-check-circle mr-1"></i> Verified</span>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white dark:bg-dark rounded-xl shadow-md overflow-hidden ">
                <div class="relative">
                    <img src="images/swiggy.jpg" alt="Swiggy" class="w-full h-48 object-cover">
                    <div class="absolute top-4 right-4 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                        ₹100 OFF
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <img src="https://logo.clearbit.com/swiggy.com" alt="Swiggy" class="w-10 h-10 rounded-full mr-3">
                        <h3 class="text-xl font-bold text-white ">Swiggy</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">On orders above ₹399</p>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Use code:</span>
                            <span class="font-mono font-bold text-primary ml-2">SWIGGY100</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="far fa-clock mr-1"></i> Expires: 25/06/2025
                        </div>
                    </div>
                    <button class="w-full bg-secondary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-copy mr-2"></i> Copy Code
                    </button>
                    <div class="mt-3 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span><i class="fas fa-users mr-1"></i> 156 used today</span>
                        <span class="text-green-500"><i class="fas fa-check-circle mr-1"></i> Verified</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="search.php" class="inline-block bg-primary hover:bg-opacity-90 text-dark font-bold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                View All Coupons <i class="fas fa-arrow-right ml-2"></i>
            </a>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 py-12 bg-gray-50 dark:bg-gray-900">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white  mb-4 font-bold text-2xl"> Shop by Category</h2>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Find deals in your favorite shopping categories</p>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <a href="search.php?category=electronics" class="bg-white dark:bg-dark rounded-lg shadow-md p-6 text-center transition transform hover:scale-105 hover:shadow-lg">
                <div class="bg-blue-100 dark:bg-blue-900 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-laptop text-blue-500 dark:text-blue-300 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Electronics</h3>
            </a>
            
            <a href="search.php?category=fashion" class="bg-white dark:bg-dark rounded-lg shadow-md p-6 text-center transition transform hover:scale-105 hover:shadow-lg">
                <div class="bg-pink-100 dark:bg-pink-900 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-tshirt text-pink-500 dark:text-pink-300 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Fashion</h3>
            </a>
            
            
            <a href="search.php?category=Food" class="bg-white dark:bg-dark rounded-lg shadow-md p-6 text-center transition transform hover:scale-105 hover:shadow-lg">
                <div class="bg-green-100 dark:bg-green-900 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-utensils text-green-500 dark:text-green-300 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Food</h3>
            </a>
            
        
            <a href="search.php?category=travel" class="bg-white dark:bg-dark rounded-lg shadow-md p-6 text-center transition transform hover:scale-105 hover:shadow-lg">
                <div class="bg-purple-100 dark:bg-purple-900 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-plane text-purple-500 dark:text-purple-300 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Travel</h3>
            </a>
            
            <a href="search.php?category=Learning" class="bg-white dark:bg-dark rounded-lg shadow-md p-6 text-center transition transform hover:scale-105 hover:shadow-lg">
                <div class="bg-red-100 dark:bg-red-900 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-3">
                <i class="fa-solid fa-book text-purple-500 dark:text-purple-300 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Learning</h3>
            </a>
            
    
            <a href="search.php?category=Home" class="bg-white dark:bg-dark rounded-lg shadow-md p-6 text-center transition transform hover:scale-105 hover:shadow-lg">
                <div class="bg-yellow-100 dark:bg-yellow-900 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-home text-yellow-500 dark:text-yellow-300 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Home</h3>
            </a>
        </div>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800  mb-4">🏆 Top Brands</h2>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Popular brands with active coupons</p>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
            <?php 
            $brands = [
                ['name' => 'Amazon', 'logo' => 'https://logo.clearbit.com/amazon.com', 'coupons' => 42],
                ['name' => 'Flipkart', 'logo' => 'https://logo.clearbit.com/flipkart.com', 'coupons' => 35],
                ['name' => 'Myntra', 'logo' => 'https://logo.clearbit.com/myntra.com', 'coupons' => 28],
                ['name' => 'Zomato', 'logo' => 'https://logo.clearbit.com/zomato.com', 'coupons' => 19],
                ['name' => 'Swiggy', 'logo' => 'https://logo.clearbit.com/swiggy.com', 'coupons' => 15],
                ['name' => 'Nykaa', 'logo' => 'https://logo.clearbit.com/nykaa.com', 'coupons' => 12],
                ['name' => 'Ajio', 'logo' => 'https://logo.clearbit.com/ajio.com', 'coupons' => 10],
                ['name' => 'Mamaearth', 'logo' => 'https://logo.clearbit.com/mamaearth.in', 'coupons' => 8],
                ['name' => 'MakeMyTrip', 'logo' => 'https://logo.clearbit.com/makemytrip.com', 'coupons' => 20],
                ['name' => 'Tata CLiQ', 'logo' => 'https://logo.clearbit.com/tatacliq.com', 'coupons' => 14],
            ];
            
            foreach ($brands as $index => $brand) {
                echo '
                <a href="search.php?brand=' . strtolower($brand['name']) . '" class="bg-white dark:bg-dark rounded-lg shadow-md p-4 text-center transition transform hover:scale-105 hover:shadow-lg" >
                    <img src="' . $brand['logo'] . '" alt="' . $brand['name'] . '" class="w-16 h-16 mx-auto mb-3 rounded-full object-contain">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-1">' . $brand['name'] . '</h3>
                    <span class="text-sm text-primary">' . $brand['coupons'] . ' coupons</span>
                </a>';
            }
            ?>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 py-12 bg-gray-50 dark:bg-gray-900">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">📌 How It Works</h2>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Start saving in just 3 simple steps</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-dark rounded-xl shadow-md p-6 text-center">
                <div class="bg-primary bg-opacity-10 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 text-primary text-2xl font-bold">1</div>
                <i class="fas fa-search text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Find Coupons</h3>
                <p class="text-gray-600 dark:text-gray-300">Browse our collection of verified discount codes</p>
            </div>
            
            
            <div class="bg-white dark:bg-dark rounded-xl shadow-md p-6 text-center">
                <div class="bg-primary bg-opacity-10 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 text-primary text-2xl font-bold">2</div>
                <i class="fas fa-copy text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Copy Code</h3>
                <p class="text-gray-600 dark:text-gray-300">Click to copy the discount code to clipboard</p>
            </div>
            
    
            <div class="bg-white dark:bg-dark rounded-xl shadow-md p-6 text-center">
                <div class="bg-primary bg-opacity-10 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 text-primary text-2xl font-bold">3</div>
                <i class="fas fa-shopping-cart text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Shop & Save</h3>
                <p class="text-gray-600 dark:text-gray-300">Apply the code at checkout and enjoy your savings</p>
            </div>
        </div>
    </section>

    
    <section class="bg-gradient-to-r from-primary to-accent py-16 mt-100 mt-[40px]">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">💌 Never Miss a Deal</h2>
            <p class="text-dark text-lg mb-8 max-w-2xl mx-auto">Subscribe to get exclusive coupons & deals straight to your inbox</p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-dark">
                <button type="submit" class="bg-dark hover:bg-opacity-90 text-white font-bold px-6 py-3 rounded-lg transition">
                    Subscribe
                </button>
            </form>
            
            <p class="text-dark text-sm mt-4">
                <i class="fas fa-lock mr-1"></i> We respect your privacy. Unsubscribe at any time.
            </p>
        </div>
    </section>

    <footer class="bg-dark text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">CouponHub</h3>
                    <p class="mb-4">Your one-stop destination for the best coupons and discount codes.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="hover:text-white transition">Home</a></li>
                        <li><a href="search.php" class="hover:text-white transition">Search Coupons</a></li>
                        <li><a href="reviews.php" class="hover:text-white transition">Store Reviews</a></li>
                        <li><a href="contact.php" class="hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li><a href="search.php?category=electronics" class="hover:text-white transition">Electronics</a></li>
                        <li><a href="search.php?category=fashion" class="hover:text-white transition">Fashion</a></li>
                        <li><a href="search.php?category=food" class="hover:text-white transition">Food & Dining</a></li>
                        <li><a href="search.php?category=travel" class="hover:text-white transition">Travel</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">DMCA</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2025 CouponHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>