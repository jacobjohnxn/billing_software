<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $cart_data = $_SESSION['cart'];
    
    if (!empty($cart_data)) {
        try {
            $conn->begin_transaction();

            foreach ($cart_data as $item) {
                $product_id = $item['product_id'];
                $quantity_ordered = $item['quantity'];

                $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();

                if (!$product) {
                    throw new Exception("Product not found: " . $product_id);
                }

                if ($product['quantity'] < $quantity_ordered) {
                    throw new Exception("Not enough quantity for product ID: " . $product_id);
                }

                $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
                $stmt->bind_param("ii", $quantity_ordered, $product_id);
                $stmt->execute();
            }

            $conn->commit();

            // Clear the cart
            $_SESSION['cart'] = [];

            $message = "Checkout successful! Product quantities updated.";
        } catch (Exception $e) {
            $conn->rollback();
            $message = "Error during checkout: " . $e->getMessage();
        }
    } else {
        $message = "Cart is empty";
    }
} else {
    $message = "Invalid request";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-6">
        <h1 class="text-2xl font-bold mb-4">Checkout Result</h1>
        <p class="mb-4"><?php echo $message; ?></p>
        <a href="contents.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Return to Product List
        </a>
    </div>
</body>
</html>