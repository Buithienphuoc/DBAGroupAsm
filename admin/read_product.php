<?php
require "../connection.php";

session_start();
?>

<?php

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM auction_product WHERE CURRENT_TIMESTAMP >= closing_time AND buyer_id IS NOT NULL ORDER BY product_status = \'Active\' DESC ');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM auction_product')->fetchColumn();

?>

<?=template_header('Read')?>
<a href="admin_dashboard.php">Back to Admin dashboard</a>

<div class="content read">
    <h2>Products that need update status</h2>
    <table>
        <thead>
        <tr>
            <td>#</td>
            <td>Product Name</td>
            <td>Start price</td>
            <td>Closed time</td>
            <td>Product Status</td>
            <td>End Price</td>
            <td>Seller ID</td>
            <td>Buyer ID</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?=$product['id']?></td>
                <td><?=$product['product_name']?></td>
                <td><?=$product['minimum_price']?></td>
                <td><?=$product['closing_time']?></td>
                <td><?=$product['product_status']?></td>
                <td><?=$product['current_maximum_bid_price']?></td>
                <td><?=$product['seller_id']?></td>
                <td><?=$product['buyer_id']?></td>
                <td class="actions">
                    <a href="update_product.php?id=<?=$product['id']?>" class="edit">Update status<i></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="read_product.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_contacts): ?>
            <a href="read_product.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>
