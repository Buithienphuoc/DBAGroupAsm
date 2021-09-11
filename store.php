<?php
require "connection.php";
session_start();

// redirect to login page if not signed in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
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
    <div style="float:right;">
        <ul>
            <li>Welcome <?php echo $_SESSION["firstname"] . ' ' . $_SESSION["lastname"]?> <a href="logout.php">Log out</a></li>
        </ul>
    </div>

    <h1 style="text-align:center;">Store</h1>
    <ul>
        <li><a href="addproduct.php">Create auction</a></li>
        <li><a href="openauction.php">View open auctions</a></li>
        <li><a href="winningbid.php">My won bid</a></li>
        <li><a href="mybid.php">Bid history</a></li>
    </ul>

</body>

</html>