<?php
require "connection.php";
session_start();

// redirect to login page if not signed in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
}

?>

<?php

$sql = "SELECT id, product_id, bid_price, recorded_at FROM transaction_history WHERE status='Success' and buyer_id=:buyerid";

$statement = $pdo->prepare($sql);
$statement->bindParam("buyerid", $_SESSION["userid"], PDO::PARAM_STR);

try {
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
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

    <h1 style="text-align:center;">My won bid</h1>

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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                You have not won any bid.
            <?php endif; ?>
        </form>
    </div>
</body>

</html>