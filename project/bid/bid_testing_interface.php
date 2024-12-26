<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();
include 'DbConnector.php';

//$sesh_nic = $_SESSION['nic'];
//$sesh_email = $_SESSION['email'];

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>bidding interface</title>
        <script src ="bid.js"></script>
        
    </head>
    <body>
        
        
        <div class="count-time">
                        <div class="a">
                            <p>Days : <span class="day"></span></p>
                        </div>
                        <div class="b">
                            <p>hours : <span class="hour"></span></p>
                        </div>
                        <div class="c">
                            <p>Minutes : <span class="minute"></span></p>
                        </div>
                        <div class="d">
                            <p>Seconds : <span class="second"></span></p>
                        </div>
                    </div>
        
        <div class="current-bid">
            <p>Bid Starting Price : <span id="min_auc_price"></span></p>
            <b>Current Bid : <span id="current-bid"></span></b></br>
            <p>Number of bids : <span id="number_of_bids"></span></p>
                    <input type="text" name="bidAmount"  id="bidAmount" placeholder="22,000">    
                    <button class="place-bid-btn" id="place-bid" name="placeBid">Place Bid</button>
                   </div>
            </div>
            
            <input type="hidden" id="session-nic" value="345678901234">
            <input type="hidden" id="session-email" value="bobjohnson@example.com">
           
        
        <script>
              
        </script>
    </body>
</html>
