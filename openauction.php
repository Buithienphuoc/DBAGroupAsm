<?php
require "connection.php";
session_start();

// redirect to login page if not signed in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
}

?>

<?php

$sortby = isset($_POST['sort-by']) ? $_POST['sort-by'] : NULL;
$orderby = isset($_POST['order-by']) ? $_POST['order-by'] : NULL;

if (!($sortby || $orderby)) {
    $sql = "SELECT * FROM auction_product ";
} else {
    // user DESC as default
    $order = ($orderby == "desc") ? 'DESC' : 'ASC';

    if ($sortby == "sort-closing-time") {
        $sql = "SELECT * FROM auction_product WHERE product_status='open' AND seller_id!=:seller_id ORDER BY closing_time " . $order;
    } elseif ($sortby == "sort-max-bid") {
        $sql = "SELECT * FROM auction_product WHERE product_status='open' AND seller_id!=:seller_id  ORDER BY current_maximum_bid_price " . $order;
    } elseif ($sortby == "sort-bid-count") {
        $sql = "SELECT t.product_id, p.current_maximum_bid_price, p.closing_time, COUNT(product_id) AS bid_count
                FROM transaction_history t JOIN auction_product p ON t.product_id = p.id
                WHERE product_status='open' AND seller_id!=:seller_id 
                GROUP BY product_id ORDER BY bid_count " . $order;
    }
}

if (isset($_POST['bid'])) {
    $_SESSION['product-id'] = $_POST['bid'];
    header("location: placebid.php");
}

$statement = $pdo->prepare($sql);
$statement->bindParam("seller_id", $_SESSION['userid'], PDO::PARAM_STR);
try {
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <ul>
        <li><a href="store.php">Back</a></li>
    </ul>

    <h1 style="text-align:center;">Open auctions</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="sort-by">SORT BY:</label>
        <select name="sort-by" id="sort-by">
            <option value="sort-closing-time" <?php if ($sortby == "sort-closing-time") { ?> selected <?php } ?>>Closing time</option>
            <option value="sort-max-bid" <?php if ($sortby == "sort-max-bid") { ?> selected <?php } ?>>Max bid</option>
            <option value="sort-bid-count" <?php if ($sortby == "sort-bid-count") { ?> selected <?php } ?>>Bid count</option>
        </select>

        <label for="sort-order">ORDER:</label>
        <select name="sort-order" id="sort-order">
            <option value="desc" <?php if ($orderby == "desc") { ?> selected <?php } ?>>DESC</option>
            <option value="asc" <?php if ($orderby == "asc") { ?> selected <?php } ?>>ASC</option>
        </select>

        <button type="submit">Sort</button>
    </form>

    <div class="content read">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php if (count($result) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>
                                <?php
                                echo implode('</th><th>', array_keys(current($result)));
                                ?>
                            </th>
                            <th>Place bid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row) : array_map('htmlentities', $row); ?>
                            <tr>
                                <td>
                                    <?php
                                    echo implode('</td><td>', $row);
                                    ?>
                                </td>
                                <td><button type="submit" name="bid" value="<?php echo $row["id"] ?>">Bid</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>