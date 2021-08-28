<?php
    session_start();

    // redirect to login page if not signed in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
        header("location: login.php");
    }

    echo "<h1>Store page for ", $_SESSION["firstname"] . " " . $_SESSION["lastname"], "<h1>";

    if(isset($_POST['get-product-id']))
    {
        $_SESSION['product-id'] = $_POST['product-id'];
        header("location: productdetails.php");
        
    }

?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="product-id">Enter a product id: </label>
    <input type="text" id="product-id" name="product-id">
    <input type="submit" id="get-product-id" name="get-product-id" value="Get product details">
</form>


<a href="addproduct.php">Create auction</a>
<a href="logout.php">Logout</a>
<a href="openauction.php">View open auctions</a>
<a href="myauction.php">My auction</a>
<a href="mybid.php">My bid</a>