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

$checkQuery = "SELECT * FROM categories";
$categories = mysqli_query($conn, $checkQuery);

$category_id = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    header("Location: Categories.php?category_id=$category_id");
    exit();
}
?>

<nav class="flex bg-[#FFA500] justify-between items-center h-[80px] shadow-md p-[30px]">
    <h1 class="text-[30px] font-bold cursor-pointer">CarParts</h1>
    <ul class="flex gap-[20px] items-center mr-[70px]">
        <li class="text-[20px] cursor-pointer"><a href="Products.php">All Products</a></li>
        <li class="text-[20px] cursor-pointer"><a href="Categories.php">Categories</a></li>
        <li class="text-[20px] cursor-pointer"><a href="Orders.php">My Orders</a></li>
    </ul>

    <img src="../../Assets/free-shopping-cart-icon-3041-thumb.png" class="w-[40px] cursor-pointer"
        onclick="openModal()" />

    <?php
    require '../Components/CartItemModal/CartItemModal.php';
    ?>
</nav>