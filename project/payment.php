<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Payment Gateway</title>
        <link rel="stylesheet" href="./CSS/payment.css">
    </head>
    <body>
         <?php include './include/header.php'; ?>
        
        <div class="container">
            <form action="payment_inc.php" method="POST">
                <div class="row">
                    <div class="col">
                        <h3 class="title">Advertisment details</h3>
                        
                        
                    </div>
                    <div class="col">
                        <h3 class="title">Payment Details</h3>
                        <div class="inputBox">
                            <span>Cards Accepted : </span>
                            <img src="./images/card_img.png" alt="acceptedCards" class="c_img">
                        </div>
                        <div class="inputBox">
                            <span>Name on the card: </span>
                            <input type="text" placeholder="Card Owner Name" name="c_name">
                        </div>
                        <div class="inputBox">
                            <span>Card Number: </span>
                            <input type="number" placeholder="1234123412341234" name="c_number">
                        </div>
                        <div class="inputBox">
                            <span>Expiry month: </span>
                            <input type="number" placeholder="02" name="c_month">
                        </div>
                        
                        <div class="flex">
                            <div class="inputBox">
                                <span>Expiry Year: </span>
                                <input type="number" placeholder="12" name="c_year">
                            </div>
                            <div class="inputBox">
                                <span>CVC Number: </span>
                                <input type="number" placeholder="123" name="c_cvc">
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="submit" value="Proceed to Pay" class="submit-btn">
            </form>
        </div>
        <?php include './include/footer.php'; ?>
    </body>
</html>
