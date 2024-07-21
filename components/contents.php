<?php
ob_start();
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding products to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($product_id > 0 && $quantity > 0) {
        // Check if the product is already in the cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // If the product is not in the cart, add it
        if (!$found) {
            $_SESSION['cart'][] = [
                'product_id' => $product_id,
                'quantity' => $quantity
            ];
        }

        // Redirect to prevent form resubmission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product_id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="md:hidden fixed top-0 left-0 p-4 z-50">
        <button onclick="toggleMobileMenu()" class="text-white bg-gray-800 p-2 rounded">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div id="sidebar" class="hidden md:block md:w-64 bg-white h-screen fixed top-0 left-0 shadow-lg">
        <?php include 'sidebar.php'; ?>
    </div>

    <div id="mobile-menu" class="md:hidden fixed top-0 left-0 w-full bg-white shadow-lg hidden">
        <?php include 'sidebar.php'; ?>
    </div>

    <div class="flex-1 md:ml-64 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <h1 class="text-2xl font-bold mb-4">Enter Product</h1>
                <div id="productList">
                    <?php include 'main1.php'; ?>
                </div>
            </div>
            <div class="md:col-span-1">
                <h2 class="text-xl font-bold mb-4">Selected Products:</h2>
                <div id="selectedProducts">
                    <?php include 'cart.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
