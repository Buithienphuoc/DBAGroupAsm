<?php
include '../connection.php';
// Your PHP code here.

// Home Page template below.
?>
    <div style="float:right;">
        <ul>
            <li><a class="btn btn-danger" href="logout_admin.php" style="color: pink">Log out</a></li>
        </ul>
    </div>
<?=template_header('Home')?>
    <a class="btn btn-info" href="read_customer.php">Update Customer's balance</a>
    </br>
    <a class="btn btn-info" href="view_all_transactions.php">View all transactions and Calculate total bid price</a>
    </br>
    <a class="btn btn-danger" href="read_product.php">Make product INACTIVE to create transactions</a>
    </br>
    <a class="btn btn-danger" href="read_transaction.php">View and Undo transaction</a>
<?=template_footer()?>