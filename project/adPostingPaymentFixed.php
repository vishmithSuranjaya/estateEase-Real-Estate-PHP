<?php
session_start();
require "./classes/Registered_user.php";
require_once './classes/Email.php';

if (isset($_SESSION['id'])) {
    $user = new Registered_user();
    $user->getUserDetailsByNIC($_SESSION['id']);
}

try {
    $mail = new Mail();
    $receiver = $user->getUseremail();
    $subject = "EstateEase - Payment Notice";
    $body = "<p>You have successfully paid Rs 1000/= for posting your fixed property advertisement on our website.</p>";
    $mail->sendMail($receiver, $subject, $body);
} catch (Exception $ex) {
    die("Error".$ex->getMessage());
}


$user->adPostingPayment($_SESSION['id']);
?>

