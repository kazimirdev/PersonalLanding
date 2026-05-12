<?php

include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';

?>

<main>
    <h2>Orders Management</h2>
    <div class="posts-containers">
        <div class="post-item">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #ccc;">
                        <th style="padding: 10px; text-align: left;">ID</th>
                        <th style="padding: 10px; text-align: left;">Product</th>
                        <th style="padding: 10px; text-align: left;">Email</th>
                        <th style="padding: 10px; text-align: left;">Status</th>
                        <th style="padding: 10px; text-align: left;">Price</th>
                        <th style="padding: 10px; text-align: left;">Date</th>
                        <th style="padding: 10px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($orders) && !empty($orders)) {
                        foreach ($orders as $order) {
                            echo '<tr style="border-bottom: 1px solid #eee;">';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($order['id']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($order['product_name'] ?? 'Unknown') . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($order['email']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($order['order_status']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($order['total_price']) . ' ' . htmlspecialchars($order['currency']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($order['created_at']) . '</td>';
                            echo '<td style="padding: 10px;">';
                            echo '<a href="/orders/' . $order['id'] . '/edit" style="margin-right: 10px;"><span style="cursor: pointer; color: blue;">Edit</span></a>';
                            echo '<a href="/orders/' . $order['id'] . '/delete"><span style="cursor: pointer; color: red;">Delete</span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7" style="padding: 20px; text-align: center;">No orders found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/../layouts/script.php';
include __DIR__ . '/../layouts/footer.php';
?>
