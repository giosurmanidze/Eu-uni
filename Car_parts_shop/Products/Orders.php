<?php
session_start();
include '../Layouts/AuthenticatedLayout.php';
$userId = $_SESSION['user_id'];
$checkQuery = "SELECT * FROM orders where orders.user_id = '$userId'";
$orders = mysqli_query($conn, $checkQuery);

?>
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                ID</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                Price</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created At</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
        <tr>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo $order['id']; ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo $order['total_price']; ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo $order['created_at']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>