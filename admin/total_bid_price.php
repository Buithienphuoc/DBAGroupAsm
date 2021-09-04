<?php
require "../connection.php";
session_start();

// redirect to login page if not signed in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
}

$day_start='';
$day_end='';
$sum='';
if(isset($_POST['Submit'])){
    $day_start = $_POST['day_start'];
    $day_end = $_POST['day_end'];

    $sqlquery= "SELECT SUM(bid_price) AS sum FROM transaction_history
                WHERE recorded_at > STR_TO_DATE('$day_start', '%Y-%m-%d %H:%i:%s')
                AND recorded_at < STR_TO_DATE('$day_end', '%Y-%m-%d %H:%i:%s')";
    $result=$pdo->prepare($sqlquery);
    $executerecord=$result->execute();
    if($executerecord){
        if($result->rowCount()>0){
            foreach ($result as $row){
                $sum = $row['sum'];
            }
        }else{
            echo "Result not found!";
        }
    }

}
?>

<?=template_header('Read')?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label>Day start:</label>
    <input type="date" name="day_start"/>

    <label>Day end:</label>
   <input type="date" name="day_end"/>

    <button type="submit" name="Submit">Submit</button>
</form>

<table>
    <td>Sum: <b><?php echo $sum ?></b></td>
</table>

<?=template_footer()?>