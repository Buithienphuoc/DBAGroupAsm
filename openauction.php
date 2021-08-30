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
    $sql = "SELECT * FROM auction_product ";
    // user DESC as default
    $order = isset($_POST['desc']) ? 'DESC' : 'ASC';
    if (isset($_POST['sort-closing-time'])){
        $sql = "SELECT * FROM auction_product WHERE product_status='open' ORDER BY closing_time " . $order;
    }
    elseif (isset($_POST['sort-max-bid'])){
        $sql = "SELECT * FROM auction_product WHERE product_status='open' ORDER BY current_maximum_bid_price " . $order;
    }
    // TODO: sort by number of bid count
    // elseif (isset($_POST['sort-bid-count'])){
    //     $sql = "SELECT * FROM auction_product WHERE product_status='open' ORDER BY current_maximum_bid_price " . $order;
    // }

    $statement = $pdo->prepare($sql);
    
    try{
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

?>

<body>
    <?php echo "OPEN AUCTION"; ?>

    <label for="sort-by">SORT BY:</label>
    <select name="sort-by" id="sort-by">
    <option value="sort-closing-time">Closing time</option>
    <option value="sort-max-bid">Max bid</option>
    <!-- <option value="sort-bid-count">ASC</option> -->
    </select>

    <label for="sort-order">ORDER:</label>
    <select name="desc" id="sort-order">
    <option value="DESC">DESC</option>
    <option value="ASC">ASC</option>
    </select> 

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