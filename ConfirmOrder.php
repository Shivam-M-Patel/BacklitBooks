<?php 
session_start();
function generateOrderNo() {
    // alphanumeric string of characters
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $orderNo = '';
    
    // for loop to generate random string
    for ($i = 0; $i < 7; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $orderNo .= $characters[$index];
    }

    return $orderNo;
}
include 'DBconnection.php';
$addr = $_SESSION['apt']. " " .$_SESSION['addr'] . "\n" . $_SESSION['city']. "\n" . $_SESSION['prov']. "\n". $_SESSION['pcode'];
$orderNo = generateOrderNo();
if(isset($_SESSION['incart'])){
    
    $books = $_SESSION['incart'];
    $subtotal = $_SESSION['subtotal'];
    $HST = round($subtotal * 0.13,2);
    $total = round($subtotal + $HST,2);
    
}
$ISBNS = "";
if(isset($_POST['order'])){
    $pdo = connectDB();
    foreach($books as $book){
        $ISBNS .= $book['ISBN'] ." ";
    }
    // insert into orders table
    $UID = $_SESSION['uID'];
    
    $sql = "INSERT INTO orders (OrderNo,UserID,ISBN,Total) VALUES (?,?,?,?);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$orderNo,$UID,$ISBNS,$subtotal]);
    // insert into userLibrary
    $sql = "INSERT INTO userlibrary (UserID,ISBN) VALUES (?,?);";
    foreach($books as $book){
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$UID,$book['ISBN']]);
    }
	$_SESSION['location'] = "Confirm";
    header("Location:Summary.php");
	
    unset($_SESSION['cart']);
    unset($_SESSION['incart']);
}


?>
<!doctype html>
<html>

<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>Billing Summary</title>
	<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="./styles/ConfirmOrder.css" />
	<style></style>
</head>

<body className='snippet-body'>
	<div class="container mt-5 mb-5">

		<div class="row d-flex justify-content-center">

			<div class="col-md-8">

				<div class="card">

					<div class="invoice p-5">

						<h5><strong>Billing Information Summary</strong></h5>

						<span class="font-weight-bold d-block mt-4">Hello <?=$_SESSION['username']?></span>
						<p>Please check the following information and confirm your order.</p>

						<div class="payment border-top mt-3 mb-3 border-bottom table-responsive">

							<!--  ORDER INFO SECTION */ -->
							<table class="table table-borderless">

								<tbody>
									<tr>
										<td>
											<div class="py-2">

												<span class="d-block text-muted">Order Date</span>
												<span><?php echo date("d-m-Y")?></span>

											</div>
										</td>

										<td>
											<div class="py-2">

												<span class="d-block text-muted">Order No</span>
												<span><?=$orderNo?></span>

											</div>
										</td>

										<td>
											<div class="py-2">

												<span class="d-block text-muted">Email</span>
												<span><?=$_SESSION['email']?></span>

											</div>
										</td>

										<td>
											<div class="py-2">

												<span class="d-block text-muted">Address</span>
												<span><?=$addr?></span>

											</div>
										</td>
									</tr>
								</tbody>

							</table>

						</div>
						<!--  BOOK INFO SECTION */ -->
						<div class="product border-bottom table-responsive">

							<table class="table table-borderless">
                            <?php foreach($books as $book):?>
								<tbody>
									<tr>
										<td width="15%">

											<img src="<?=$book['ImageURL']?>" width="60">

										</td>

										<td width="60%">
											<span class="font-weight-bold"><?=$book['Title']?></span>
											<div class="product-qty">
												<span class="book ISBN"><b>ISBN:</b><?=$book['ISBN']?></span>
												<p class="book Author"><b>by </b><?=$book['Author']?></p>
											</div>
										</td>
										<td width="20%">
											<div class="text-right">
												<span class="font-weight-bold">&dollar;<?=$book['Price']?></span>
											</div>
										</td>
									</tr>	
								</tbody>
                            <?php endforeach; ?>
							</table>

						</div>


						<!--  THIS SECTION IS FOR TOTAL */ -->
						<div class="row d-flex justify-content-end">

							<div class="col-md-5">

								<table class="table table-borderless">

									<tbody class="totals">

										<tr>
											<td>
												<div class="text-left">

													<span class="text-muted">Subtotal</span>

												</div>
											</td>
											<td>
												<div class="text-right">
													<span>&dollar;<?=$subtotal?></span>
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="text-left">

													<span class="text-muted">HST</span>

												</div>
											</td>
											<td>
												<div class="text-right">
													<span>&dollar;<?=$HST?></span>
												</div>
											</td>
										</tr>
										<tr class="border-top border-bottom">
											<td>
												<div class="text-left">

													<span class="font-weight-bold">Total</span>

												</div>
											</td>
											<td>
												<div class="text-right">
													<span class="font-weight-bold">&dollar;<?=$total?></span>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<!--  ADD LINK TO THANK YOU PAGE BELOW */ -->
                                <form action="ConfirmOrder.php" method="POST">
									<div style="display:flex;">
										<a href="Cancel.php" class="submit-btn">Cancel</a>
										<button type="submit" class="submit-btn" name="order" value="submit">Place Order</button>
									</div>
                                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>