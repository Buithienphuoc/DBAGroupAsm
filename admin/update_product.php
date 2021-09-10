<?php
include '../connection.php';

$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = $_POST['id'] ?? NULL;
        $product_name = $_POST['product_name'] ?? '';
        $minimum_price = $_POST['minimum_price'] ?? '';
        $closing_time= $_POST['closing_time'] ?? '';
        $product_status = $_POST['product_status'] ?? '';
        $current_maximum_bid_price = (int) $_POST['current_maximum_bid_price'] ?? '';
        $seller_id = $_POST['seller_id'] ?? '';
        $buyer_id = $_POST['buyer_id'] ?? '';

        // Update the record:
        $stmt = $pdo->prepare('UPDATE auction_product SET product_status = ? WHERE id = ?');
        $update_seller = $pdo->prepare('UPDATE customer_account SET balance = balance + ? WHERE id = ? ');
        $update_buyer = $pdo->prepare('UPDATE customer_account SET balance = balance - ? WHERE id = ?');
        $stmt->execute([$product_status, $_GET['id']]);
        $update_seller->execute([$current_maximum_bid_price, $seller_id]);
        $update_buyer->execute([$current_maximum_bid_price, $buyer_id]);
        // Insert transaction:
        $transaction = $pdo->prepare('INSERT INTO transaction_history (product_id, buyer_id, bid_price, recorded_at) VALUES (?, ?, ?, ?)');
        $transaction->execute([$id, $buyer_id, $current_maximum_bid_price, date("Y-m-d")]);

        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM auction_product WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Contact doesn\'t exist with that ID!');
    }

} else {
    exit('No ID specified!');
}

?>

<?=template_header('Read')?>

<div class="content update">
    <h2> Create transaction #<?=$product['id']?></h2>
    <form action="update_product.php?id=<?=$product['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="<?=$product['id']?>" id="id" readonly="readonly">
        <label for="minimum_price">Minimum price</label>
        <input type="number" name="minimum_price" value="<?=$product['minimum_price']?>" id="name" readonly="readonly">
        <label for="current_maximum_bid_price">Current maximum price</label>
        <input type="number" name="current_maximum_bid_price" value="<?=$product['current_maximum_bid_price']?>" id="name" readonly="readonly" >
        <label for="product_name">Product name</label>
        <input type="text" name="product_name" value="<?=$product['product_name']?>" id="id" readonly="readonly">
        <label for="closing_time">Closed time</label>
        <input type="text" name="closing_time" value="<?=$product['closing_time']?>" id="email" readonly="readonly">
        <label for="seller_id">Seller id</label>
        <input type="text" name="seller_id" value="<?=$product['seller_id']?>" id="seller_id" readonly="readonly">
        <label for="buyer_id">Buyer id</label>
        <input type="text" name="buyer_id" value="<?=$product['buyer_id']?>" id="buyer_id" readonly="readonly">
        <label for="product_status">Status</label><br>
        <select name="product_status" id="product_status">
            <option name="inactive" value="Inactive">Inactive</option>
        </select>
        <?php if ($product['product_status'] == "Active"): ?>
            <input type="submit" value="Update" onclick="location.href='read_product.php';">
        <?php endif; ?>
    </form>
    <a type="button" class="btn btn-danger" href="read_product.php">Back to product list</a>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

