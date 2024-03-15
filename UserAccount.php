<?php 
session_start();
include 'DBconnection.php';
$pdo = connectDB();

$sql = "SELECT * FROM users WHERE UserID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['uID']]);
$user_info = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['save'])) {
    $fn = $_POST['first_name'];
    $ln = $_POST['last_name'];
    $un = $_POST['username'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET UserName = ?, Email = ?, FName = ?, LName = ? WHERE UserID = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$un,$email,$fn,$ln,$_SESSION['uID']]);
    $_SESSION['location'] = "UserAccount";
    header("location:Summary.php");
}
if (isset($_POST['delete'])){
    $_SESSION['location'] = "Delete";
    header("location:Summary.php");
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
  <title>Account Details</title>

</head>

<body id="loginBody">
  <!-- <div class="flex"> -->
  <?php
  include 'header.php';
  ?>
  <main id="LoginMain">
    <form method="post">
      <div id="centerContent">
        <h2 id="loginTitle">Edit your account details</h2>
        <div>
          <!-- Input for user to put their username -->
          <label for="username">Username</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-user"></i></span>
            <input id="username" class="loginInput" value="<?=$user_info['UserName'] ?>" type="text" name="username" autofocus required />
          </div>
        </div>
        <div>
          <label for="email">Email</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-envelope"></i></span>
            <?php $email = isset($user_info['email']) ? $user_info['email'] : ''; ?>
            <input id="email" class="loginInput" value="<?= $email ?>" type="email" name="email" required />
          </div>
        </div>
        <div>
          <label for="first_name">First Name</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-user"></i></span>
            <input id="first-name" class="loginInput" value="<?=$user_info['FName']?>" type="text" name="first_name"  required />
          </div>
        </div>
        <div>
          <label for="last_name">Last Name</label>
          <div class="iconInput">
            <span><i class="fa-solid fa-user"></i></span>
            <input id="last-name" class="loginInput" value="<?=$user_info['LName'] ?>" type="text" name="last_name"  required />
          </div>
        </div>
        <div style="display:flex;">
            <button class="acc-btn" type="submit" name="save" value="submit">Save</button></td>
            <button class="acc-btn" type="submit" name="delete" value="submit">Delete Account</button></td>
        </div>
      </div>
    </form>
  </main>
</body>

</html>
