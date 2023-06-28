<?php
include '../Layouts/AdminPanelLayout.php';
require '../connection.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $sql = "UPDATE products SET title='$title', image='$image', price='$price', category_id='$category_id' WHERE id='$id'";
    mysqli_query($conn, $sql);
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Delete associated cart items
    $deleteCartItemsQuery = "DELETE FROM cart_items WHERE product_id='$id'";
    mysqli_query($conn, $deleteCartItemsQuery);

    // Delete the product
    $deleteProductQuery = "DELETE FROM products WHERE id='$id'";
    mysqli_query($conn, $deleteProductQuery);
}

$sql = "SELECT products.id, products.title, products.image, products.price, categories.name 
        FROM products 
        INNER JOIN categories ON products.category_id = categories.id";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<table class="min-w-full table-auto">
    <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Title</th>
            <th class="px-4 py-2">Image</th>
            <th class="px-4 py-2">Price</th>
            <th class="px-4 py-2">Category</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td class="border px-4 py-2"><?= $product['id'] ?></td>
            <td class="border px-4 py-2"><?= $product['title'] ?></td>
            <td class="border px-4 py-2 w-[150px]"><img class="w-full" src="../uploads/<?= $product['image'] ?>" /></td>
            <td class="border px-4 py-2"><?= $product['price'] ?></td>
            <td class="border px-4 py-2"><?= $product['name'] ?></td>
            <td class="border px-4 py-2">
                <form method="POST" action="./EditProduct.php?id=<?= $product['id'] ?>" class="mb-3.5">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded" type="submit"
                        name="update">
                        Update
                    </button>
                </form>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" type="submit"
                        name="delete">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>