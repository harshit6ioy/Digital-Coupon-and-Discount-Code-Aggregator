<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $store = mysqli_real_escape_string($conn, $_POST['store']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);


    
    $query = "INSERT INTO coupons (store, discount, code, expiry_date, image_url, category) 
              VALUES ('$store', '$discount', '$code', '$expiry_date', '$image_url', '$category')";

    if (mysqli_query($conn, $query)) {
        $success_message = "Coupon added successfully!";
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Coupon - Coupon Aggregator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7f00ff',
                        secondary: '#ff007f',
                        
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
            background: #f8fafc;
        }
        
        .form-container {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }
        
        .input-field:focus {
            border-color: #7f00ff;
            box-shadow: 0 0 0 3px rgba(127, 0, 255, 0.1);
        }
        
        

    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-primary to-secondary p-4 text-white shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-tag text-2xl mr-3"></i>
                <h1 class="text-2xl font-bold">CouponFinder</h1>
            </div>
            <div>
                <a href="index.php" class="px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">Back to Home</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="form-container bg-white">
            <div class="bg-gradient-to-r from-primary to-secondary p-6 text-white">
                <div class="flex items-center">
                    <i class="fas fa-plus-circle text-3xl mr-3"></i>
                    <div>
                        <h2 class="text-2xl font-bold">Add New Coupon</h2>
                        <p class="text-white text-opacity-80">Fill in the required details below</p>
                    </div>
                </div>
            </div>
            
            <?php if (isset($success_message)): ?>
                <div class="success-message bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span><?= $success_message ?></span>
                    </div>
                </div>
            <?php elseif (isset($error_message)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span><?= $error_message ?></span>
                    </div>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="p-6 space-y-6">
                <div>
                    <label for="store" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-store mr-2 text-primary"></i>Store Name
                    </label>
                    <input type="text" id="store" name="store" 
                           class="input-field w-full px-4 py-3 rounded-lg focus:outline-none" 
                           placeholder="e.g. Amazon, Walmart" required>
                </div>
                
                <div>
                    <label for="discount" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-percentage mr-2 text-primary"></i>Discount Offer
                    </label>
                    <input type="text" id="discount" name="discount" 
                           class="input-field w-full px-4 py-3 rounded-lg focus:outline-none" 
                           placeholder="e.g. 20% Off, $10 Discount" required>
                </div>
                
                <div>
                    <label for="code" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-ticket-alt mr-2 text-primary"></i>Coupon Code
                    </label>
                    <div class="relative">
                        <input type="text" id="code" name="code" 
                               class="input-field w-full px-4 py-3 rounded-lg focus:outline-none pr-10" 
                               placeholder="e.g. SAVE20" required>
                        <button type="button" onclick="generateRandomCode()" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-primary hover:text-secondary">
                            <i class="fas fa-random"></i>
                        </button>
                    </div>
                </div>
                <!-- Category -->
<div>
    <label for="category" class="block text-gray-700 font-medium mb-2">
        <i class="fas fa-list-alt mr-2 text-primary"></i>Category
    </label>
    <select id="category" name="category" 
            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none" required>
        <option value="">Select a Category</option>
        <option value="Electronics">Electronics</option>
        <option value="Fashion">Fashion</option>
        <option value="Food & Dining">Food & Dining</option>
        <option value="Groceries">Groceries</option>
        <option value="Travel">Travel</option>
        <option value="Home & Garden">Home & Garden</option>
        <option value="Learning">Learning</option>
    </select>
</div>
                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-gray-700 font-medium mb-2">
                        <i class="far fa-calendar-alt mr-2 text-primary"></i>Expiry Date
                    </label>
                    <input type="date" id="expiry_date" name="expiry_date" 
                           class="input-field w-full px-4 py-3 rounded-lg focus:outline-none" required>
                </div>
                
                <!-- Image URL -->
                <div>
                    <label for="image_url" class="block text-gray-700 font-medium mb-2">
                        <i class="far fa-image mr-2 text-primary"></i>Image URL
                    </label>
                    <input type="text" id="image_url" name="image_url" 
                           class="input-field w-full px-4 py-3 rounded-lg focus:outline-none" 
                           placeholder="https://example.com/image.jpg" 
                           oninput="updateImagePreview(this.value)">
                    <div class="mt-2">
                        <img id="imagePreview" src="https://via.placeholder.com/600x200?text=Store+Logo" 
                             alt="Preview" class="preview-image w-full border">
                    </div>
                </div>
                
                <!-- Form Footer -->
                <div class="pt-4 border-t border-gray-100 flex justify-end space-x-4">
                    <button type="reset" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-redo mr-2"></i>Reset Form
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-lg hover:opacity-90 transition shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i>Add Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Generate random coupon code
        function generateRandomCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 8; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('code').value = result;
        }
        
        // Update image preview
        function updateImagePreview(url) {
            const preview = document.getElementById('imagePreview');
            if (url) {
                preview.src = url;
            } else {
                preview.src = 'https://via.placeholder.com/600x200?text=Store+Logo';
            }
        }
        
        // Set minimum date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('expiry_date').min = today;
        });
    </script>
</body>
</html>