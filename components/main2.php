<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];

    $_SESSION['cart'][] = [
        'id' => $product_id,
        'name' => $product_name,
        'quantity' => $quantity
    ];
}
?>

<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-xl font-bold mb-4">Selected Products</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>No products selected yet.</p>
    <?php else: ?>
        <ul class="list-disc pl-5">
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <li class="mb-2">
                    <?php echo htmlspecialchars($item['name']); ?>: 
                    <?php echo htmlspecialchars($item['quantity']); ?> item(s)
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="checkout.php" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Proceed to Checkout
        </a>
    <?php endif; ?>
</div>