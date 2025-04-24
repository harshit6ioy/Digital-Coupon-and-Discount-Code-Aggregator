<?php
session_start();
include 'config.php';

// Handle Review Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'] ?? "Guest"; 
    $rating = $_POST['rating'];
    $comment = trim($_POST['comment']);

    if(empty($comment)) {
        $error_message = "Please write your review before submitting";
    } else {
        $query = "INSERT INTO reviews (username, rating, comment) VALUES ('$username', '$rating', '$comment')";
        if (mysqli_query($conn, $query)) {
            $success_message = "Thank you for your review!";
        } else {
            $error_message = "Failed to submit review. Please try again.";
        }
    }
    
}

// Fetch Reviews
$reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Coupon Aggregator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff007f',
                        secondary: '#7f00ff',
                        dark: '#1e293b',
                        light: '#f8fafc'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        };
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        
    </style>
</head>
<body class="min-h-screen">

    
    <nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 shadow-lg sticky top-0 z-50 h-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <div class=" flex items-center justify-center ml-2">
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
   
</div>
        </div>
    </div>
</nav>



    
    <main class="py-12 px-4 sm:px-6 lg:px-8">
    
        <?php if(isset($success_message)): ?>
            <div class="max-w-4xl mx-auto mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center" role="alert">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <div>
                    <p class="font-medium"><?= $success_message ?></p>
                    <p class="text-sm">We appreciate your feedback!</p>
                </div>
            </div>
        <?php elseif(isset($error_message)): ?>
            <div class="max-w-4xl mx-auto mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center" role="alert">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <div>
                    <p class="font-medium"><?= $error_message ?></p>
                </div>
            </div>
        <?php endif; ?>

        
        <section class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Share Your Experience</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Help us improve by sharing your thoughts about our coupon aggregator service.</p>
            </div>

            <div class="p-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-lg font-medium text-gray-700 mb-3">How would you rate your experience?</label>
                        <div id="stars" class="flex justify-center space-x-4 text-4xl cursor-pointer text-gray-300 star-rating">
                            <span class="star" data-value="1">★</span>
                            <span class="star" data-value="2">★</span>
                            <span class="star" data-value="3">★</span>
                            <span class="star" data-value="4">★</span>
                            <span class="star" data-value="5">★</span>
                        </div>
                        <input type="hidden" id="ratingInput" name="rating" required>
                        <p id="ratingFeedback" class="text-center mt-2 text-sm font-medium text-gray-500"></p>
                    </div>
                    
                    <div>
                        <label for="comment" class="block text-lg font-medium text-gray-700 mb-3">Tell us more about your experience</label>
                        <textarea id="comment" name="comment" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent textarea-animate"
                            placeholder="What did you like? What could we improve?"></textarea>
                    </div>
                    
                    <button type="submit" 
                        class="w-full btn-primary text-white font-bold px-6 py-3 rounded-lg mt-2 bg-slate-800">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Review
                    </button>
                </form>
            </div>
        </section>

        <section class="max-w-4xl mx-auto mt-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">What Our Users Say</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Read honest reviews from our community of coupon enthusiasts.</p>
            </div>

            <div class="space-y-6">
                <?php while ($review = mysqli_fetch_assoc($reviews)) : ?>
                    <div class="review-card p-6 rounded-xl">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center mb-2">
                                    <p class="text-lg font-bold text-gray-800 mr-3"><?= $review['username'] ?></p>
                                    <div class="text-yellow-400 text-xl">
                                        <?= str_repeat("★", $review['rating']) ?><?= str_repeat("☆", 5 - $review['rating']) ?>
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-3"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                                <p class="text-gray-400 text-sm"><i class="far fa-clock mr-1"></i> <?= date('F j, Y \a\t g:i a', strtotime($review['created_at'])) ?></p>
                            </div>
                            <div class="text-gray-300 text-4xl opacity-20">
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <?php if(mysqli_num_rows($reviews) == 0): ?>
                    <div class="text-center py-12" data-aos="fade-up">
                        <i class="fas fa-comment-slash text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-600">No reviews yet</h3>
                        <p class="text-gray-500 mt-2">Be the first to share your experience!</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="bg-black text-white py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">CouponHub</h3>
                <p class="text-white text-opacity-80">Your one-stop destination for the best deals and coupons online.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-white text-opacity-80 hover:text-opacity-100 transition">Home</a></li>
                    <li><a href="search.php" class="text-white text-opacity-80 hover:text-opacity-100 transition">Search Coupons</a></li>
                    <li><a href="reviews.php" class="text-white text-opacity-80 hover:text-opacity-100 transition">Reviews</a></li>
                    <li><a href="contact.php" class="text-white text-opacity-80 hover:text-opacity-100 transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Support</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-white text-opacity-80 hover:text-opacity-100 transition">FAQ</a></li>
                    <li><a href="#" class="text-white text-opacity-80 hover:text-opacity-100 transition">Privacy Policy</a></li>
                    <li><a href="#" class="text-white text-opacity-80 hover:text-opacity-100 transition">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Newsletter</h4>
                <p class="text-white text-opacity-80 mb-4">Subscribe to get the latest deals and updates.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="w-full px-4 py-2 rounded-l-lg text-gray-800 focus:outline-none">
                    <button type="submit" class="bg-white text-black px-4 py-2 rounded-r-lg font-medium">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="border-t border-white border-opacity-20 mt-8 pt-8 text-center text-white text-opacity-70">
            <p>&copy; <?= date('Y') ?> CouponHub. All rights reserved.</p>
        </div>
    </div>
</footer>


    <!-- JavaScript -->
    
    <script>
    
        

        
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingInput');
        const ratingFeedback = document.getElementById('ratingFeedback');
        
        const ratingMessages = {
            1: "Poor - We're sorry to hear that. We'll work to improve!",
            2: "Fair - Thanks for your feedback. We'll do better!",
            3: "Good - We appreciate your review!",
            4: "Very Good - Thank you for your positive feedback!",
            5: "Excellent - We're thrilled you're happy with our service!"
        };
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;
                
                // Update star colors
                stars.forEach((s, index) => {
                    s.style.color = index < value ? "#fbbf24" : "#e5e7eb";
                });
                
                
                ratingFeedback.textContent = ratingMessages[value];
                ratingFeedback.style.color = "#4b5563";
            });
            
            star.addEventListener('mouseover', function() {
                const hoverValue = parseInt(this.getAttribute('data-value'));
                stars.forEach((s, index) => {
                    s.style.color = index < hoverValue ? "#fcd34d" : "#e5e7eb";
                });
            });
            
            star.addEventListener('mouseout', function() {
                if (!ratingInput.value) {
                    stars.forEach(s => s.style.color = "#e5e7eb");
                } else {
                    const currentValue = parseInt(ratingInput.value);
                    stars.forEach((s, index) => {
                        s.style.color = index < currentValue ? "#fbbf24" : "#e5e7eb";
                    });
                }
            });
        });

        
        document.getElementById('themeToggle').addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            const icon = this.querySelector('i');
            if (document.documentElement.classList.contains('dark')) {
                icon.classList.replace('fa-moon', 'fa-sun');
            } else {
                icon.classList.replace('fa-sun', 'fa-moon');
            }
        });
    </script>
</body>
</html>


