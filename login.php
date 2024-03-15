<?php
session_start();
// if (isset($_SESSION['uID'])) {
//     header("Location:index.php");
//     exit();
// }
require 'DBconnection.php';
// create session
// initialize user ID and user name session objects

$SignedOut = true;

// establish connection
$pdo = connectDB();

// declare variable and grab by form element name
$errors = array();
$username = $_POST['username'] ?? null;
$password = $_POST['psw'] ?? null;

// If the form is submitting perform the operations in the brackets.
if (isset($_POST['login'])) {

  //validation```````````````

  //checks if username is empty.
  if (strlen($username) === 0) {
    $errors['username'] = true;
  }
  //checks if password is empty.
  if (strlen($password) === 0) {
    $errors['psw'] = true;
  }
  //````````````````````````
  if (count($errors) === 0) {
    // sql query to grab user id, name and password by inputed username
    $sql = "SELECT UserID, UserName, psw from users WHERE UserName = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    while ($row = $stmt->fetch()) {

      // if user entered username matches the username in the DB
      if ($username == $row['UserName']) {
        // if user entered password mathches the hashed password in the DB
        if (password_verify($password, $row['psw'])) {
          // Add username and userID to the session
          $_SESSION['uID'] = $row['UserID'];
          $_SESSION['username'] = $row['UserName'];
          // redirect the user to the store page
          header("Location:Store.php");
        } else {
          // else display invalid password error message
          $errors['psw'] = true;
        }
      } else if ($row['UserName'] == null) {
        // else display invalid username error message
        $errors['username'] = true;
      }else{
        $errors['username'] = true;
      }
    }
    // close the connection
    $pdo = null;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="./styles/main.css" />
  <meta charset="UTF-8" />
  <script src="https://kit.fontawesome.com/53a095ce36.js" crossorigin="anonymous"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Login</title>
</head>

<body id="loginBody">
  <!-- <div class="flex"> -->
    <?php
    include 'header.php';
    ?>
  <main id="LoginMain">
    <form method="post" action="login.php">
      <div id="centerContent">
        <h2 id="loginTitle">Login</h2>
        <div>
          <!-- Input for user to put their username -->
          <label for="username">Username</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-user"></i></span>
            <input id="username" name="username" type="text" class="loginInput" value="<?= $username ?>" placeholder="Enter your username" />
            <span class="errors <?= !isset($errors['username']) ? 'hidden' : "" ?>">Please enter a valid username</span>
          </div>
        </div>
        <div>
          <label for="password">Password</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-lock"></i></span>
            <input id="password" name="psw" type="password" class="loginInput" value="<?= $password ?>" placeholder="Enter your password" />
            <span class="errors <?= !isset($errors['psw']) ? 'hidden' : "" ?>">Please enter a valid password</span>

          </div>
        </div>
        <div class="flexed">
          <input id="agree" type="checkbox" name="remember" value="Y" />
          <label for="agree"> Remember Me </label>
          <a href="Register.php" id="forgotpwlink"> No account? Sign up</a>
        </div>
        <div>
          <button id="loginButton" name="login">Login</button>
        </div>
      </div>
    </form>
  </main>
</body>

</html>