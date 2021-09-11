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
$stmt = $pdo->prepare('SELECT id, phone, first_name, last_name, balance FROM customer_account ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM customer_account')->fetchColumn();
?>

<?=template_header('Read')?>
<a href="admin_dashboard.php">Back to Admin dashboard</a>
<div class="content read">
    <h2>Customer lists</h2>
    <table>
        <thead>
        <tr>
            <td>#</td>
            <td>Phone</td>
            <td>First name</td>
            <td>Last name</td>
            <td>Balance</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?=$customer['id']?></td>
                <td><?=$customer['phone']?></td>
                <td><?=$customer['first_name']?></td>
                <td><?=$customer['last_name']?></td>
                <td><?=$customer['balance']?></td>
                <td class="actions">
                    <a href="update_customer.php?id=<?=$customer['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="read_customer.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_contacts): ?>
            <a href="read_customer.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>
