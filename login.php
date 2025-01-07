<!-- code with code but little change-->

<?php
include 'partials/dbconn.php';
$userError = false;
$passError = false;
$loginAlert = false;
//$showError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $loginAlert = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: welcome.php");
      } else {
        $passError = "password did not match";
      }
    }
  } else {
    $userError = "username did not match";
  }
}

/*
  $sql = "SELECT * FROM `users` WHERE `username`='$username'AND `password`='$password'";
  //both line are same 
  //$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);

  //mysqli_num_rows($result) returns the number of rows in the result set.
  //> 0 checks if there is at least one row returned by the query.
  //If the number of rows is greater than 0, it means that there is already a user with the specified username in the database.

  //if ($num >0) {
  if ($num == 1) {

    $loginAlert = true;
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("location: welcome.php");
  } else {
    $showError = "Invalid Credentials";
  }
}
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php require "partials/navbar.php"; ?>

  <?php
  //if ($showError) { echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> ERROR !</strong> ' . $showError . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';  }

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
  if ($loginAlert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong> SUCCESS !</strong> You are logged In .
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  }
  ?>
  <div class="container my-5 ">
    <h1 class="text-center"> LogIn to the site </h1>
    <div class="container my-5 d-flex justify-content-center align-items-center">

      <form action="/loginSystem/login.php" method="POST">

        <div class="mb-3 col-md-20">
          <label for="username" class="form-label ">username</label>
          <input type="text" class="form-control border-dark" id="username" name="username" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3 col-md-20">
          <label for="password" class="form-label ">Password</label>
          <input type="password" class="form-control border-dark" id="password" name="password" required>
        </div>

        <div class="container d-flex justify-content-lg-between">
          <button type="submit" class="btn btn-primary col-md-15">Log In</button>
          <button type="submit" class="btn btn-primary col-md-15"><a class="nav-link" href="/loginSystem/signup.php">Sign Up</a></button>
        </div>
      </form>
    </div>
  </div>


  <!-- prevent form resubmission when page is refreshed  -->
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>