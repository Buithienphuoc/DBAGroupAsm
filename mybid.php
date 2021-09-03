<?php
    require "connection.php";
    session_start();

    // redirect to login page if not signed in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
        header("location: login.php");
    }

    echo $_SESSION["firstname"] . " " . $_SESSION["lastname"], " bid page";
?>

<?php

$userid = $_SESSION['userid'];
$sql = "SELECT * FROM transaction_history WHERE buyer_id=:buyer_id;";
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
        <p>User has no bid in system yet.</p>
    <?php endif; ?>

    <?php if (count($result) > 0) : ?>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th><?php echo implode('</th><th>', array_keys(current($result))); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $row) : array_map('htmlentities', $row); ?>
                    <tr>
                        <td><?php echo implode('</td><td>', $row); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
