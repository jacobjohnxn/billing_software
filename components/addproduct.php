<?php
include "./connection.php";
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ./auth.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_name = $_POST["name"];
    $product_quantity = $_POST["quantity"];
    $product_price = $_POST["price"];
    

        $sql = "INSERT INTO products (name, quantity,price) 
                VALUES ('$product_name', '$product_quantity', '$product_price')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: inventory.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
   
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black h-[650px] " >

<div class="container">
    <h1 class="text-3xl font-semibold">Add Product</h1>
    <a href="admin.php" class="btn btn-primary">Back</a>
    
    <div class="flex justify-center pt-8">
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group ">
            <strong>Product Name:</strong>
            <input type="text" name="name" required class="form-control bg-white text-black border border-black" placeholder="Name">
        </div>
        <div class="form-group">
            <strong>quantity:</strong>
            <input type="text" name="quantity" required class="form-control bg-white border border-black">
        </div>
        <div class="form-group">
            <strong>Price:</strong>
            <input type="text" name="price" required class="form-control bg-white border border-black">
        </div>
        <!-- <div class="form-group">
            <strong>Active Status:</strong>
            <input type="text" name="active" required class="form-control bg-white border border-black">
        </div> -->
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
    </div>
    
</div>

</body>
</html>