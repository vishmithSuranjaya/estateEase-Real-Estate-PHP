<?php
include '../classes/Email.php';
header('Content-type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$current_nic = $input['current_nic'] ?? null;
$current_email = $input['current_email'] ?? null;
$previous_email = $input['previous_email'] ?? null;

$response = ['success' => false];

try {
    if ($previous_email) {
        $mail = new Mail();
        $receiver = $previous_email;
        $subject = "EstateEase - Auction";
        $body = "<p>Your Bid Has been Passed!</p>";
        $mail->sendMail($receiver, $subject, $body);
    }

    if ($current_email) {
        $mail2 = new Mail();
        $receiver2 = $current_email;
        $subject2 = "EstateEase - Auction";
        $body2 = "<p>Your Bid has been placed!</p>";
        $mail2->sendMail($receiver2, $subject2, $body2);
        $response['success'] = true;
    }

    
} catch (Exception $ex) {
    $response['error'] = $ex->getMessage();
    http_response_code(500);
}

echo json_encode($response);
?>
