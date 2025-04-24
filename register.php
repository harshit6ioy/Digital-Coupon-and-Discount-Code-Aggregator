<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validate password strength
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $error = "Password must contain at least 8 characters including uppercase, lowercase, numbers, and special characters";
    } else {
        // Check if username or email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Username or email already exists";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                $success = "Registration successful! Welcome, $username";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 2000);
                </script>";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Coupon Aggregator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
       
        body {
            font-family: 'Poppins', sans-serif;
           
            background-size: 200% 200%;
            
            min-height: 100vh;
        }
        
        
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-600 ">

    <div class="glass-card w-full max-w-md p-8">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tag text-3xl text-gradient bg-clip-text text-transparent bg-gradient-to-r from-purple-500 to-pink-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">CouponHub</h1>
            <p class="text-slate-900 mt-2">Create your free account</p>
        </div>

        <?php if (isset($success)): ?>
            <div class="success-message bg-green-500 bg-opacity-20 text-green-100 p-4 rounded-lg mb-6 border border-green-400 flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <div>
                    <p class="font-medium"><?= $success ?></p>
                    <p class="text-sm opacity-80 mt-1">Redirecting to dashboard...</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error-message bg-red-500 bg-opacity-20 text-red-100 p-4 rounded-lg mb-6 border border-red-400 flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <p class="font-medium"><?= $error ?></p>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" class="space-y-5" id="registerForm">
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="username" placeholder="Enter your username" 
                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-20 border-gray-800"
                        required minlength="3" maxlength="20">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" placeholder="Enter your email" 
                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-20"
                        required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Create a password" 
                        class="form-input w-full pl-10 pr-10 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-20"
                        required minlength="8">
                    <button type="button" onclick="togglePasswordVisibility()" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white">
                        <i id="eye-icon" class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-strength-meter mt-2">
                    <div id="password-strength-meter-fill" class="password-strength-meter-fill"></div>
                </div>
                <p id="password-strength-text" class="text-xs mt-1 text-gray-400"></p>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="terms" name="terms" required
                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-300">
                    I agree to the <a href="#" class="text-white hover:underline">Terms of Service</a> and <a href="#" class="text-white hover:underline">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="submit-btn" 
                class="btn-primary w-full text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center">
                <span id="btn-text">Create Account</span>
                <span id="loading-spinner" class="ml-2 hidden">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-300">Already have an account? 
                <a href="login.php" class="text-white font-medium hover:underline">Sign in</a>
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
            } else {gti 
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }


        // Password Strength Indicator
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.getElementById('password-strength-meter-fill');
        const strengthText = document.getElementById('password-strength-text');

        passwordInput.addEventListener('input', function () {
            const strength = calculatePasswordStrength(this.value);
            updateStrengthIndicator(strength);
        });

        function calculatePasswordStrength(password) {
            let strength = 0;

            // Length check
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;

            // Character type checks
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            return Math.min(strength, 5); // Cap at 5
        }

        function updateStrengthIndicator(strength) {
            const percentages = ['0%', '20%', '40%', '60%', '80%', '100%'];
            const colors = ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#10b981'];
            const messages = [
                'Very Weak',
                'Weak',
                'Moderate',
                'Strong',
                'Very Strong'
            ];

            strengthMeter.style.width = percentages[strength];
            strengthMeter.style.backgroundColor = colors[strength - 1] || '#ef4444';
            strengthText.textContent = strength > 0 ? messages[strength - 1] : '';
            strengthText.style.color = colors[strength - 1] || '#ef4444';
        }
        
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const loadingSpinner = document.getElementById('loading-spinner');
            
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('Please agree to the Terms of Service and Privacy Policy');
                return;
            }
            
            btnText.textContent = 'Creating Account...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>