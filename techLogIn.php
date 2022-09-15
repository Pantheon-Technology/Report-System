<!DOCTYPE html>
<html>

<head>
  <title>Time Sheet Prototype</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body class="w3-black">
  <?php
  include_once 'config.php';
  $username = $password = "";
  $username_err = $password_err = $login_err = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["uname"]))) {
      $username_err = "Please enter a username.";
    } else {
      $username = trim($_POST["uname"]);
    }

    if (empty(trim($_POST["psw"]))) {
      $password_err = "Please enter your password.";
    } else {
      $password = trim($_POST["psw"]);
    }

    if (empty($username_err) && empty($password_err)) {
      $sql = "SELECT `username`, `password` FROM `techs` WHERE `username` = ?";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);
          if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $username, $temp_password);
            if (mysqli_stmt_fetch($stmt)) {
              if ($temp_password == $password) {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                header("location: upAndDown.php");
              } else {
                $login_err = "Invalid username or password.";
              }
            }
          } else {
            $login_err = "Invalid username or password.";
          }
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
      }
    }
    mysqli_close($conn);
  } ?>
  <h2 class="w3-text-light-grey">Time Sheet Prototype</h2>
  <div class="w3-padding-large" id="main">

    <div class="w3-row w3-center w3-padding-16 w3-section w3-light-grey">
      <?php
      if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
      }
      ?>
      <form method="post">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" value="<?php echo $username; ?>"><br><br>
        <?php echo (!empty($username_err)) ? 'is-invalid' : '';?>
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw"></br></br>
        <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>

</html>