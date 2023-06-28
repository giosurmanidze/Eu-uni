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

$userID =  $_SESSION['user_id'];
$cartItemsQuery = "SELECT * FROM cart_items inner join products
            ON cart_items.product_id = products.id
            WHERE cart_items.user_id = $userID";

$totalPrice = 0;
$cartItemsResult = mysqli_query($conn, $cartItemsQuery);

if(isset($_POST['checkout'])) {
    $totalPrice = 0;
    if (mysqli_num_rows($cartItemsResult) > 0) {
        while ($cartItem = mysqli_fetch_assoc($cartItemsResult)) {
            $totalPrice += $cartItem['total_price'];
        }
    }
    $insertOrderQuery = "INSERT INTO orders (user_id, total_price, created_at)
                         VALUES ($userID, $totalPrice, NOW())";
    mysqli_query($conn, $insertOrderQuery);

    $deleteCartItemsQuery = "DELETE FROM cart_items WHERE user_id = $userID";
    mysqli_query($conn, $deleteCartItemsQuery);
}

?>
<style>
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    /* Semi-transparent background */
}

.modal-content {
    border-radius: 4px;
    background-color: #fefefe;
    margin-top: 5%;
    margin-left: 60%;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Cart</h2>
        <?php


        if (mysqli_num_rows($cartItemsResult) > 0) {
            // Loop through cart items and display product info
            while ($cartItem = mysqli_fetch_assoc($cartItemsResult)) {
                $productName = $cartItem['title'];
                $productImage = $cartItem['image'];
                $quantity = $cartItem['quantity'];
                $price = $cartItem['price'];
                $totalPrice += $cartItem['total_price'];
                ?>

        <div class="cart-item  flex flex-col ">
            <div class="flex mb-[40px] items-center gap-[15px] justify-between">
                <div class="flex gap-3.5">
                    <img src="<?="../uploads/". $productImage ?>" alt="<?= $productName ?>" class="w-[70px]">
                    <div class="product-info flex flex-col justify-between gap-[20px]">
                        <p class="product-name font-bold"><?= $productName ?></p>
                        <p class="product-quantity font-bold"><?= $price . "$" ?></p>
                    </div>
                </div>
                <p class="product-quantity font-bold text-gray-500"><?= $quantity."X"?></p>
            </div>
            <?php
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>
            <form method="post" class="flex justify-between items-center">
                <h1>total price: <?=$totalPrice?></h1>
                <button type="submit" name="checkout" class="bg-blue-600 text-white p-2.5">
                    Checkout
                </button>
            </form>

        </div>

    </div>

    <script>
    var modal = document.getElementById("myModal");

    function openModal() {
        modal.style.display = "block";
        document.body.style.backgroundColor = "rgba(0, 0, 0, 0.5)"; // Darken background
    }

    function closeModal() {
        modal.style.display = "none";
        document.body.style.backgroundColor = ""; // Reset background
    }
    </script>