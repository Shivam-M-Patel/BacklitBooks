<?php 
session_start();
include 'DBconnection.php';
$searchbar = true;
$rows =array();
// Recursive search function which takes the search term, search index, and an array as inputs
function search($term,$i,$rows){
    $pdo = connectDB();
    switch ($i){
        // ISBN Case
        case 0:
            $sql = "SELECT * FROM books WHERE ISBN = ?;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$term]);
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            if($rows){
                return $rows;
            }else{
                $i++;
                return $rows = search($term,$i,$rows);
            }
            break;
        // Title case    
        case 1:
            $sql = "SELECT * FROM books WHERE Title LIKE '%" . $term ."%';";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows){
                return $rows;
            }else{
                $i++;
                return $rows = search($term,$i,$rows);
            }
            break;
        // Author case
        case 2:
            $sql = "SELECT * FROM books WHERE Author LIKE '%" . $term ."%';";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows){
                return $rows;
            }else{
                $i++;
                return $rows = search($term,$i,$rows);
            }
            break;
        // Publisher case
        case 3:
            $sql = "SELECT * FROM books WHERE Publisher LIKE '%" . $term ."%';";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows){
                return $rows;
            }else{
                $i++;
                return $rows = search($term,$i,$rows);
            }
            break;
        // genre case
        /* If we end up having a genre column in the database then uncomment this
        case 4:
            $sql = "SELECT * FROM books WHERE Genre LIKE '%" . $term ."%';";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows){
                return $rows;
            }else{
                $i++;
                return $rows = search($term,$i,$rows);
            }
            break;
            */

            default:
                $err =  "Search term not found";
    }
}

if (isset($_GET['search'])){
    $rows = array();
    $rows = search($_GET['search_term'],0,$rows);
    if($rows === null){
        $count = 0;
    }else{
        $count = count($rows);
    }
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./styles/main.css" />
        <title>Search results</title>
        <style></style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="content-wrapper">
            <div class="store-header">
                <h2>Displaying <?=$count?> result(s) for "<?=$_GET['search_term']?>"</h2>
            </div>
            <!-- If no books found display error msg -->
            <?php if($count == 0):?>
                <div class = "error-msg">
                    <h2>** "<?=$_GET['search_term']?>" was not found **</h2>
                </div>
            <?php else: ?>
            <!-- if books found then display them -->
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
                <?php endif;?>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>