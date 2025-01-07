<?php
include 'partials/dbconn.php';
$userError = false;
$passError = false;
$showAlert = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    //$existSql = "SELECT * FROM `users` WHERE username= '$username'";
    $existSql = "SELECT * FROM `users` WHERE `username`LIKE '$username'";

    $showResult = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($showResult);
    if ($numExistRows > 0) {

        $userError = "Username already exists. Try another username.";
    } else {

        if ($password === $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT); //set hash password

            $sql = "INSERT INTO `users` (`username`, `password`, `date`) VALUES ('$username', ' $hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            }
        } else {
            $passError = "Passwords do not match. Please enter the same password and confirm password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php require "partials/navbar.php"; ?>

    <?php
    if ($userError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> ERROR !</strong> ' . $userError . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($passError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> ERROR !</strong> ' . $passError . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong> SUCCESS !</strong> Your account is created & You can Log in Now .
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>
    <div class="container my-5">
        <h1 class="text-center"> Sign Up to the site </h1>
        <div class="container d-flex justify-content-center align-items-center">

            <form action="/loginSystem/signup1.php" method="POST">

                <div class="mb-3 col-md-15">
                    <label for="username" class="form-label ">username</label>
                    <input type="text" minlength="3" class="form-control border-dark" id="username" name="username" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3 col-md-15">
                    <label for="password" class="form-label ">Password</label>
                    <input type="password" minlength="1" class="form-control border-dark" id="password" name="password" required>
                </div>
                <div class="mb-3 col-md-15">
                    <label for="cpassword" class="form-label ">Confirn Password</label>
                    <input type="password" minlength="1" class="form-control border-dark" id="cpassword" name="cpassword" required>
                    <div class="form-text">Make sure password and confirm password is same .</div>
                </div>

                <div class="container d-flex justify-content-lg-between">
                    <button type="submit" class="btn btn-primary col-md-15">Sign Up</button>
                    <button type="submit" class="btn btn-primary col-md-15"><a class="nav-link" href="/loginSystem/login.php">Login</a></button>
                </div>
            </form>
        </div>
    </div>

    <!-- prevent form resubmission when page is refreshed   -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>