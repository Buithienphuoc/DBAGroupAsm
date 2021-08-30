<?php
    require "connection.php";
    session_start();

    // redirect to login page if not signed in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
        header("location: login.php");
    }

    echo $_SESSION["firstname"] . " " . $_SESSION["lastname"], " winning bids";
?>

<?php

$userid = $_SESSION['userid'];
$sql = "SELECT * FROM transaction_history t JOIN auction_product p ON t.product_id = p.id 
        WHERE buyer_id=:buyer_id AND t.bid_price >= p.current_maximum_bid_price 
        ORDER BY t.recorded_at DESC;";

$statement = $pdo->prepare($sql);

$statement->bindParam(":buyer_id", $userid, PDO::PARAM_STR);

try{
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo $e->getMessage();
}
?>

<body>
    <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . "'s bid history"; ?>

    <!-- user has no bid -->
    <?php if (count($result) == 0) : ?>
        <p>You haven't won any bid yet.</p>
    <?php endif; ?>

    <?php if (count($result) > 0) : ?>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th><?php echo implode('</th><th>', array_keys(current($result))); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : array_map('htmlentities', $row); ?>
                    <tr>
                        <td><?php echo implode('</td><td>', $row); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
