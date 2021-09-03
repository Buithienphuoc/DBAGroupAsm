
<?php
require "../connection.php";

session_start();
?>

<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    header("location: admin_dashboard.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // redirect to register
    if (isset($_POST['register'])) {
        header("location: register.php");
    }
    $username = $password = $error = "";

    // non-empty username and password
    $query = "SELECT id, username, password FROM admin_list WHERE username=:username";
    $statement = $pdo->prepare($query);

    $statement->bindParam(":username", $_POST["username"], PDO::PARAM_STR);

    if ($statement->execute()) {
        // check if account with entered phone number exist
        if ($statement->rowCount() == 1) {
            $row = $statement->fetch();
            $id = $row["id"];
            $username = $row["username"];

            // verify password
            // TODO: replace with password_verify
            // if (password_verify($password, $customer_pass)){
            if ($_POST["adminPassword"] == $password) {
                session_start();

                echo "Logged in successfully";

                // store data in sesssion
                $_SESSION["adminLoggedIn"] = true;
                $_SESSION["adminId"] = $id;

                // redirect
                header("location: admin_dashboard.php");
            } else {
                $error = "invalid admin name";
            }
        } else {
            $error = "Invalid password";
        }
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
    <h2>Login to Admin Panel</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control
            <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" value="<?php echo $_POST["username"] ?? ''; ?>">
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
    </form>
</div>
</body>

</html>