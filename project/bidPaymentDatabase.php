<?php
session_start();
require "./classes/Registered_user.php";
require "./classes/bidAds.php";
require_once './classes/Email.php';

//$_SESSION['id'] = "123456779v";
//$_SESSION['bid_ad_id'] = 11;


$ad_id = isset($_SESSION['bid_ad_id']) ? $_SESSION['bid_ad_id'] : null;

if (isset($_SESSION['id'])) {
    $user = new Registered_user();
    $user->getUserDetailsByNIC($_SESSION['id']);
}

if(isset($_SESSION['bid_ad_id'])){
    $bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);
    $result = $bid->getAdOwnerNICbyAdId($ad_id);
}

$user2 = new Registered_user();
$user2->getUserDetailsByNIC($result);

$mail = new Mail();

try {
    $receiver = $user2->getUseremail();
    $subject = "EstateEase - Property Bid Completion";
    $body = "<p>The Winner of the bid has paid the advance money to reserve the property!</br></br>"
        . "Below contains his/her details</br></br>"
        . "<ul>"
        . "<li>NIC : " . $user->getId() . "</li>"
        . "<li>Name : " . $user->getUsername() . "</li>"
        . "<li>Email : " . $user->getUseremail() . "</li>"
        . "<li>Contact No : " . $user->getContactNum() . "</li>"
        . "<li>Address : " . $user->getAddress() . "</li>"
        . "<li>District : " . $user->getDistrict() . "</li>"
        . "<li>Town : " . $user->getTown() . "</li>"
        . "</ul>"
        . "</br>"
        . "Please contact the bid winner for further negotiations!</p>";
    $mail->sendMail($receiver, $subject, $body);

} catch (Exception $ex) {
    error_log("Error: " . $ex->getMessage());
    echo "An error occurred while sending the first email.";
}

try {
    $receiver = $user->getUseremail();
    $subject = "EstateEase - Payment Notice";
    $body = "<p>You have successfully paid Rs 20,000/= for reserving your property won by bidding.</br>"
        . "Below contains the details of the person who posted the bid - Ad</br></br>"
        . "<ul>"
        . "<li>NIC : " . $user2->getId() . "</li>"
        . "<li>Name : " . $user2->getUsername() . "</li>"
        . "<li>Email : " . $user2->getUseremail() . "</li>"
        . "<li>Contact No : " . $user2->getContactNum() . "</li>"
        . "<li>Address : " . $user2->getAddress() . "</li>"
        . "<li>District : " . $user2->getDistrict() . "</li>"    
        . "<li>Town : " . $user2->getTown() . "</li>"
        . "</ul>"
        . "</br>"
        . "Please contact the property owner for further negotiations!</p>";
    $mail->sendMail($receiver, $subject, $body);

} catch (Exception $ex) {
    error_log("Error: " . $ex->getMessage());
    echo "An error occurred while sending the second email.";
}



$user->auctionAdvancePayment($_SESSION['id'],$ad_id);

unset($_SESSION['bid_ad_id']);
?>