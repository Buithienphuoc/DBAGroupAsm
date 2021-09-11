<?php
include '../connection.php';
// Your PHP code here.

// Home Page template below.
?>

<?=template_header('Home')?>
    <a href="read_customer.php">Update Customer's balance</a>
    </br>
    <a href="view_all_transactions.php">View all transactions and Calculate total bid price</a>
    </br>
    <a href="read_product.php">Update product status and creating transactions</a>
    </br>
    <a href="read_transaction.php">View and Undo transaction</a>
<?=template_footer()?>