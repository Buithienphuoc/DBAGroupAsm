<?php
include '../connection.php';

$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = $_POST['id'] ?? NULL;
        $product_id = $_POST['product_id'] ?? '';
        $buyer_id = $_POST['buyer_id'] ?? '';
        $bid_price= $_POST['bid_price'] ?? '';
        $recorded_at = $_POST['recorded_at'] ?? '';


        // Update the record:
        $update_seller = $pdo->prepare('UPDATE customer_account SET balance = balance - ? WHERE id = (SELECT seller_id FROM auction_product WHERE id = ?) ');
        $update_buyer = $pdo->prepare('UPDATE customer_account SET balance = balance + ? WHERE id = ?');
        $stmt = $pdo->prepare('UPDATE transaction_history SET status = ? WHERE id = ?');


        $update_seller->execute([$bid_price, $product_id]);
        $update_buyer->execute([$bid_price, $buyer_id]);
        $stmt->execute(["Revoke", $id]);


        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM transaction_history WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$transaction) {
        exit('Contact doesn\'t exist with that ID!');
    }

} else {
    exit('No ID specified!');
}

?>

<?=template_header('Read')?>

<a type="button" class="btn btn-danger" href="read_transaction.php">Back to transaction list</a>

<div class="content update">
    <h2> Undoing transaction #<?=$transaction['id']?></h2>
    <form action="undo_transaction.php?id=<?=$transaction['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="<?=$transaction['id']?>" id="id" readonly="readonly">

        <label for="product_id">Product ID</label>
        <input type="number" name="product_id" value="<?=$transaction['product_id']?>" id="name" readonly="readonly">

        <label for="buyer_id">Buyer ID</label>
        <input type="number" name="buyer_id" value="<?=$transaction['buyer_id']?>" id="name" readonly="readonly">

        <label for="bid_price">Bid Price</label>
        <input type="number" name="bid_price" value="<?=$transaction['bid_price']?>" id="name" readonly="readonly">

        <label for="recorded_at">Recorded at</label>
        <input type="text" name="recorded_at" value="<?=$transaction['recorded_at']?>" id="name" readonly="readonly">

        <label for="transaction_status">Status</label><br>
        <input type="text" name="recorded_at" value="<?=$transaction['status']?>" id="name" readonly="readonly">

        <?php if ($transaction['status'] == "Success"): ?>
            <input type="submit" value="Undo transaction">
        <?php endif; ?>

    </form>
    <a type="button" class="btn btn-danger" href="read_transaction.php">Back to transaction list</a>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

