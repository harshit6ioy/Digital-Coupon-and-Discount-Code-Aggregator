<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Set secure, HttpOnly cookie
            $session_id = session_id();
            setcookie('session_token', $session_id, [
                'expires' => time() + 86400 * 30, // 30 days
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            
            // Redirect with success message
            $_SESSION['login_success'] = true;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
    error_log("Failed login attempt for username: $username");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coupon Aggregator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            
            background-size: 200% 200%;
           
            min-height: 100vh;
        }
        
        
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-600">
    <div class="glass-card w-full max-w-md p-8">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tag text-3xl text-gradient bg-clip-text text-transparent bg-gradient-to-r from-purple-500 to-pink-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">CouponHub</h1>
            <p class="text-slate-900 mt-2">Welcome back! Please login to continue</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message bg-red-500 bg-opacity-20 text-red-100 p-4 rounded-lg mb-6 border border-red-400 flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <p class="font-medium"><?= $error ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5" id="loginForm">
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="username" placeholder="Enter your username" 
                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-20"
                        required minlength="3" maxlength="20" autocomplete="username">
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Enter your password" 
                        class="form-input w-full pl-10 pr-10 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-20"
                        required minlength="8" autocomplete="current-password">
                    <button type="button" onclick="togglePasswordVisibility()" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white">
                        <i id="eye-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" 
                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">
                        Remember me
                    </label>
                </div>
                <a href="forgot-password.php" class="text-sm text-white hover:text-primary forgot-password">
                    Forgot password?
                </a>
            </div>
            <button type="submit" id="submit-btn" 
                class="btn-primary w-full text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center">
                <span id="btn-text">Login</span>
                <span id="loading-spinner" class="ml-2 hidden">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
            </button>
        </form>
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 border-opacity-30"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-transparent text-gray-300">Or continue with</span>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-3 gap-3">
                <a href="#" class="w-full inline-flex justify-center py-2 px-4 rounded-md bg-white bg-opacity-10 hover:bg-opacity-20 transition">
                    <i class="fab fa-google text-white"></i>
                </a>
                <a href="#" class="w-full inline-flex justify-center py-2 px-4 rounded-md bg-white bg-opacity-10 hover:bg-opacity-20 transition">
                    <i class="fab fa-facebook-f text-white"></i>
                </a>
                <a href="#" class="w-full inline-flex justify-center py-2 px-4 rounded-md bg-white bg-opacity-10 hover:bg-opacity-20 transition">
                    <i class="fab fa-twitter text-white"></i>
                </a>
            </div>
        </div>
        <div class="text-center mt-6">
            <p class="text-gray-300">Don't have an account? 
                <a href="register.php" class="text-white font-medium hover:underline">Sign up</a>
            </p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const loadingSpinner = document.getElementById('loading-spinner');
            
            // Show loading state
            btnText.textContent = 'Logging in...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;
        });
        document.addEventListener("DOMContentLoaded", function() {
            const rememberedUsername = localStorage.getItem('rememberedUsername');
            if (rememberedUsername) {
                document.querySelector('input[name="username"]').value = rememberedUsername;
                document.getElementById('remember').checked = true;
            }
            
            // Focus on username field if empty
            if (!document.querySelector('input[name="username"]').value) {
                document.querySelector('input[name="username"]').focus();
            }
        });
    </script>
</body>
</html>