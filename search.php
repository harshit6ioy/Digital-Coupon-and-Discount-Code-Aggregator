<?php
include 'db.php';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$query = "SELECT store, discount, code, expiry_date, created_at, image_url, category 
          FROM coupons 
          WHERE expiry_date >= CURDATE()";
if (!empty($category)) {
    $query .= " AND category = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $category);
} else {
    $stmt = $conn->prepare($query);
}
$stmt->execute();
$result = $stmt->get_result();
$coupons = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Coupons - Coupon Aggregator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff007f',
                        secondary: '#7f00ff',
                        dark: '#1e293b',
                        accent: '#00c9a7'
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
            background: linear-gradient(to bottom right, #f8fafc, #e2e8f0);
        }
        
        .coupon-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: linear-gradient(to bottom right, #ffffff, #f9fafb);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        
        .coupon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .coupon-image {
            height: 180px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .coupon-card:hover .coupon-image {
            transform: scale(1.05);
        }
        
        .coupon-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: rgba(255, 0, 127, 0.9);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .search-bar {
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .search-bar:focus-within {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }
        
        .filter-dropdown {
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .filter-dropdown:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        
        .copy-btn {
            position: relative;
            overflow: hidden;
        }
        
        .copy-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
            opacity: 0;
            transition: opacity 0.5s;
        }
        
        .copy-btn:active::after {
            opacity: 1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .empty-state {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
            border-radius: 12px;
        }
        
        .progress-bar {
            position: relative;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(to right, #7f00ff, #ff007f);
            animation: progress 1.5s ease-in-out infinite;
            background-size: 200% 100%;
        }
        
       
        
    </style>
</head>
<body class="min-h-screen">

    
    <nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <i class="fas fa-tag text-white text-2xl mr-2"></i>
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

    
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Find Amazing Deals</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover the best coupons and discount codes from your favorite stores</p>
        </div>

        <div class="flex flex-col items-center">
            <div class="search-bar p-1 rounded-lg w-full max-w-2xl flex items-center mb-4">
                <i class="fas fa-search text-gray-400 ml-4 mr-2"></i>
                <input type="text" id="searchInput" placeholder="Search by store, category or discount..." 
                       class="w-full px-4 py-3 focus:outline-none text-gray-800 placeholder-gray-400">
                <button class="bg-accent text-white px-6 py-3 rounded-lg ml-2 hover:bg-opacity-90 transition">
                    Search
                </button>
            </div>

            <div class="flex flex-wrap justify-center gap-3 mt-4 w-full">
            <select id="categoryFilter" class="filter-dropdown px-4 py-2 text-gray-800 w-full md:w-auto" onchange="applyCategoryFilter()">
    <option value="" <?= empty($_GET['category']) ? 'selected' : '' ?>>All Categories</option>
    <option value="Electronics" <?= (isset($_GET['category']) && $_GET['category'] === 'Electronics') ? 'selected' : '' ?>>Electronics</option>
    <option value="Fashion" <?= (isset($_GET['category']) && $_GET['category'] === 'Fashion') ? 'selected' : '' ?>>Fashion</option>
    <option value="Groceries" <?= (isset($_GET['category']) && $_GET['category'] === 'Groceries') ? 'selected' : '' ?>>Groceries</option>
    <option value="Travel" <?= (isset($_GET['category']) && $_GET['category'] === 'Travel') ? 'selected' : '' ?>>Travel</option>
    <option value="Food" <?= (isset($_GET['category']) && $_GET['category'] === 'Food') ? 'selected' : '' ?>>Food & Dining</option>
    <option value="Home" <?= (isset($_GET['category']) && $_GET['category'] === 'Home') ? 'selected' : '' ?>>Home & Garden</option>
    <option value="Learning"  <?= (isset($_GET['category']) && $_GET['category'] === 'Learning') ? 'selected' : '' ?>>Learning</option>
</select>

                <select id="discountFilter" class="filter-dropdown px-4 py-2 text-gray-800 w-full md:w-auto">
                    <option value="">Any Discount</option>
                    <option value="10">10% or more</option>
                    <option value="20">20% or more</option>
                    <option value="30">30% or more</option>
                    <option value="50">50% or more</option>
                </select>

                <input type="date" id="expiryFilter" class="filter-dropdown px-4 py-2 text-gray-800 w-full md:w-auto">
                
                <button id="resetFilters" class="px-4 py-2 text-gray-600 hover:text-primary transition w-full md:w-auto">
                    <i class="fas fa-sync-alt mr-2"></i>Reset
                </button>
            </div>
        </div>
    </section>

    
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">
                <span id="resultCount"><?= count($coupons) ?></span> Coupons Available
            </h3>
            <div class="flex items-center">
                <span class="text-sm text-gray-600 mr-2">Sort by:</span>
                <select id="sortBy" class="filter-dropdown px-3 py-1 text-gray-800 text-sm">
                    <option value="newest">Newest First</option>
                    <option value="expiring">Expiring Soon</option>
                    <option value="discount">Highest Discount</option>
                    <option value="popular">Most Popular</option>
                </select>
            </div>
        </div>

        <div id="couponList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($coupons as $coupon): 
                $expiry_date = new DateTime($coupon['expiry_date']);
                $today = new DateTime();
                $days_left = $today->diff($expiry_date)->days;
                $is_new = (new DateTime($coupon['created_at']))->diff($today)->days <= 3;
            ?>
                <div class="coupon-card shadow-md hover:shadow-xl" 
                     data-store="<?= strtolower($coupon['store']) ?>" 
                     data-category="<?= $coupon['category'] ?? 'Uncategorized' ?>" 
                     data-discount="<?= (int)filter_var($coupon['discount'], FILTER_SANITIZE_NUMBER_INT) ?>"
                     data-expiry="<?= $coupon['expiry_date'] ?>"
                     data-created="<?= $coupon['created_at'] ?>">
                    <div class="relative overflow-hidden">
                        <img src="<?= $coupon['image_url'] ?: 'https://via.placeholder.com/400x200?text='.urlencode($coupon['store']) ?>" 
                             alt="<?= $coupon['store'] ?>" 
                             class="coupon-image w-full">
                        
                        <?php if ($is_new): ?>
                            <div class="coupon-badge">NEW</div>
                        <?php endif; ?>
                        
                        <?php if ($days_left <= 7): ?>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-red-500"></div>
                        <?php elseif ($days_left <= 14): ?>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-yellow-500"></div>
                        <?php else: ?>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-green-500"></div>
                        <?php endif; ?>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-lg font-bold text-gray-800 truncate"><?= $coupon['store'] ?></h4>
                            <span class="bg-primary bg-opacity-10 text-primary px-2 py-1 rounded text-sm font-bold">
                                <?= $coupon['discount'] ?>
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4"><?= $coupon['description'] ?? 'Save big on your purchase with this exclusive offer' ?></p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs text-gray-500">Expires in <?= $days_left ?> days</p>
                                <div class="progress-bar mt-1 w-full">
                                    <div class="h-full bg-gradient-to-r from-green-400 to-blue-500" 
                                         style="width: <?= min(100, max(5, 100 - ($days_left / 30) * 100)) ?>%"></div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">
                                <?= date("M j, Y", strtotime($coupon['expiry_date'])) ?>
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                            <code class="font-mono text-gray-800 font-bold"><?= $coupon['code'] ?></code>
                            <button class="copy-btn bg-secondary text-white px-4 py-2 rounded-lg text-sm hover:bg-opacity-90 transition"
                                    onclick="copyToClipboard('<?= $coupon['code'] ?>', this)">
                                Copy
                            </button>
                        </div>
                        
                        <div class="mt-3 flex justify-between items-center text-xs text-gray-500">
                            <span><i class="fas fa-calendar-alt mr-1"></i> Added <?= date("M j", strtotime($coupon['created_at'])) ?></span>
                            <span><i class="fas fa-users mr-1"></i> 124 used today</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div id="emptyState" class="hidden col-span-full empty-state p-10 text-center rounded-xl">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-search fa-3x text-gray-400 mb-4"></i>
                    <h4 class="text-xl font-bold text-gray-700 mb-2">No coupons found</h4>
                    <p class="text-gray-500 mb-6">Try adjusting your search or filters to find what you're looking for.</p>
                    <button id="resetAllFilters" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition">
                        Reset All Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-8 rounded-xl text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-primary mx-auto mb-4"></div>
            <h3 class="text-lg font-medium text-gray-800">Searching for coupons...</h3>
            <p class="text-gray-600 mt-1">We're finding the best deals for you</p>
        </div>
    </div>

    <div id="copiedNotification" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform translate-y-10 opacity-0 transition-all duration-300 z-50">
        <i class="fas fa-check-circle mr-2"></i> Copied to clipboard!
    </div>

    <script>
        function filterCoupons() {
            const loadingSpinner = document.getElementById('loadingSpinner');
            loadingSpinner.classList.remove('hidden');
            
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value.toLowerCase();
            const discount = parseInt(document.getElementById('discountFilter').value) || 0;
            const expiryDate = document.getElementById('expiryFilter').value;
            const sortBy = document.getElementById('sortBy').value;
            
            setTimeout(() => {
                let coupons = document.querySelectorAll('.coupon-card');
                let visibleCount = 0;
                
                coupons.forEach(coupon => {
                    const store = coupon.dataset.store;
                    const couponCategory = coupon.dataset.category.toLowerCase();
                    const couponDiscount = parseInt(coupon.dataset.discount);
                    const couponExpiry = coupon.dataset.expiry;
                    const couponCreated = coupon.dataset.created;
                    
                    const matchesSearch = store.includes(searchValue) || 
                                        coupon.textContent.toLowerCase().includes(searchValue);
                    const matchesCategory = category === "" || couponCategory.includes(category);
                    const matchesDiscount = discount === 0 || couponDiscount >= discount;
                    const matchesExpiry = expiryDate === "" || new Date(couponExpiry) >= new Date(expiryDate);
                    
                    if (matchesSearch && matchesCategory && matchesDiscount && matchesExpiry) {
                        coupon.style.display = "block";
                        visibleCount++;
                    } else {
                        coupon.style.display = "none";
                    }
                });
                document.getElementById('resultCount').textContent = visibleCount;
                
                const emptyState = document.getElementById('emptyState');
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
                
                
                sortCoupons(sortBy);
                
                loadingSpinner.classList.add('hidden');
            }, 600);
        }
        
        function sortCoupons(sortBy) {
            const container = document.getElementById('couponList');
            const coupons = Array.from(document.querySelectorAll('.coupon-card[style="display: block"]'));
            
            coupons.sort((a, b) => {
                switch(sortBy) {
                    case 'newest':
                        return new Date(b.dataset.created) - new Date(a.dataset.created);
                    case 'expiring':
                        return new Date(a.dataset.expiry) - new Date(b.dataset.expiry);
                    case 'discount':
                        return parseInt(b.dataset.discount) - parseInt(a.dataset.discount);
                    case 'popular':
                        return Math.random() - 0.5;
                    default:
                        return 0;
                }
            });
            
            coupons.forEach(coupon => container.appendChild(coupon));
        }
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(() => {
                
                const notification = document.getElementById('copiedNotification');
                notification.classList.remove('translate-y-10', 'opacity-0');
                notification.classList.add('translate-y-0', 'opacity-100');
                
    
                button.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
                button.classList.add('bg-green-500');
                
                setTimeout(() => {
                    button.innerHTML = 'Copy';
                    button.classList.remove('bg-green-500');
                }, 2000);
                
                setTimeout(() => {
                    notification.classList.remove('translate-y-0', 'opacity-100');
                    notification.classList.add('translate-y-10', 'opacity-0');
                }, 3000);
            });
        }
        
        document.getElementById('searchInput').addEventListener('input', filterCoupons);
        document.getElementById('categoryFilter').addEventListener('change', filterCoupons);
        document.getElementById('discountFilter').addEventListener('change', filterCoupons);
        document.getElementById('expiryFilter').addEventListener('change', filterCoupons);
        document.getElementById('sortBy').addEventListener('change', filterCoupons);
        document.getElementById('resetFilters').addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('discountFilter').value = '';
            document.getElementById('expiryFilter').value = '';
            filterCoupons();
        });
        
        
        document.addEventListener('DOMContentLoaded', () => {
            filterCoupons();
        });
        // Modal functionality
        
    

            document.getElementById('resetAllFilters').addEventListener('click', () => {
                document.getElementById('searchInput').value = '';
                document.getElementById('categoryFilter').value = '';
                document.getElementById('discountFilter').value = '';
                document.getElementById('expiryFilter').value = '';
                filterCoupons();
            });
    </script>

    
    
    </script>

</body>
</html>