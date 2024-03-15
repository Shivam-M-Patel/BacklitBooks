<?php 
session_start();
include 'DBconnection.php';
$searchbar = true;
$pdo = connectDB();
$sql = "SELECT * from books";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./styles/main.css" />
        <title>My Library</title>
        <style></style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="content-wrapper">
            <div class="store-header">
                <h2>All Books</h2>
        </div>
            <div class="book-list">
                <?php foreach ($rows as $books): ?>
                    <div class="book-wrapper">
                        <div class="book-cover">
                            <a href="Store.php?page=BookInfo&ISBN=<?=$books['ISBN']?>" class="title-link"><img src="<?=$books['ImageURL']?>" class="cover-image"></a>
                        </div>
                        <table class="book-info">
                            <tr>
                                <td><a href="Store.php?page=BookInfo&ISBN=<?=$books['ISBN']?>" class="title-link"><span><?=$books['Title']?></span></a></td>
                            </tr>
                            <tr>
                                <td>by <?=$books['Author']?></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php for ($i = 0; $i < $books['Rating']; $i++): ?> 
                                    <i class="fa fa-star"></i>
                                    <?php endfor; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span>&dollar;<?=$books['Price']?></span></td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>