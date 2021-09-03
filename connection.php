<?php

require "vendor/autoload.php";

# Connect to mysql
$host = "localhost:3306";
$dbname = "assignment_1";
$mysql_username = "root";
$mysql_password = "hacker123";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $mysql_username, $mysql_password);

// echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


# Connect to mongodb
$mongo_client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongo_client->auction->auction_product;
function template_header($title)
{
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="../css/style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Welcome to Admin Dashboard</h1>
            </div>
        </nav>
    EOT;
}

function template_footer()
{
    echo <<<EOT
    </body>
</html>
EOT;
}

?>


