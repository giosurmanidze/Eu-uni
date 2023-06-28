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

// Retrieve the category ID from the URL
$category_id = $_GET['category_id'] ?? '';

// Retrieve the category name from the database based on the category ID
$categoryName = '';
if (!empty($category_id)) {
    $categoryQuery = "SELECT name FROM categories WHERE id = '$category_id'";
    $result = mysqli_query($conn, $categoryQuery);
    if ($result) {
        $category = mysqli_fetch_assoc($result);
        if ($category) {
            $categoryName = $category['name'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $categoryName; ?> - Category Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto py-10">
        <div class="flex items-center mb-5">
            <a href="products.php" class="mr-3 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold mb-5 mx-auto"><?php echo $categoryName; ?> Category Page</h1>
        </div>

        <div class="flex items-center mb-5 justify-center">
            <span class="mr-3 ">Filter by Category:</span>
            <select id="categoryFilter" class="border border-gray-300 rounded-md p-2">
                <option value="">All</option>
                <?php
                // Fetch all categories
                $categoriesQuery = "SELECT id, name FROM categories";
                $categoriesResult = mysqli_query($conn, $categoriesQuery);

                while ($category = mysqli_fetch_assoc($categoriesResult)) {
                    $categoryId = $category['id'];
                    $categoryName = $category['name'];

                    // Display category options
                    $selected = ($categoryId == $category_id) ? 'selected' : '';
                    echo "<option value='{$categoryId}' $selected>{$categoryName}</option>";
                }
                ?>
            </select>
        </div>

        <div class="flex justify-center w-full flex-wrap items-center gap-3">
            <?php
            // Construct the SQL query based on the selected category filter
            $productsQuery = "SELECT * FROM products";
            if (!empty($category_id)) {
                $productsQuery .= " WHERE category_id = '$category_id'";
            }

            // Query products
            $productsResult = mysqli_query($conn, $productsQuery);

            while ($product = mysqli_fetch_assoc($productsResult)) {
                $productId = $product['id'];
                $productName = $product['name'] ?? '';
                $productImage = $product['image'] ?? '';
                $productPrice = $product['price'] ?? '';

                // Display product card
                echo '
                <div class="bg-white p-5 shadow-md rounded-md" style="width: 400px;">
                    <img  src="../uploads/' . $productImage . '" alt="' . $productName . '" class="w-full mb-3">
                    <h3 class="text-lg font-bold mb-2">' . $productName . '</h3>
                    <p class="text-gray-600">$' . $productPrice . '</p>
                    <a href="ProductDetails.php?id=' . $productId . '" class="block mt-4 bg-blue-500 text-white text-center py-2 rounded-md hover:bg-blue-600">View Details</a>
                </div>
                ';
            }
            ?>
        </div>
    </div>

    <script>
        // Add event listener to the category filter select element
        var categoryFilter = document.getElementById('categoryFilter');
        categoryFilter.addEventListener('change', function() {
            var selectedCategoryId = categoryFilter.value;
            var url = 'Categories.php';
            if (selectedCategoryId) {
                url += '?category_id=' + selectedCategoryId;
            }
            window.location.href = url;
        });
    </script>
</body>

</html>