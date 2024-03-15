<?php
    include 'DBconnection.php';
    $pdo = connectDB();
    if (isset($_GET['ISBN'])) {
        $stmt = $pdo->prepare('SELECT * FROM books WHERE ISBN = ?');
        $stmt->execute([$_GET['ISBN']]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT ISBN FROM userlibrary WHERE UserID = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['uID']]);
        $owned_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $owned = false;
        foreach($owned_books as $own){
          if($own['ISBN'] == $_GET['ISBN']){
            $owned = true;
          }
        }
        if (!$book) {
            // Display error if the book does not exist
            exit('book does not exist!');
        }
    } else {
        // Display error if the ISBN wasn't specified
        exit('book does not exist!');
    }
?>

<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
  <link rel="stylesheet" href="./styles/BookInfo.css" />
  <link rel="stylesheet" href="./styles/main.css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
      <div>
      <div class="box-1">
        <div>
          <div style="display:flex;">
            <!-- TITLE -->
            <p class="info-title"><?=$book['Title']?></p>
          </div>
          <div>
            <div>
              <!-- COVER IMAGE OF BOOK -->
              <!-- HARDCODED FOR NOW-->
              <div class="CoverImage"> 
                <img src="<?=$book['ImageURL']?>" > 
              </div>
            </div>  
          </div>

          <!-- BOOK INFO, AUTHOR, ISBN AND OTHER DETAILS-->
          <p class="desc"><?=$book['Description']?></p>
          <p class="desc"><span>by <?=$book['Author']?></span></p>
          <p class="desc"><b>ISBN:</b> <?=$book['ISBN']?></p>
          <p class="desc"><b>Published by:</b> <?=$book['Publisher']?></p>
          <p class="desc"><span><b>Rated</b></span>
            <?php for ($i = 0; $i < $book['Rating']; $i++): ?> 
                <i class="fa fa-star"></i>
            <?php endfor; ?>
          </p>
          <?php if($owned): ?>
          <p class="price">Owned</p>
          <?php else: ?>
          <p class="price">&dollar;<?=$book['Price']?></p>
          <?php endif; ?>
          <!-- CART LINK -->
          <?php if($owned):?>
          <form action="MyLibrary.php" method="POST">
            <input type="submit" value="View in My Library" class="add-btn">
          </form>
            <?php else: ?>
          <form action="Store.php?page=cart" method="post">
            <input type="hidden" name="ISBN" value="<?=$book['ISBN']?>">
            <input type="submit" value="Add to Cart" class="add-btn">
            <?php endif; ?>
          </form>
          
        </div>
      </div>
    </div>
      
    
</body>
    <?php include 'footer.php'; ?>
</html>
    

