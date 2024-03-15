<?php 
session_start();


if(isset($_POST['next'])){
    $fname = $_POST['Fname'];
    $email = $_POST['email'];
    $addr = $_POST['addr'];
    $apt = $_POST['aptNo'];
    $city = $_POST['city'];
    $pcode = $_POST['pcode'];
    $prov = $_POST['prov'];

    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['email'] = $email;
    $_SESSION['addr'] = $addr;
    $_SESSION['apt'] = $apt;
    $_SESSION['city'] = $city;
    $_SESSION['pcode'] = $pcode;
    $_SESSION['prov'] = $prov;

    header("Location:ConfirmOrder.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="./styles/main.css" />
        <title>Payment Information</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

            *{
            font-family: 'Poppins', sans-serif;
            margin:0; padding:0;
            box-sizing: border-box;
            outline: none; border:none;
            text-transform: capitalize;
            transition: all .2s linear;
            }

            .container{
            display: flex;
            justify-content: center;
            align-items: center;
            padding:25px;
            min-height: 100vh;
            background-image: linear-gradient(to top right, #D58936, #69140E);
            }

            .container form{
            padding:20px;
            width:700px;
            background: #fff;
            box-shadow: 0 5px 10px rgba(0,0,0,.1);
            }

            .container form .row{
            display: flex;
            flex-wrap: wrap;
            gap:15px;
            }

            .container form .row .col{
            flex:1 1 250px;
            }

            .container form .row .col .title{
            font-size: 20px;
            color:#333;
            padding-bottom: 5px;
            text-transform: uppercase;
            }

            .container form .row .col .inputBox{
            margin:15px 0;
            }

            .container form .row .col .inputBox span{
            margin-bottom: 10px;
            display: block;
            }

            .container form .row .col .inputBox input{
            width: 100%;
            border:1px solid #ccc;
            padding:10px 15px;
            font-size: 15px;
            text-transform: none;
            }

            .container form .row .col .inputBox input:focus{
            border:1px solid #000;
            }

            .container form .row .col .flex{
            display: flex;
            gap:15px;
            }

            .container form .row .col .flex .inputBox{
            margin-top: 5px;
            }

            .container form .row .col .inputBox img{
            height: 34px;
            margin-top: 5px;
            filter: drop-shadow(0 0 1px #000);
            }

            .container form .submit-btn{
            width: 100%;
            padding:12px;
            font-size: 17px;
            background-color: #b9772f;
            color:#fff;
            margin: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            
            }

            .container form .submit-btn:hover{
                background-color: #da8b37;
            }
        </style>
    </head>
    <body>
    <div class="container">

<form action="PaymentInfo.php" method = "POST">

    <div class="row">

        <div class="col">

            <h3 class="title">Billing address</h3>

            <div class="inputBox">
                <span>Full Name:</span>
                <input type="text" placeholder="John Smith" name="Fname" id="Fname" autofocus >
            </div>
            <div class="inputBox">
                <span>Email:</span>
                <input type="email" placeholder="example@example.com" name="email" id="email">
            </div>
            <div class="inputBox">
                <span>Address:</span>
                <input type="text" placeholder="street address" name="addr" id="addr">
            </div>
            <div class="inputBox">
                <span>city:</span>
                <input type="text" placeholder="Toronto" name="city" id="city">
            </div>

            <div class="flex">
                <div class="inputBox">
                    <span>Province:</span>
                    <input type="text" placeholder="Ontario" name="prov" id="prov">
                </div>
                <div class="inputBox">
                    <span>Postal Code:</span>
                    <input type="text" placeholder="A1A 1A1" name="pcode" id="pcode">
                </div>
            </div>

        </div>

        <div class="col">

            <h3 class="title">Payment</h3>

            <div class="inputBox">
                <span>cards accepted :</span>
                <img src="imgs/card_img.png" alt="">
            </div>
            <div class="inputBox">
                <span>Name on card:</span>
                <input type="text" placeholder="John Henry Smith" required>
            </div>
            <div class="inputBox">
                <span>credit card number :</span>
                <input type="text" name="cardNum" id="cardNum"  maxlength="16" minlength="16"  size="16" required>
            </div>
            <div class="inputBox">
                <span>exp month :</span>
                <input type="text" placeholder="January" required>
            </div>

            <div class="flex">
                <div class="inputBox">
                    <span>exp year :</span>
                    <input type="text" name="expYear" id="expYear" placeholder="2020" required>
                </div>
                <div class="inputBox">
                    <span>CVV :</span>
                    <input type="text" name="CV" id="cv" maxlength="3" minlength="3" size="3" placeholder="123" required>
                </div>
            </div>

        </div>

    </div>

    <div style="display:flex;">
        <a href="Cancel.php" class="submit-btn">Cancel</a>
        <button type="submit" name="next" class="submit-btn">Proceed to checkout</button>
    </div>

</form>

</div>    
    </body>
</html>