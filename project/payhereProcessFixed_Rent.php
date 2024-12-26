<?php
session_start();
require "./classes/Registered_user.php";

if (isset($_SESSION['id'])) {
    $user = new Registered_user();
    $user->getUserDetailsByNIC($_SESSION['id']);
}


$fullName = $user->getUsername();
$nameParts = explode(" ", $fullName);

if (count($nameParts) >= 2) {
    $firstName = $nameParts[0];
    $lastName = implode(" ", array_slice($nameParts, 1));
} else {
    $firstName = $fullName;
    $lastName = '';
}

$amount = 1000;
$merchant_id = "1228265";
$order_id = uniqid();
$merchant_secret = "MTE4MTQ4MzMzMjM0MDE5NTc3MDIxNzM0NDg3NzczMjAwOTg3NzU5MA==";
$currency = "LKR";
        
$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);        

$array = [];
       
$array['item'] = "Ad Posting fee";
$array['first name'] = $firstName;
$array['last name'] = $lastName;
$array['email'] = $user->userEmail();;
$array['phone'] = $user->getContactNum();
$array['address'] = $user->getAddress();
$array['city'] = $user->getTown();
$array['amount'] = $amount;
$array['mercahnt_id'] = $merchant_id;
$array['order_id'] = $order_id;
$array['amount'] = $amount;
$array['currency'] = $currency;
$array['hash'] = $hash;

$jsonObj = json_encode($array);

echo $jsonObj;

?>
