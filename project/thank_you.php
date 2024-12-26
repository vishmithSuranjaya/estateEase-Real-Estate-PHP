<?php 
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != 1){
    header("Location: login.php");
    exit;
}
if(!isset($_COOKIE['bidPayment']) && !isset($_COOKIE['bidPayment_1'])){
    header("Location: index.php");
    exit;
}

$ad_id = isset($_COOKIE['bidPayment']) ? $_COOKIE['bidPayment'] : null;
$ad_id = isset($_COOKIE['bidPayment_1']) ? $_COOKIE['bidPayment_1'] : $_COOKIE['bidPayment'];
setcookie('bidPayment',"", time() - (300), "/");
setcookie('bidPayment_1',"", time() - (300), "/");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: var(--background-color) !important;
            color: var(--font-color) !important;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        p.lead {
            font-size: 1.2rem;
        }

        .btn {
            margin: 15px;
        }

        hr {
            margin: 40px 0;
        }

    </style>
</head>
<body>
    <!--header-->
    <?php include './include/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="text-success">Thank You for Your Payment!</h2>
                <p class="lead">We appreciate your prompt payment. Your transaction has been successfully processed.</p>
                
                <?php if ($ad_id): ?>
                    <p>You have secured the property for the advertisement ID: <strong><?php echo htmlspecialchars($ad_id); ?></strong>.</p>
                <?php endif; ?>
                
                <hr>
                
                <h4 class="text-info">What's Next?</h4>
                <p>We will contact you shortly with the next steps to finalize your bid and complete the property transfer process.</p>
                
                <hr>
                <a href="wishlist.php" class="btn btn-primary">Go to My Wishlist</a>
                <a href="index.php" class="btn btn-secondary">View More Listings</a>
            </div>
            </br></br></br></br>
        </div>
    </div>

    <!-- Footer -->
    <?php include './include/footer.php'; ?>
</body>
</html>
