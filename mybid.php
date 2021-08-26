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
$

?>