<?php

require "connection.php";

$phone = $email = $password = $repeat_password = "";
$firstname = $lastname = $address = $city = $country = $profile_pic = "";

// does not make sense to add these on register form
$budget = $balance = 0.0;

$errors = array();

$sql_errors = array();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    header("location: store.php");
}

if (isset($_POST["login"])){
    header("location: login.php");
}

if (isset($_POST["register"])) {

    // TODO: apply sanitize filter https://www.php.net/manual/en/filter.filters.sanitize.php
    $phone = addslashes($_POST['phone']);
    $email = addslashes($_POST['email']);
    $firstname = addslashes($_POST["firstname"]);
    $lastname = addslashes($_POST["lastname"]);
    $address = addslashes($_POST["address"]);
    $city = addslashes($_POST["city"]);
    $country = addslashes($_POST["country"]);
    $branch_id = addslashes(($_POST['branch-id']));
    $profile_pic = addslashes($_POST["profile-pic"]);
    $password = addslashes($_POST['password']);
    $repeat_password = addslashes($_POST['repeat-password']);

    if (empty($phone)) {
        array_push($errors, "Phone number is ");
    }
    if (empty($email)) {
        array_push($errors, "Email is ");
    }
    if (empty($password)) {
        array_push($errors, "Password is ");
    }

    if ($password != $repeat_password) {
        array_push($errors, "The two passwords do not match");
    }

    // check for account with existing info
    $select_sql = "SELECT phone, email FROM customer_account WHERE phone=:phone OR email=:email";
    $select_statement = $pdo->prepare($select_sql);

    $select_statement->bindParam(":phone", $phone_param, PDO::PARAM_STR);
    $select_statement->bindParam(":email", $email_param, PDO::PARAM_STR);

    $phone_param = trim($phone);
    $email_param = trim($email);

    if ($select_statement->execute()) {
        if ($select_statement->rowCount() >= 1) {
            array_push($errors, "An account is already registered using this phone number or email");
        } else {
            // no error left in form
            if (count($errors) == 0) {
                // $password = md5($password);

                $insert_sql = "INSERT INTO customer_account
                    (phone, first_name, last_name, email, account_password, address, city, country, budget, balance, profile_picture, branch_id)
                    VALUES (:phone, :first_name, :last_name, :email, :account_password, :address, :city, :country, :budget, :balance, :profile_picture, :branch_id);";

                $insert_statement = $pdo->prepare($insert_sql);

                $insert_statement->bindParam(':phone', $phone, PDO::PARAM_STR);
                $insert_statement->bindParam(':email', $email, PDO::PARAM_STR);
                $insert_statement->bindParam(':first_name', $firstname, PDO::PARAM_STR);
                $insert_statement->bindParam(':last_name', $lastname, PDO::PARAM_STR);
                $insert_statement->bindParam(':account_password', $password, PDO::PARAM_STR);
                $insert_statement->bindParam(':address', $address, PDO::PARAM_STR);
                $insert_statement->bindParam(':city', $city, PDO::PARAM_STR);
                $insert_statement->bindParam(':country', $country, PDO::PARAM_STR);
                $insert_statement->bindParam(':budget', $budget, PDO::PARAM_STR);
                $insert_statement->bindParam(':balance', $balance, PDO::PARAM_STR);
                $insert_statement->bindParam(':profile_picture', $profile_pic, PDO::PARAM_STR);
                $insert_statement->bindParam(':branch_id', $branch_id, PDO::PARAM_STR);

                try {
                    $insert_statement->execute();
                    echo "<pre>";
                    echo print_r($insert_statement->debugDumpParams());
                    echo "</pre>";
                    header("location: login.php");
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    }
}
?>


<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php
    if (!empty($sql_errors)) {
        print_r($sql_errors);
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Branch</label>
            <input type="text" name="branch-id" value="<?php echo isset($_POST["branch-id"]) ? $_POST["branch-id"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>First name</label>
            <input type="text" name="firstname" value="<?php echo isset($_POST["firstname"]) ? $_POST["firstname"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Last name</label>
            <input type="text" name="lastname" value="<?php echo isset($_POST["lastname"]) ? $_POST["lastname"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" value="<?php echo isset($_POST["address"]) ? $_POST["address"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Country</label>
            <input type="text" name="country" value="<?php echo isset($_POST["country"]) ? $_POST["country"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Link to profile pic</label>
            <input type="url" name="profile-pic" value="<?php echo isset($_POST["profile-pic"]) ? $_POST["profile-pic"] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Repeat password</label>
            <input type="password" name="repeat-password">
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="register" value="Register">
        </div>

        <div class="form-group">
            <label for="login">Already have an account?</label>
            <input type="submit" class="btn btn-primary" name="login" value="Login">
        </div>

    </form>
</body>