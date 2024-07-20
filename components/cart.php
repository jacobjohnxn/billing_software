<?php
if (empty($_SESSION['cart'])) {
    echo "<p>No products selected yet.</p>";
} else {
    echo "<ul class='space-y-2'>";
    foreach ($_SESSION['cart'] as $item) {
        echo "<li class='flex justify-between items-center'>";
        echo "<span>" . htmlspecialchars($item['name']) . ": " . htmlspecialchars($item['quantity']) . " item(s)</span>";
        echo "<a href='?remove=" . htmlspecialchars($item['id']) . "' class='text-red-500 hover:text-red-700'>Remove</a>";
        echo "</li>";
    }
    echo "</ul>";
    
    // Calculate and display total
    $total = array_reduce($_SESSION['cart'], function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);
    
    echo "<p class='mt-4 font-bold'>Total: $" . number_format($total, 2) . "</p>";
    
    // Add a checkout button
    echo "<form action='checkout.php' method='post'>";
echo "<input type='hidden' name='cart_data' value='" . htmlspecialchars(json_encode($_SESSION['cart'])) . "'>";
echo "<button type='submit' name='checkout' class='mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600'>Proceed to Checkout</button>";
echo "</form>";
}
?>