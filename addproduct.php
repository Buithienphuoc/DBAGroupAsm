<script>
    // dynamically add row to table. cant do this with php
    var attributes = 0;

    function addAttribute() {
        attributes++;

        var html = "<tr>";
        html += "<td>" + attributes + "</td>";
        html += "<td><input type='text' name='attributeName[]'></td>";
        html += "<td><input type='text' name='attributeValue[]'></td>";
        html += "<td><button type='button' onclick='deleteRow(this);'>Delete</button></td>"
        html += "</tr>";

        var row = document.getElementById("tbody").insertRow();
        row.innerHTML = html;
    }

    function deleteRow(button) {
        button.parentElement.parentElement.remove();
        // first parentElement will be td and second will be tr.
    }
</script>

<?php
require "connection.php";
session_start();

// redirect to login page if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
}

echo "<h1>Add product</h1>";


// get mandatory product info

if (!empty($_POST)){
    $product_name = $_POST['product-name'];
    $minimum_price = $_POST['minimum-price'];
    $closing_time = $_POST["closing-time"];
    $product_status = "open";
    $current_maximum_bid_price = $minimum_price;
    $seller_id = $_SESSION['userid'];

    // add item's auction attribute to mysql
    $sql = "INSERT INTO auction_product (product_name, minimum_price, closing_time, product_status, current_maximum_bid_price, seller_id) 
        VALUES (:product_name, :minimum_price, :closing_time, :product_status, :current_maximum_bid_price, :seller_id)";
    $statement = $pdo->prepare($sql);

    $statement->bindParam(":product_name", $product_name, PDO::PARAM_STR);
    $statement->bindParam(":minimum_price", $minimum_price, PDO::PARAM_STR);
    $statement->bindParam(":closing_time", $closing_time, PDO::PARAM_STR);
    $statement->bindParam(":product_status", $product_status, PDO::PARAM_STR);
    $statement->bindParam(":current_maximum_bid_price", $current_maximum_bid_price, PDO::PARAM_STR);
    $statement->bindParam(":seller_id", $seller_id, PDO::PARAM_STR);

    try {
        $statement->execute();
        $newproductid = $pdo->lastInsertId();
        echo "last inserted id " . $newproductid . "<br>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }


    // add item attribute to mongodb
    $product = array();
    $data = array();
    $data["id "] = $newproductid;
    foreach (array_combine($_POST["attributeName"], $_POST["attributeValue"]) as $key => $value) {
        $data[$key] = $value;
    }

    $collection->insertOne($data);
}
?>


<form method="POST" action="addproduct.php">
    <label for="product-name">Enter product name</label>
    <input type="text" name="product-name" required><br>

    <label for="minimum-price">Minimum price</label>
    <input type="text" name="minimum-price" required><br>

    <label for="product-name">Closing time</label>
    <input type="text" name="closing-time" required><br>

    <label for="product-attribute">Enter additional product attributes (optional)</label>
    <table name="product-attribute">
        <tr>
            <th>#</th>
            <th>Attribute</th>
            <th>Value</th>
        </tr>
        <tbody id="tbody"></tbody>
    </table>

    <button type="button" onclick="addAttribute();">Add Attribute</button>
    <br>
    <button type="submit">Add Product</button>
</form>