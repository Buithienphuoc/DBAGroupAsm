<?php

session_start();

require "vendor/autoload.php";
require "connection.php";

echo 'product id: ' . $_SESSION['product-id'] . '<br>';
$item = $collection->findOne(array("id" => $_SESSION['product-id']));

$item = iterator_to_array($item);
// trim mongo built-in _id field
$item = array_slice($item, 1);

$field_names = array_keys($item);
?>


<h3> Product details </h3>
<div class="product-details">
    <table style="border: 1px solid black; border-collapse: collapse">
        <?php
            foreach(array_combine($field_names, $item) as $name=>$attribute){
                echo "<tr>";
                echo "<td style='border: 1px solid black; border-collapse: collapse; padding: 10px;'>" . $name . "</td>" ;
                echo "<td style='border: 1px solid black; border-collapse: collapse; padding: 10px;'>" . $attribute . "</td>" ;
                echo "</tr>";
            }
        ?>
    </table>
</div>  
