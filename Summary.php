<?php
session_start();
$location = $_SESSION['location'];
$page_title = "";
$header = "";
$desc = "";
switch ($location){
	// comming from confirm order page
	case "Confirm":
		$page_title = "Order Success";
		$header = "Thank you for your purchase!";
		$desc = "Please check your email for further instructions on how to access your ebook.";
		break;
	case "UserAccount":
		$page_title = "Update Success";
		$header = "Update Success!";
		$desc = "Your information has been successfully updated";
		break;
	case "Delete":
		$page_title = "Delete Account";
		$header = "Are You Sure?";
		$desc = "Are you sure you want to permanently delete your account?";
		break;
	case "DeletedAcc":
		$page_title = "Account Deleted";
		$header = "Account Deleted :(";
		$desc = "We're sad to see you go...";
		break;
	case "Library":
		$page_title = "Library";
		$header = "Shelf Empty!";
		$desc = "You have no books in your library";
		break;
	default:
		$page_title = "Error";
		$header = "OOPS!";
		$desc = "Something went wrong";
}
?>
<!doctype html>
<html>

<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="./styles/Summary.css" />
	<title><?php echo $page_title?></title>
</head>

<body className='snippet-body'>
	<div class="container mt-5 mb-5">

		<div class="row d-flex justify-content-center">

			<div class="col-md-8">

				<div class="card">

					<div class="invoice p-5">

						<h1 class="display-3"><?=$header?></h1>
						<p class="font-weight-bold d-block mt-4"><?=$desc?></p>

						<div class="payment border-top mt-3 mb-3 border-bottom table-responsive"></div>
							<!--  ADD LINK TO HOME PAGE BELOW */ -->
							<?php if($location == "Delete"):?>
							<a href="DeleteAccount.php" class="btn btn-primary mt-2">Yes I'm sure</a>
                            <a href="UserAccount.php" class="btn btn-primary mt-2">On second thought...</a>
							<?php elseif ($location == "DeletedAcc"): ?>
							<a href="Logout.php" class="btn btn-primary mt-2">home</a>
							<?php elseif ($location == "Library"): ?>
							<a href="Store.php" class="btn btn-primary mt-2">Back to the store</a>
							<?php elseif ($location == "UserAccount"): ?>
							<a href="Store.php" class="btn btn-primary mt-2">Back to the store</a>
							<a href="UserAccount.php" class="btn btn-primary mt-2">My Account</a>
                            <?php else: ?>
							<a href="MyLibrary.php" class="btn btn-primary mt-2">Continue to My Library</a>
                            <a href="Store.php" class="btn btn-primary mt-2">Back to the store</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>

</html>
