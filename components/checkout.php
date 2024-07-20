<?php
session_start();
include 'connection.php'; // Make sure this points to your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $cart_data = json_decode($_POST['cart_data'], true);
    
    if (!empty($cart_data)) {
        try {
            // Start transaction
            $conn->begin_transaction();

            foreach ($cart_data as $item) {
                $product_id = $item['id'];
                $quantity_ordered = $item['quantity'];

                // Update product quantity in database
                $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ? AND quantity >= ?");
                $stmt->bind_param("iii", $quantity_ordered, $product_id, $quantity_ordered);
                $stmt->execute();

                if ($stmt->affected_rows == 0) {
                    // If no rows were updated, it means there's not enough quantity
                    throw new Exception("Not enough quantity for product ID: " . $product_id);
                }
            }

            // If we've made it this far without throwing an exception, commit the transaction
            $conn->commit();

            // Clear the cart
            $_SESSION['cart'] = [];

            echo "Checkout successful! Database updated.";
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $conn->rollback();
            echo "Error during checkout: " . $e->getMessage();
        }
    } else {
        echo "Cart is empty";
    }
} else {
    echo "Invalid request";
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
        <p class="mb-4"><?php echo isset($message) ? $message : ''; ?></p>
        <a href="contents.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Return to Product List
        </a>
    </div>
</body>
</html>