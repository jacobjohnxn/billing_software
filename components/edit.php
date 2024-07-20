<?php
include "./connection.php";
session_start();

$product_id = $_GET['id'];
$productupdate = [];

$sql = "SELECT * FROM products WHERE id=$product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $productupdate = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_name = $_POST["name"];
    $product_quantity = $_POST["quantity"];
    $product_price = $_POST["price"];

    $sql = "UPDATE products SET name='$product_name', quantity='$product_quantity', price='$product_price' WHERE id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Product updated successfully";
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="bg-white text-black pb-44">
    <h1 class="text-3xl">Edit Product</h1>
    <a href="inventory.php" class="btn btn-primary">Back</a>

    <div class="flex items-center justify-center p-16">
        <form method="POST" action="">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

            <div class="form-group mb-4">
                <strong>Product Name:</strong>
                <input type="text" name="name" required class="form-control bg-white border border-black p-2" value="<?php echo $productupdate['name']; ?>">
            </div>
            <div class="form-group mb-4">
                <strong>Product Quantity:</strong>
                <input type="number" name="quantity" required class="form-control bg-white border border-black p-2" value="<?php echo $productupdate['quantity']; ?>">
            </div>
            <div class="form-group mb-4">
                <strong>Product Price:</strong>
                <input type="number" step="0.01" name="price" required class="form-control bg-white border border-black p-2" value="<?php echo $productupdate['price']; ?>">
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
