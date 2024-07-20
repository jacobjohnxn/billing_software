<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding products to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Check if product already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price
        ];
    }
}

// Handle removing products from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($remove_id) {
        return $item['id'] != $remove_id;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media (max-width: 768px) {
            #mobile-menu {
                display: block;
            }
        }
    </style>
    <script>
        function toggleMobileMenu() {
            var menu = document.getElementById('mobile-menu');
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }
    </script>
</head>
<body class="flex bg-gray-100">
    <!-- Mobile menu button -->
    <div class="md:hidden fixed top-0 left-0 p-4">
        <button onclick="toggleMobileMenu()" class="text-white bg-gray-800 p-2 rounded">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="flex-1 md:ml-64 p-4">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-2/3 pr-4">
                <h1 class="text-2xl font-bold mb-4">Enter Product</h1>
                <div id="productList">
                    <?php include 'main1.php'; ?>
                </div>
            </div>
            <div class="md:w-1/3 pl-4">
                <h2 class="text-xl font-bold mb-4">Selected Products:</h2>
                <div id="selectedProducts">
                    <?php include 'cart.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
