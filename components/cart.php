<?php
include 'connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$user_email = $_SESSION['email'];

if (empty($_SESSION['cart'])) {
    echo "<p>No products selected yet.</p>";
} else {
    echo "<table class='min-w-full bg-white border border-gray-200'>";
    echo "<thead class='bg-gray-100'>";
    echo "<tr>";
    echo "<th class='py-2 px-4 border-b'>Product Name</th>";
    echo "<th class='py-2 px-4 border-b'>Quantity</th>";
    echo "<th class='py-2 px-4 border-b'>Price Each</th>";
    echo "<th class='py-2 px-4 border-b'>Total Price</th>";
    echo "<th class='py-2 px-4 border-b'>Action</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $item['product_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $productTotalPrice = $product['price'] * $item['quantity'];
        
        echo "<tr>";
        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($product['name']) . "</td>";
        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($item['quantity']) . "</td>";
        echo "<td class='py-2 px-4 border-b'>RS " . number_format($product['price'], 2) . "</td>";
        echo "<td class='py-2 px-4 border-b'>RS " . number_format($productTotalPrice, 2) . "</td>";
        echo "<td class='py-2 px-4 border-b'><a href='contents.php?remove=" . htmlspecialchars($item['product_id']) . "' class='text-red-500 hover:text-red-700'>Remove</a></td>";
        echo "</tr>";

        $total += $productTotalPrice;
    }
    
    echo "</tbody>";
    echo "</table>";
    
    echo "<p class='mt-4 font-bold'>Total: RS " . number_format($total, 2) . "</p>";
    
    echo "<form action='checkout.php' method='post'>";
    echo "<input type='hidden' name='cart_data' value='" . htmlspecialchars(json_encode($_SESSION['cart'])) . "'>";
    echo "<button type='submit' name='checkout' class='mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600'>Proceed to Checkout</button>";
    echo "</form>";
}
?>
