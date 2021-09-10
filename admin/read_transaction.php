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
$stmt = $pdo->prepare('SELECT * FROM transaction_history' );
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM transaction_history')->fetchColumn();

?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Products that need update status</h2>
    <table>
        <thead>
        <tr>
            <td>#</td>
            <td>Product ID</td>
            <td>Buyer ID</td>
            <td>Bid Price</td>
            <td>Recorded at</td>
            <td>Status</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?=$transaction['id']?></td>
                <td><?=$transaction['product_id']?></td>
                <td><?=$transaction['buyer_id']?></td>
                <td><?=$transaction['bid_price']?></td>
                <td><?=$transaction['recorded_at']?></td>
                <td><?=$transaction['status']?></td>
                <td class="actions">
                    <a href="undo_transaction.php?id=<?=$transaction['id']?>" class="edit">Undo Transaction<i></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="read_transaction.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
    <?php endif; ?>
    <?php if ($page*$records_per_page < $num_contacts): ?>
        <a href="read_transaction.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
    <?php endif; ?>
</div>
</div>

<?=template_footer()?>
