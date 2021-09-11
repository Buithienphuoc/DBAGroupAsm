<?php
require "connection.php";
session_start();

// redirect to login page if not signed in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
}

$get_query = "SELECT id, product_name, current_maximum_bid_price, closing_time FROM auction_product WHERE id=:productid";
$get_statement = $pdo->prepare($get_query);
$get_statement->bindParam("productid", $_SESSION['product-id'], PDO::PARAM_STR);

try {
    $get_statement->execute();
    $result = $get_statement->fetchAll(PDO::FETCH_ASSOC);
    $current_price = $result[0]['current_maximum_bid_price'];

    $columns = array_keys($result);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST["bid"])) {
    $user_bid_price = filter_var($_POST['user-bid'], FILTER_SANITIZE_NUMBER_FLOAT);

    if ($user_bid_price <= $current_price) {
        echo "your bid must be greater than current max bid price\n";
    } else {
        // INSERT NEW TRANSACTION HISTORY AND UPDATE CURRENT MAX BID PRICE
        // $insert_query = "INSERT INTO transaction_history (product_id, buyer_id, bid_price, recorded_at) VALUES (:product_id, :buyer_id, :bid_price, :recorded_at)";
        $update_query = "UPDATE auction_product SET current_maximum_bid_price=:user_bid, buyer_id=:buyerid WHERE id=:product_id";

        $date =  date("Y-m-d");

        // $insert_statement = $pdo->prepare($insert_query);
        $update_statement = $pdo->prepare($update_query);
        // $insert_statement->bindParam("product_id", $_SESSION['product-id'], PDO::PARAM_STR);
        // $insert_statement->bindParam("buyer_id", $_SESSION['userid'], PDO::PARAM_STR);
        // $insert_statement->bindParam("bid_price", $user_bid_price, PDO::PARAM_STR);
        // $insert_statement->bindParam("recorded_at", $date, PDO::PARAM_STR);

        $update_statement->bindParam("user_bid", $user_bid_price, PDO::PARAM_STR);
        $update_statement->bindParam("product_id", $_SESSION['product-id'], PDO::PARAM_STR);
        $update_statement->bindParam("buyerid", $_SESSION['userid'], PDO::PARAM_STR);

        // $insert_statement->execute();
        $update_statement->execute();
        header("location: openauction.php");
        // }
        // catch (PDOException $e){
        //     echo $e->getMessage();
        // }

    }
}

?>

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

    <h1 style="text-align:center;">Place your bid</h1>
    <br><br>

    <div class="content read">
        <form action="placebid.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>
                            <?php echo implode('</th><th>', array_keys(current($result))); ?>
                        </th>
                        <th>
                            Your bid
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : array_map('htmlentities', $row); ?>
                        <tr>
                            <td>
                                <!-- <?php
                                        foreach ($row as $value) {
                                            echo "<td><input type='text' name='" . $value . "' placeholder='" . $value  . "'></td>";
                                        }
                                        ?> -->
                                <?php echo implode('</th><th>', $row); ?>
                            </td>
                            <td>
                                <input type="text" placeholder="your bid" name='user-bid'>
                            </td>
                            <td><button type="submit" name="bid" value="<?php echo $row["id"] ?>">Bid</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <br>
            </table>
        </form>
    </div>
</body>