<?php
include '../connection.php';
// Your PHP code here.

// Home Page template below.
?>

<?=template_header('Home')?>
    <a href="read_customer.php">Update Customer's balance</a>
    </br>
    <a href="view_all_transactions.php">View all transactions</a>
<?=template_footer()?>