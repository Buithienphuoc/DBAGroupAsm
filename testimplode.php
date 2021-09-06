<?php
$arr = array("Honda", "Volvo", "Toyota");
$car = array("car1", "car2", "car3");
?>

<div class="table">
    <form action="draft.php" method="post">
        <table>
            <thead>
                <?php
                foreach ($arr as $value) {
                    echo "<th>" . $value . "</th>";
                }
                ?>
            </thead>
            <tbody>
                <tr>
                    <?php
                    foreach ($car as $value) {
                        echo "<td><input type='text' name='" . $value . "' placeholder='" . $value  . "'></td>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        <button type="submit">Submit</button>
    </form>
</div>

<?php
print_r($_POST);
?>