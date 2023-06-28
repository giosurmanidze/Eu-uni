<?php
$servername = "localhost";
$username = "root";
$connectionPassword = "";
$dbname = "car_parts_shop";

// Create connection
$conn = mysqli_connect($servername, $username, $connectionPassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the product ID from the URL
$productId = $_GET['id'] ?? '';

// Retrieve the product details from the database based on the product ID
$productName = '';
$productDescription = '';
if (!empty($productId)) {
    $productQuery = "SELECT * FROM products WHERE id = '$productId'";
    $result = mysqli_query($conn, $productQuery);
    if ($result) {
        $product = mysqli_fetch_assoc($result);
        if ($product) {
            $productName = $product['name'] ?? '';
            $productDescription = $product['description'] ?? '';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productName; ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto py-10 w-full">
        <div class="flex items-center mb-5">
            <a href="Categories.php" class="mr-3 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold mb-5"><?php echo $productName; ?> - Product Details</h1>
        </div>

        <div class="flex flex-col w-full items-center">
            <div class="w-500px">
                <img src="../uploads/<?php echo $product['image'] ?? ''; ?>" alt="<?php echo $productName; ?>" class="w-full mb-3">
            </div>
            <div class="w-1/2 pl-10">
                <h2 class="text-lg font-bold mb-3">Description</h2>
                <p><?php echo $productDescription; ?></p>
                <h2 class="text-lg font-bold mt-5">Price</h2>
                <p class="text-gray-600">$<?php echo $product['price'] ?? ''; ?></p>
            </div>
        </div>
    </div>
</body>

</html>