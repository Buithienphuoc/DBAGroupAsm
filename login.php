<?php
require "connection.php";

session_start();
?>

<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    header("location: store.php");
}

$phone = $password = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // redirect to register
    if (isset($_POST['register'])){
        header("location: register.php");
    }

    // non-empty username and password
    $query = "SELECT id, first_name, last_name, phone, account_password FROM customer_account WHERE phone=:phone OR email=:phone;";
    $statement = $pdo->prepare($query);

    if ($statement) {
        $statement->bindParam(":phone", $phone_param, PDO::PARAM_STR);
        $phone_param = trim($_POST["phone"]);

        if ($statement->execute()) {
            // check if account with entered phone number exists
            if ($statement->rowCount() == 1) {
                $row = $statement->fetch();
                // print_r($row);
                $id = $row["id"];
                $customer_phone = $row["phone"];
                $customer_pass = $row["account_password"];
                $firstname = $row["first_name"];
                $lastname = $row["last_name"];

                // verify password
                // TODO: replace with password_verify
                // if (password_verify($password, $customer_pass)){
                if ($password == $customer_pass)
                    session_start();

                echo "Logged in successfully";

                // store data in sesssion
                $_SESSION["loggedin"] = true;
                $_SESSION["userid"] = $id;
                $_SESSION["firstname"] = $firstname;
                $_SESSION["lastname"] = $lastname;

                // redirect
                header("location: store.php");
            } else {
                $error = "invalid phone number/email";
            }
        } else {
            $error = "Invalid phone number/password2";
        }
    } else {
        echo "Error with execute() statement.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Login</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Phone/Email</label>
                <input type="text" name="phone" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>">
                <span class="invalid-feedback"><?php echo $error; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="login" value="Login">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="register" value="Register">
            </div>
        </form>
    </div>
</body>

</html>