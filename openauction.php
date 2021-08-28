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
    $order = isset($_POST['asc']) ? 'ASC' : 'DESC';
    if (isset($_POST['sort-closing-time'])){
        $sql = "SELECT * FROM auction_product ORDER BY closing_time " . $order;
    }
    elseif (isset($_POST['sort-max-bid'])){
        $sql = "SELECT * FROM auction_product ORDER BY current_maximum_bid_price " . $order;
    }
    elseif (isset($_POST['sort-max-bid'])){
        $sql = "SELECT * FROM auction_product ORDER BY current_maximum_bid_price " . $order;
    }

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