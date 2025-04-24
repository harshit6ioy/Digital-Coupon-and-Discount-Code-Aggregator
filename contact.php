<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aggarwalharshit865@gmail.com';
        $mail->Password = 'eboh gevu lfha hyof';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress('aggarwalharshit865@gmail.com');
        $mail->Subject = "New Contact Message from $name";
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        if($mail->send()) {
            $success_message = "✅ Message Sent Successfully!";
        }
    } catch (Exception $e) {
        $error_message = "❌ Message Sending Failed! Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Coupon Aggregator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        
    </style>
</head>
<body class="min-h-screen">
    <nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <i class="fas fa-tag text-white text-2xl"></i>
                    <span class="text-white font-bold text-xl mr-6 pr-4">CouponHub</span>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
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
            <div class="max-w-4xl mx-auto mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p><?= $success_message ?></p>
                </div>
            </div>
        <?php elseif(isset($error_message)): ?>
            <div class="max-w-4xl mx-auto mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p><?= $error_message ?></p>
                </div>
            </div>
        <?php endif; ?>

        
        <section class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Get In Touch</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Have questions or feedback? We'd love to hear from you! Our team is always ready to help.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                
                <div class="glass-card p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Send us a message</h2>
                    <form method="POST" onsubmit="return validateForm()">
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                            <input type="text" id="name" name="name" required 
                                class="w-full px-4 py-3 rounded-lg form-input focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required 
                                class="w-full px-4 py-3 rounded-lg form-input focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                            <textarea id="message" name="message" rows="5" required 
                                class="w-full px-4 py-3 rounded-lg form-input focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>
                        
                        <button type="submit" 
                            class="w-full bg-slate-800 text-white font-bold px-6 py-3 rounded-lg mt-2">
                            <i class="fas fa-paper-plane mr-2"></i> Send Message
                        </button>
                    </form>
                </div>

                
                <div>
                    <div class="contact-card p-8 rounded-xl shadow-sm mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0  bg-opacity-10 p-3 rounded-full text-primary">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Address</h3>
                                    <p class="text-base text-gray-800">Lovely Professional University,Jalandhar,Punjab</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0  bg-opacity-10 p-3 rounded-full text-primary">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                                    <p class="text-base text-gray-800">+91 7347698382</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0  bg-opacity-10 p-3 rounded-full text-primary">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                    <p class="text-base text-gray-800">aggarwalharshit865@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="contact-card p-8 rounded-xl shadow-sm">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Follow Us</h2>
                        <p class="text-gray-600 mb-6">Stay connected with us on social media for the latest updates and offers.</p>
                        
                        <div class="flex space-x-4">
                            <a href="#" class="social-icon text-gray-700 hover:text-blue-600">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                            <a href="#" class="social-icon text-gray-700 hover:text-blue-400">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="#" class="social-icon text-gray-700 hover:text-pink-600">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="#" class="social-icon text-gray-700 hover:text-blue-700">
                                <i class="fab fa-linkedin-in fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="max-w-4xl mx-auto mt-16 rounded-xl overflow-hidden shadow-lg" data-aos="fade-up">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1746303.0984075544!2d73.18237594806745!3d31.255392100000012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5f5e9c489cf3%3A0x4049a5409d53c300!2sLovely%20Professional%20University!5e0!3m2!1sen!2sin!4v1743525119804!5m2!1sen!2sin" width="1000" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <h3 class="text-xl font-bold">CouponHub</h3>
                <p class="text-gray-400 text-sm">Find the best deals online</p>
            </div>
            <div class="flex space-x-6">
                <a href="index.php" class="text-gray-400 hover:text-white transition">Home</a>
                <a href="search.php" class="text-gray-400 hover:text-white transition">Coupons</a>
                <a href="contact.php" class="text-gray-400 hover:text-white transition">Contact</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Privacy</a>
            </div>
        </div>
        <div class="mt-6 pt-6 border-t border-gray-700 text-center text-gray-400 text-sm">
            <p>&copy; 2023 CouponHub. All rights reserved.</p>
        </div>
    </div>
</footer>
</body>
</html>