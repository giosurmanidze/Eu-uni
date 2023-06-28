<?php
include '../Layouts/AdminPanelLayout.php';
require '../connection.php';

// Fetch user data from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle user deletion
if (isset($_POST['delete'])) {
    $userID = $_POST['userID'];

    // Delete related orders first
    $deleteOrdersQuery = "DELETE FROM orders WHERE user_id = '$userID'";
    mysqli_query($conn, $deleteOrdersQuery);

    // Delete related cart items
    $deleteCartItemsQuery = "DELETE FROM cart_items WHERE user_id = '$userID'";
    mysqli_query($conn, $deleteCartItemsQuery);

    // Delete the user from the database using the user ID
    $deleteQuery = "DELETE FROM users WHERE id = '$userID'";
    mysqli_query($conn, $deleteQuery);
}
?>

<!-- User List Table -->
<div class="flex justify-center">
    <table class="border border-gray-300 w-[700px]">
        <thead>
            <tr>
                <th class="py-3 px-4 font-semibold border-b">Id</th>
                <th class="py-3 px-4 font-semibold border-b">Name</th>
                <th class="py-3 px-4 font-semibold border-b">Email</th>
                <th class="py-3 px-4 font-semibold border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td class="py-2 px-4 border-b font-bold text-center"><?= $user['id'] ?></td>
                <td class="py-2 px-4 border-b text-center"><?= $user['name'] ?></td>
                <td class="py-2 px-4 border-b text-center"><?= $user['email'] ?></td>
                <td class="py-2 px-4 border-b text-center">
                    <form action="./Users.php?id=<?=$user['id']?>" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                        <input type="hidden" name="userID" value="<?= $user['id'] ?>">
                        <button type="submit" class="text-red-600 hover:text-red-800" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>