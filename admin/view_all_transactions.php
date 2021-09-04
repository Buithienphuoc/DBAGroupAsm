    <?php
    require "../connection.php";

    session_start();
    ?>

    <?php

    // Get the page via GET request (URL param: page), if non exists default the page to 1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $records_per_page = 5;

    // Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT id, product_id, buyer_id, bid_price, recorded_at FROM transaction_history ORDER BY id LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
    $num_transactions = $pdo->query('SELECT COUNT(*) FROM transaction_history')->fetchColumn();


    $day_start='';
    $day_end='';
    $sum='';
    if(isset($_POST['Submit'])) {
        $day_start = $_POST['day_start'];
        $day_end = $_POST['day_end'];

        $sqlquery = "SELECT SUM(bid_price) AS sum FROM transaction_history
                WHERE recorded_at > STR_TO_DATE('$day_start', '%Y-%m-%d %H:%i:%s')
                AND recorded_at < STR_TO_DATE('$day_end', '%Y-%m-%d %H:%i:%s')";
        $result = $pdo->prepare($sqlquery);
        $executerecord = $result->execute();
        if ($executerecord) {
            if ($result->rowCount() > 0) {
                foreach ($result as $row) {
                    $sum = $row['sum'];
                }
            } else {
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

        <div class="content read">
            <h2>All Transactions</h2>
            <table>
                <thead>
                <tr>
                    <td>id</td>
                    <td>Product ID</td>
                    <td>Buyer ID</td>
                    <td>Bid</td>
                    <td>Recorded at</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?=$transaction['id']?></td>
                        <td><?=$transaction['product_id']?></td>
                        <td><?=$transaction['buyer_id']?></td>
                        <td><?=$transaction['bid_price']?></td>
                        <td><?=$transaction['recorded_at']?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="read_customer.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
                <?php endif; ?>
                <?php if ($page*$records_per_page < $num_transactions): ?>
                    <a href="read_customer.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
                <?php endif; ?>
            </div>
        </div>

    <?=template_footer()?>