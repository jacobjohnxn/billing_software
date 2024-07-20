<?php
include 'connection.php'; // Ensure this is the correct path to your connection.php
$searchErr = '';
$product_details = [];
if (isset($_POST['save'])) {
    if (!empty($_POST['search'])) {
        $search = $_POST['search'];
        $searchTerm = "%" . $search . "%";
        $stmt = $conn->prepare("SELECT * FROM products WHERE id LIKE ? OR name LIKE ?");
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $product_details = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $searchErr = "Please enter the information";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Example</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 70%;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container p-6 ">
        <form method="post" name="search" class="mb-6 flex flex-col md:flex-row gap-3">
            <div class="flex w-full md:w-4/5">
                <input type="text" name="search" placeholder="Search for the product you like" class="w-full md:w-4/5 px-3 h-10 rounded-l border-2 border-sky-500 focus:outline-none focus:border-sky-500">
                <button type="submit" name="save" class="bg-sky-500 text-white rounded-r px-2 md:px-3 py-0 md:py-1">Search</button>
            </div>
            <select id="pricingType" name="pricingType" class="w-full md:w-1/5 h-10 border-2 border-sky-500 focus:outline-none focus:border-sky-500 text-sky-500 rounded px-2 md:px-3 py-0 md:py-1 tracking-wider">
                <option value="All" selected>All</option>
                <option value="Freemium">Freemium</option>
                <option value="Free">Free</option>
                <option value="Paid">Paid</option>
            </select>
        </form>
        <h3 class="text-xl font-semibold underline mb-4">Search Result</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b">#</th>
                        <th class="py-2 px-4 border-b">Product Name</th>
                        <th class="py-2 px-4 border-b">Avail Quantity</th>
                        <th class="py-2 px-4 border-b">Price</th>
                        <th class="py-2 px-4 border-b">quantity</th>
                        <th class="py-2 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php

if (!empty($product_details)) {
    foreach ($product_details as $key => $value) {
        echo "<tr>";
        echo "<td class='py-2 px-4 border-b'>" . ($key + 1) . "</td>";
        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($value['name']) . "</td>";
        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($value['quantity']) . "</td>";
        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($value['price']) . "</td>";
        echo "<td class='py-2 px-4 border-b'>
            <form method='post' action=''>
                <input type='hidden' name='product_id' value='" . htmlspecialchars($value['id']) . "'>
                <input type='hidden' name='name' value='" . htmlspecialchars($value['name']) . "'>
                <input type='hidden' name='price' value='" . htmlspecialchars($value['price']) . "'>
                <input type='number' name='quantity' min='1' max='" . htmlspecialchars($value['quantity']) . "' value='1' 
                       class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5' required>
                <button type='submit' name='add_to_cart' class='mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600'>Add</button>
            </form>
        </td>";
        echo "</tr>";
    }
} else {
    echo '<tr><td colspan="5" class="text-center py-4">No data found</td></tr>';
}
?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>