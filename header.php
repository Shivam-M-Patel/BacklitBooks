<?php
  if(isset($_SESSION['uID'])){
    $SignedOut = false;
    $uname = $_SESSION['username'];  
    $num_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
  }

?>
<head>
<script src="https://kit.fontawesome.com/53a095ce36.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<header>
  <div id="header">
    <div id="title">
      <!-- Will eventually be link to home page/index -->
      <h1><a href="index.php">Backlit Books</a></h1>
    </div>
    <span> <i class="fa-solid fa-books"></i></span>
    

    <?php if ($SignedOut) : ?>
      <div id="loginAndReg" class="nav">
        <label><a href="Login.php"> Login </a></label>
        <label id="noBorder"><a href="Register.php">Register</a></label>
      </div>
    <?php else: ?>
      <div class="nav">
      <?php if (isset($searchbar)) : ?>
      <form id="searchForm" action="Search.php" method="GET">
        <div id="searchBar">
          <input type="text" placeholder=" Search" name="search_term">
          <button id="searchButton" type="submit" name="search" value="submit"> <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>
      </form>
    <?php endif; ?>
         
          <div class="dropdwn">
            <button class="drop-btn" type="submit" name="Store" value="submit">Store</button>
            <div class="drop-links">
            <a href="Store.php">Best Sellers</a>
            <a href="Store.php#highest-rated">Highest Rated</a>
            <a href="Store.php#great-deals">Great Deals</a>
            <a href="Store.php#classics">Classics</a>
            <a href="AllBooks.php">View All Books</a>
            </div>
          </div>
          <div class="dropdwn">
            <button class="drop-btn"><i class="fa-solid fa-user"></i> <?= $uname?></button>
            <div class="drop-links">
            <a href="MyLibrary.php">My Library</a>
            <a href="UserAccount.php">My Account</a>
            <a href="Logout.php">Sign Out</a>
            </div>
          </div>
        <label class="drop-btn" id="noBorder"><a href="Store.php?page=cart" id="cart-link"><i class="fa fa-shopping-cart"></i><span class="cart-icon"><?= $num_in_cart?></span></a></label>
      </div>
    <?php endif; ?>
  </div>
</header>