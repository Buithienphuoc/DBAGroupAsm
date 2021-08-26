<?php 

require "vendor/autoload.php";

# Connect to mysql
$host = "localhost:3306";
$dbname = "auction";
$mysql_username = "root";
$mysql_password = "Slence2@3#0)0";

try{
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $mysql_username, $mysql_password);

// echo "Connected successfully";
}
catch (PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}


# Connect to mongodb
$mongo_client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongo_client->auction->auction_product;


?>