<?php
session_start();
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
        include './include/cookie_logger.php';
    }

if($_SESSION['status'] != 1){
    header("Location: login.php");
}
include_once './classes/dbConnector.php';
require_once './include/header.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Page</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <link rel="stylesheet" href="./CSS/wishlistStyles.css">
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    
    <div class="container3">
        <aside class="sidebar">
            <ul>
                <li><a href="./user_dashboard.php">Settings</a></li>
                <li><a href="./myAds.php">My Ads</a></li>
                <li><a href="./wishlist.php">Wishlist</a></li>
            </ul>
        </aside>
        <main class="content1">
            <h2><?php echo $_SESSION['username']; ?></h2>
            <hr>
                
           <div class="ads">
           <?php
              $id = $_SESSION['id'];
              $dbcon = new dbConnector();
              $con = $dbcon->getConnection();
              $query = "SELECT a.*, i.image1 as image
                        FROM advertisement a 
                        LEFT JOIN images i ON a.ad_id = i.ad_id
                        WHERE a.nic=?";
              try{
                $pstmt = $con->prepare($query);
                $pstmt->bindValue(1,$id);
                $pstmt->execute();
                
                if($pstmt->rowCount()>0){
                    while($rs = $pstmt->fetch(PDO::FETCH_ASSOC)){
                    echo 
              " <section class='content'>
                  <div class='box'>
                  <div class='card' style='width: 18rem;'>";
                       if(!empty($rs['image'])){
                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                            $mimeType = $finfo->buffer($rs['image']);
                            echo "<div class='card-img-container'>
                            <img src='data:".$mimeType.";base64,".base64_encode($rs['image'])."' alt='Property Image' class='doc'>
                                    </div>";
                        } else {
                            echo "
                            <p class='card-img-top'>No image Available</p>
                            ";
                        }
                  echo "    
                    <div class='card-body'>
                      <p class='card-text'>". $rs['title']. "</p>
                      <p >". $rs['description']. "</p>
                      <p>Price: ". $rs['price']. "</p>
                      <p>Type: ". $rs['type']."   |   Category: ".$rs['category']."</p>
                      <table class='ad-box'>
                         <tr>";
                            if (!empty($rs['land_Area'])) {
                                echo "<td>AREA<br>" . $rs['land_Area'] . "</td>";
                            }
                            if (!empty($rs['no_of_bedrooms'])) {
                                echo "<td>BEDS<br>" . $rs['no_of_bedrooms'] . "</td>";
                            }
                            if (!empty($rs['no_of_bathrooms'])) {
                                echo "<td>BATH<br>" . $rs['no_of_bathrooms'] . "</td>";
                            }
                            if (!empty($rs['no_of_floors'])) {
                                echo "<td>FLOORS<br>" . $rs['no_of_floors'] . "</td>";
                            }
                            if (!empty($rs['floor_area'])) {
                                echo "<td>FLOOR AREA<br>" . $rs['floor_area'] . "</td>";
                            }

                    echo "        
                       </tr>
                      </table>
                        <div class='button_group'> 
                            <a href='ad_redirector.php?ad_id=".$rs['ad_id']."' class='btn' name='gotoDetails'>Details</a>";

                          if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                        $ad_id = $rs['ad_id'];
                        $nic = $_SESSION['id'];

                        $sql9 = 'SELECT EXISTS (SELECT 1 FROM wishlist WHERE ad_id = :ad_id AND nic = :nic) AS record_exists;';
                        $stmt10 = $con->prepare($sql9);
                        $stmt10->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
                        $stmt10->bindValue(':nic', $nic, PDO::PARAM_STR);
                        $stmt10->execute();
                        $result = $stmt10->fetch(PDO::FETCH_ASSOC);

                        $heartType = $result['record_exists'] ? 'bi bi-heart-fill' : 'bi bi-heart';

                        echo "
                            <button type='submit' class='btn2' name='wishList' onclick='saveToWishlist(" . $ad_id . ",\"" . $nic . "\", this)'><i class='" . $heartType . "'></i></button>";
                    }

                        echo "
                        </div>
          
                     </div>
                  </div>
                  </div>
                </section>";
           }
          }
          }catch(PDOException $e){
            die("Connection failed".$e->getMessage());
          }
          
           
           ?>
        </div>

		</main>
    </div>

    <?php
     include './include/footer.php';

?>
</body>
</html>