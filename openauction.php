<?php
require "connection.php";
session_start();

// redirect to login page if not signed in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
}

echo "<h1>Store page for ", $_SESSION["firstname"] . " " . $_SESSION["lastname"], "<h1>";
?>

<?php

print_r($_POST);

if (!(isset($_POST['sort-by']) || isset($_POST['desc']))) {
    $sql = "SELECT * FROM auction_product ";
} else {
    // user DESC as default
    $order = ($_POST['desc'] == "DESC") ? 'DESC' : 'ASC';

    if ($_POST['sort-by'] == "sort-closing-time") {
        $sql = "SELECT * FROM auction_product WHERE product_status='open' ORDER BY closing_time " . $order;
    } elseif ($_POST['sort-by'] == "sort-max-bid") {
        $sql = "SELECT * FROM auction_product WHERE product_status='open' ORDER BY current_maximum_bid_price " . $order;
    }
    // TODO: sort by number of bid count
    elseif ($_POST['sort-by'] == "sort-bid-count") {
        $sql = "SELECT t.product_id, p.current_maximum_bid_price, p.closing_time, COUNT(product_id) AS bid_count
                FROM transaction_history t JOIN auction_product p ON t.product_id = p.id
                GROUP BY product_id ORDER BY bid_count " . $order;
    }
}
$statement = $pdo->prepare($sql);

try {
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<html>

<body>
    <?php echo "OPEN AUCTION\n"; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="sort-by">SORT BY:</label>
        <select name="sort-by" id="sort-by">
            <option value="sort-closing-time">Closing time</option>
            <option value="sort-max-bid">Max bid</option>
            <option value="sort-bid-count">Bid count</option>
        </select>

        <label for="sort-order">ORDER:</label>
        <select name="desc" id="sort-order">
            <option value="DESC">DESC</option>
            <option value="ASC">ASC</option>
        </select>

        <button type="submit">Submit</button>
    </form>

    <?php if (count($result) > 0) : ?>
        <table>
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

</html>
<style>
    table th td {
        border: 1px solid black;
    }
</style>