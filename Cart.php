<?php
include 'DBconnection.php';
$pdo = connectDB();
// If the user clicked the add to cart button on the book info page we check the form data
if (isset($_POST['ISBN'])){
    $ISBN = $_POST['ISBN'];

    $sql = "SELECT * FROM books WHERE ISBN = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['ISBN']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row){
        if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
            if(array_key_exists($ISBN, $_SESSION['cart'])){
                echo "Book already in cart";
            }else{
                $_SESSION['cart'][$ISBN] = $row['Title'];
            }
        }else{
            $_SESSION['cart'] = array($ISBN => $row['Title']);
        }
    }

    // Prevent form resubmission
    header('location: Store.php?page=cart');
    exit;
    
}

// Remove book from cart
if (isset($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the book from the cart session
    unset($_SESSION['cart'][$_GET['remove']]);
    
}

// checks session for books in cart
$books_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$books = array();
$total = 0;

// display the books in the cart
if($books_in_cart){

    $array_to_question_marks = implode(',', array_fill(0, count($books_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM books WHERE ISBN IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_keys($books_in_cart));
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['incart'] = $books;

    foreach ($books as $book) {
        $total += $book['Price'];
        
    }
    $_SESSION['subtotal'] = $total;
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./styles/main.css" />
        <link rel="stylesheet" href="./styles/Cart.css" />
        
        <title>Place Order</title>
        <style></style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="cart-content-Wrapper">
            <h1 class="cart-title"><?=$num_in_cart?> item(s) in <?=$_SESSION['username']?>'s Shopping cart</h1>
            <form action="Store.php?page=cart" method="post">
                <table id="cart-wrapper">
                    <thead>
                        <tr>
                            <td>Book Information</td>
                            <td>Remove from cart</td>
                            <td>Price</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($books)): ?>
                        <tr>
                            <td colspan="3" class="total" style="text-align:centter;">**There are no books in your cart**</td>
                            <?php $total = 0;?>
                        </tr>
                        <?php else: ?>
                        <?php foreach($books as $book):?>
                        <tr>
                            <td class="cart-book-info">
                                <div class="cart-book-cover">
                                    <a href = "Store.php?page=BookInfo&ISBN=<?=$book['ISBN']?>"><img src="<?=$book['ImageURL']?>" class="cart-cover-image"></a>
                                </div>
                                <table>
                                    <tr>
                                        <td><a href= "Store.php?page=BookInfo&ISBN=<?=$book['ISBN']?>" class="cart-title-link"><?=$book['Title']?></a></td>
                                    </tr>
                                    <tr>
                                        <td>by <?=$book['Author']?></td>
                                    </tr>
                                    <tr>
                                        <td>Published by: <?=$book['Publisher']?></td>
                                    </tr>
                                    <tr>
                                        <td>ISBN: <?=$book['ISBN']?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php for ($i = 0; $i < $book['Rating']; $i++): ?> 
                                            <i class="fa fa-star"></i>
                                            <?php endfor; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="remove"><a href="Store.php?page=cart&remove=<?=$book['ISBN']?>"><i class="fa fa-trash-o" style="font-size:30pt;"></i></a></td>
                            <td class="cart-price">&dollar;<?=$book['Price']?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3" class="total">Total: &dollar;<?=$total?></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <table style="margin-left: auto; margin-right:auto; padding:10px;">
            <?php if (empty($books)): ?>
            <tr>
                <td><a href="Store.php" class="continue-btn">Back to the store</a></td>
            </tr>
            <?php else: ?>
            <tr>
                <form action="Cancel.php" method="GET">
                    <td><button class="continue-btn" type="submit" name="cancel" value="submit">Cancel</button></td>
                </form>
                <form action="PaymentInfo.php" method="POST">
                    <td><button class="continue-btn" type="submit" name="continue" value="submit">Continue</button></td>
                </form>
            </tr>
            <?php endif; ?>
        </table>
        <?php include 'footer.php'; ?>
    </body>
</html>
