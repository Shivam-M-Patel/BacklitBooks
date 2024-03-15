<?php
session_start();

// if (isset($_SESSION['uID'])) {
//     header("Location:index.php");
//     exit();
// }
$errors = array();
$username = $_POST['username'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$passwordCheck = $_POST['passwordCheck'] ?? null;
$firstName = $_POST['firstName'] ?? null;
$lastName = $_POST['lastName'] ?? null;

$SignedOut = true;

require 'DBconnection.php';
// establish connection
$pdo = connectDB();
// If the form is submitting perform the operations in the brackets.
if (isset($_POST['register'])) {

  // validation `````````````````````````````````
  //checks if username is empty.
  if (strlen($username) === 0) {
    $errors['username'] = true;
  }
  //checks if password is empty.
  if (strlen($password) === 0) {
    $errors['password'] = true;
  }
  //check if email is valid
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = true;
  }

  if ($password != $passwordCheck) {
    $errors['passwordCheck'] = true;
  }

  //`````````````````````````

  if (count($errors) === 0) {

    // declare variable and grab by form element name

    // hash the password and store it
    $hashedPSW = password_hash($password, PASSWORD_DEFAULT);

    // sql query to insert into the users table
    $sql = "INSERT INTO users (Username, psw, email, FName, LName) VALUES (? , ?, ? , ? , ?);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $hashedPSW, $email, $firstName, $lastName]);
    // redirect to login page
    header("Location:Login.php");

    // close connection
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
  <title>Login page</title>
</head>

<body id="loginBody">
  <!-- <div class="flex"> -->
  <?php
  include 'header.php';
  ?>
  <main id="LoginMain">
    <form method="post">
      <div id="centerContent">
        <h2 id="loginTitle">Sign up</h2>
        <div>
          <!-- Input for user to put their username -->
          <label for="username">Username</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-user"></i></span>
            <input id="username" name="username" type="text" class="loginInput" value="<?= $username ?>" placeholder="Enter a valid username" />
            <span class="errors <?= !isset($errors['username']) ? 'hidden' : "" ?>">Please enter a valid username</span>
          </div>
        </div>
        <div>
          <label for="password">Password</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-lock"></i></span>
            <input id="password" name="password" type="password" class="loginInput" value="<?= $password ?>" placeholder="Enter a valid password" />
            <span class="errors <?= !isset($errors['password']) ? 'hidden' : "" ?>">Please enter a valid password</span>

          </div>
        </div>
        <div>
          <label for="passwordCheck">Re-enter Password</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-lock"></i></span>
            <input id="password" name="passwordCheck" type="password" class="loginInput" value="<?= $passwordCheck ?>" placeholder="Re-enter your password" />
            <span class="errors <?= !isset($errors['passwordCheck']) ? 'hidden' : "" ?>">Your passwords do not match</span>
          </div>
        </div>
        <div>
          <!-- Label for email -->
          <label for="email">Email</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-envelope"></i></span>
            <input id="email" name='email' class="loginInput" type="email" value="<?= $email ?>" placeholder="johndoe@gmail.com" />
            <!-- Checks if you have a valid email -->
            <span class="errors <?= !isset($errors['email']) ? 'hidden' : "" ?>">Please enter a valid email</span>
          </div>
        </div>
        <div>
          <button id="loginButton" name="register" type="submit">Sign Up</button>
        </div>
        <div>
          <a id="forgotpwlink" href="Login.php">Already have an account? Login.</a>
        </div>
      </div>
    </form>
  </main>
  <!-- </div> -->
</body>

</html>


