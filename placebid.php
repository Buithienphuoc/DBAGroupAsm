<?php
require "connection.php";
session_start();

// redirect to login page if not signed in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
}

$get_query = "SELECT * FROM auction_product WHERE id=:productid";
$get_statement = $pdo->prepare($get_query);
$get_statement->bindParam("productid", $_SESSION['product-id'], PDO::PARAM_STR);

try {
    $get_statement->execute();
    $result = $get_statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($result);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>


<body>
    <h2>Place your bid</h2>
    <br><br>
    <form action="placebid.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>
                        <?php echo implode('</th><th>', array_keys(current($result))); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : array_map('htmlentities', $row); ?>
                    <tr>
                        <td>
                            <?php
                                foreach($row as $value){
                                    echo "<td><input type='text' name='" . $value . "' placeholder='" . $value  . "'></td>";
                                }
                            ?>
                        </td>
                        <td><button type="submit" name="bid" value="<?php echo $row["id"] ?>">Bid</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <br>
        </table>
    </form>
</body>