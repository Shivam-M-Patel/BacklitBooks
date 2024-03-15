<?php
session_start();
// if (!isset($_SESSION['uID'])) {
//   header("Location:Login.php");
//   exit();
// }
// var_dump($_SESSION['uID']);
$SignedOut = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="./styles/main.css" />
  <meta charset="UTF-8" />
  <script src="https://kit.fontawesome.com/53a095ce36.js" crossorigin="anonymous"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Home page</title>
</head>

<?php
include 'header.php';
?>

<body>
  <main>
    <div id="indexDisplay">
      <div id="homeCenter">
        <blockquote>
          Improve your browsing and shopping experience through Backlit Books.
        </blockquote>
        <blockquote>
          A proof of concept of a what an e-commerce website can be.
        </blockquote>
      </div>
    </div>
    
    </div>
  </main>
  <?php include 'footer.php'; ?>
</body>

</html>