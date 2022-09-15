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
    session_start();
      if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $_SESSION['current'] = "entry";
      }
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_SESSION['current'] == "entry") {
            $pass = $_POST["entry"];
            $passCheck = "youShallNotPass";
            if ($pass == $passCheck){
                $_SESSION["current"] = "create";
            } else {
                header("location: index.php");
            }
        } else if ($_SESSION['current'] == "create"){
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
                    if (mysqli_stmt_num_rows($stmt) == 0) {
                        $sql = "INSERT INTO `techs` (`username`, `password`) VALUES( ?, ? )";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_pass);
                            $param_username = $username;
                            $param_pass = $password;
                            if (mysqli_stmt_execute($stmt)) {
                                header('location: techLogIn.php');
                            }
                        }
                    } else {
                      $login_err = "User Already Exists";
                    }
                  } else {
                    echo "Oops! Something went wrong. Please try again later.";
                  }
                  mysqli_stmt_close($stmt);
                }
              }
              mysqli_close($conn);
        }
      }
    
    // take entry password first time round
    // if password is right, make page 

    //in page, ask for username and password and repeat password
    //if not already in db, insert into
    ?>
    <h2 class="w3-text-light-grey">Time Sheet Prototype</h2>
  <div class="w3-padding-large" id="main">

    <div class="w3-row w3-center w3-padding-16 w3-section w3-light-grey">
        <?php
        if ($_SESSION['current'] == "entry"){
    echo '<form method="post">
    <label for="entry"><b>Please enter given account creation password</b></label>
    <input type="text" placeholder="Password" name="entry">
    <button type="submit">Enter</button>
    </form>';
        } else if ($_SESSION['current'] == "create"){
            echo '<div class="alert alert-danger">' . $login_err . '</div><form method="post">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname"><br><br>
            <?php echo (!empty($username_err)) ? "is-invalid" : "";?>
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw"></br></br>
            <?php echo (!empty($password_err)) ? "is-invalid" : ""; ?>
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
            <button type="submit">Create Account</button>
          </form>';
        }
    ?>
    </div>
  </div>
</body>

</html>