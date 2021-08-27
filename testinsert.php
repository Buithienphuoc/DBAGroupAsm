<?php

$host = "localhost:3306";
$dbname = "auction";
$mysql_username = "root";
$mysql_password = "Slence2@3#0)0";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $mysql_username, $mysql_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// $data = [
//     'phone '=> '0123123123',
//     'email' => 'new@mail',
//     'first_name' => 'first',
//     'last_name' => 'last',
//     'account_password' => '123123',
//     'street_address' => 'new street',
//     'city' => 'new city',
//     'country' => 'new country',
//     'budget' => '0.0',
//     'balance' => '0.0',
//     'profile_picture' => 'https://i.imgur.com/vdSSixz.jpeg',
//     'branch_id' => '1'
// ];

// $phone = '0123123123';
// $email = 'new@mail';
// $first_name = 'first';
// $last_name = 'last';
// $account_password = '123123';
// $address = 'new street';
// $city = 'new city';
// $country = 'new country';
// $budget = '0.0';
// $balance = '0.0';
// $profile_picture = 'https://i.imgur.com/vdSSixz.jpeg';
// $branch_id = '1';


// try{
// $insert_sql = "INSERT INTO customer_account
// (phone, first_name, last_name, email, account_password, address, city, country, budget, balance, profile_picture, branch_id)
//  VALUES (:phone, :first_name, :last_name, :email, :account_password, :address, :city, :country, :budget, :balance, :profile_picture, :branch_id);";

// $insert_statement = $pdo->prepare($insert_sql);

// $insert_statement->bindParam(':phone', $phone, PDO::PARAM_STR);
// $insert_statement->bindParam(':email', $email, PDO::PARAM_STR);
// $insert_statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
// $insert_statement->bindParam(':last_name', $last_name, PDO::PARAM_STR);
// $insert_statement->bindParam(':account_password', $account_password, PDO::PARAM_STR);
// $insert_statement->bindParam(':address', $address, PDO::PARAM_STR);
// $insert_statement->bindParam(':city', $city, PDO::PARAM_STR);
// $insert_statement->bindParam(':country', $country, PDO::PARAM_STR);
// $insert_statement->bindParam(':budget', $budget, PDO::PARAM_STR);
// $insert_statement->bindParam(':balance', $balance, PDO::PARAM_STR);
// $insert_statement->bindParam(':profile_picture', $profile_picture, PDO::PARAM_STR);
// $insert_statement->bindParam(':branch_id', $branch_id, PDO::PARAM_STR);

// $insert_statement->execute();
// }
// catch (PDOException $e){
//     echo $e->getMessage();


$query_sql = "SELECT product_name, minimum_price, current_maximum_bid_price, product_status, closing_time FROM auction_product";
$statement = $pdo->query($query_sql);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . "'s bid history"; ?>
    <?php if (count($result) > 0) : ?>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th><?php echo implode('</th><th>', array_keys(current($result))); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : array_map('htmlentities', $row); ?>
                    <tr>
                        <td><?php echo implode('</td><td>', $row); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>