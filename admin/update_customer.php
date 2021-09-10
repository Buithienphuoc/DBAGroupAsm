<?php
include '../connection.php';

$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = $_POST['id'] ?? NULL;
        $phone = $_POST['phone'] ?? '';
        $first_name = $_POST['first_name'] ?? '';
        $last_name= $_POST['last_name'] ?? '';
        $balance = $_POST['balance'] ?? '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE customer_account SET id = ?, phone = ?, first_name = ?, last_name = ?, balance = ? WHERE id = ?');
        $stmt->execute([$id, $phone, $first_name, $last_name, $balance, $_GET['id']]);
        $msg = 'Updated Successfully!';

    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM customer_account WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$customer) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
    <h2>Update Contact #<?=$customer['id']?></h2>
    <form action="update_customer.php?id=<?=$customer['id']?>" method="post">
        <label for="id">ID</label>
        <label for="phone">Phone</label>
        <input type="text" name="id"  value="<?=$customer['id']?>" id="id">
        <input type="text" name="phone" value="<?=$customer['phone']?>" id="name">
        <label for="first_name">First Name</label>
        <label for="last_name">Last Name</label>
        <input type="text" name="first_name"  value="<?=$customer['first_name']?>" id="email">
        <input type="text" name="last_name"  value="<?=$customer['last_name']?>" id="phone">
        <label for="balance">Balance</label>
        <label></label>
        <input type="text" name="balance"  value="<?=$customer['balance']?>" id="title">
        <input type="submit" value="Update">
    </form>
    <a type="button" class="btn btn-danger" href="read_customer.php">Back to customer list</a>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
