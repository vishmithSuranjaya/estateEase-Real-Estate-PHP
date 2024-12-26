<?php 
session_start();
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
    include './include/cookie_logger.php';
}

if($_SESSION['status'] != 1){
    header("Location: ./login.php");
}

$Ad_ID = isset($_GET['s']) ? ($_GET['s']) : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Over</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <link rel="stylesheet" href="./css/ViewBidstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include './include/header.php'; ?>

    <div class="container text-center my-5 bidOver">
        <h2>Bidding has Ended</h2>
        <p>The bidding for ad reference number <strong><?php echo htmlspecialchars($Ad_ID); ?></strong> has now closed. Thank you for participating!</p>
        <a href="./index.php" class="btn btn-primary">Back to Home</a>
    </div>

    <!-- Footer -->
    <?php include './include/footer.php'; ?>
</body>
</html>
