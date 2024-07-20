<?php
session_start();
include 'connection.php';

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];
    $update_query = "UPDATE products SET quantity = $new_quantity WHERE id = $product_id";
    mysqli_query($conn, $update_query);
    header("Location: inventory.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'sidebar.php'; ?>
    <div class="flex-1 md:ml-64 p-4">
    <a href="addproduct.php" class="bg-green-500  px-4 py-1 rounded hover:bg-green-800 hover:text-white">Add Product</a>  
    <a href="user.php" class="bg-green-500  px-4 py-1 rounded  hover:bg-green-800 hover:text-white ">Add user</a> 
        <h1 class="text-2xl font-bold mb-4">Inventory Management</h1>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Product ID</th>
                    <th class="px-4 py-2 border-b">Product Name</th>
                    <th class="px-4 py-2 border-b">Quantity</th>
                    <th class="px-4 py-2 border-b">Price</th>
                    <th class="px-4 py-2 border-b">Update Quantity</th>
                    <th class="px-4 py-2 border-b">edit product</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="px-4 py-2 border-b"><?php echo $row['id']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $row['name']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $row['quantity']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $row['price']; ?></td>
                    <td class="px-4 py-2 border-b">
                        <form method="POST" action="inventory.php" class="flex">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" class="border border-gray-300 p-1 mr-2">
                            <button type="submit" name="update_quantity" class="bg-blue-500 text-white px-4 py-1 rounded">Update</button>
                        </form>
                    </td>
                    <td> <?php echo "<a href='edit.php?id=".$row['id']."' class='bg-green-500 text-white px-4 py-1 rounded'>Edit</a>";  
                    ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
