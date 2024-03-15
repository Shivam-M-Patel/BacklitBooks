<?php
// session_start();

$searchbar = true;
include 'DBconnection.php';
$pdo = connectDB();

// sql for most popular
$sql = "SELECT * FROM books WHERE Rating = 4 LIMIT 5;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
// sql for highest rated
$sql = "SELECT * FROM books WHERE Rating = 5 AND Price > 20 ORDER BY ISBN DESC LIMIT 5;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rated_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
// sql for great deals
$sql = "SELECT * FROM books WHERE Price < 25 ORDER BY Price ASC LIMIT 5;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$low_price_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
// sql for classics
$sql = "SELECT * FROM books WHERE Rating >= 4 ORDER BY PublicationYear ASC LIMIT 5;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$classic_books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/53a095ce36.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/main.css" />
    <title>Storefront</title>
    <style></style>
</head>

<body>
    <!-- form for testing search algorithm -->
    <?php include 'header.php'; ?>

    <div class="content-wrapper">
        <!-- Most popular-->
        <div class="store-header">
            <h2 id="best-sellers">Best Sellers</h2>
        </div>
        <div class="storefront-book-list">
            <!-- Displaying the books using a for loop -->
            <?php foreach ($rows as $books): ?>
                <div class="book-wrapper">
                    <div class="book-cover">
                        <a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><img src="<?= $books['ImageURL'] ?>" class="cover-image"></a>
                    </div>
                    <table class="book-info">
                        <tr>
                            <td><a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><span><?= $books['Title'] ?></span></a></td>
                        </tr>
                        <tr>
                            <td>by <?= $books['Author'] ?></td>
                        </tr>
                        <tr>
                            <!-- this is for displaying the star rating from the database -->
                            <td>
                                <?php for ($i = 0; $i < $books['Rating']; $i++) : ?>
                                    <i class="fa fa-star"></i>
                                <?php endfor; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>&dollar;<?= $books['Price'] ?></span></td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Highest rated-->
        <div class="store-header">
            <h2 id="highest-rated">Highest Rated</h2>
        </div>
        <div class="storefront-book-list">
            <?php foreach ($rated_books as $books) : ?>
                <div class="book-wrapper">
                    <div class="book-cover">
                        <a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><img src="<?= $books['ImageURL'] ?>" class="cover-image"></a>
                    </div>
                    <table class="book-info">
                        <tr>
                            <td><a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><span><?= $books['Title'] ?></span></a></td>
                        </tr>
                        <tr>
                            <td>by <?= $books['Author'] ?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php for ($i = 0; $i < $books['Rating']; $i++) : ?>
                                    <i class="fa fa-star"></i>
                                <?php endfor; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>&dollar;<?= $books['Price'] ?></span></td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Great Deals-->
        <div class="store-header">
            <h2 id="great-deals">Great Deals</h2>
        </div>
        <div class="storefront-book-list">
            <?php foreach ($low_price_books as $books) : ?>
                <div class="book-wrapper">
                    <div class="book-cover">
                        <a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><img src="<?= $books['ImageURL'] ?>" class="cover-image"></a>
                    </div>
                    <table class="book-info">
                        <tr>
                            <td><a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><span><?= $books['Title'] ?></span></a></td>
                        </tr>
                        <tr>
                            <td>by <?= $books['Author'] ?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php for ($i = 0; $i < $books['Rating']; $i++) : ?>
                                    <i class="fa fa-star"></i>
                                <?php endfor; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>&dollar;<?= $books['Price'] ?></span></td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Classics -->
        <div class="store-header">
            <h2 id="classics">Classics</h2>
        </div>
        <div class="storefront-book-list">
            <?php foreach ($classic_books as $books) : ?>
                <div class="book-wrapper">
                    <div class="book-cover">
                        <a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><img src="<?= $books['ImageURL'] ?>" class="cover-image"></a>
                    </div>
                    <table class="book-info">
                        <tr>
                            <td><a href="Store.php?page=BookInfo&ISBN=<?= $books['ISBN'] ?>" class="title-link"><span><?= $books['Title'] ?></span></a></td>
                        </tr>
                        <tr>
                            <td>by <?= $books['Author'] ?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php for ($i = 0; $i < $books['Rating']; $i++) : ?>
                                    <i class="fa fa-star"></i>
                                <?php endfor; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>&dollar;<?= $books['Price'] ?></span></td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>