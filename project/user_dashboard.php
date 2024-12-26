<?php
session_start();
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
        include_once './include/cookie_logger.php';
    }

if($_SESSION['status'] != 1){
    header("Location: login.php");
}
require_once './include/header.php';
require_once './classes/Registered_user.php';

//inserting logged in users details to input fields
      $nic = $_SESSION['id'];

      $dbcon = new dbConnector();  //object for dbconnector class
      $con = $dbcon->getConnection();
      $query = "SELECT * FROM registered_user WHERE nic=?";

      try{
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$nic);
        $pstmt->execute();
        $row = $pstmt->fetch(PDO::FETCH_ASSOC);

            $username = $row["name"];
            $contactNum = $row["contact_No"];
            $address = $row["address"];
            $town_id = $row["town_id"];
      }catch(PDOException $e){
        die("Connection failed!".$e->getMessage());
      }


      $query3 = "SELECT district,town from town where town_id=?";
      try{
        $pstmt = $con->prepare($query3);
        $pstmt->bindValue(1,$town_id);
        $pstmt->execute();
        $row = $pstmt->fetch(PDO::FETCH_ASSOC);
    
           if($pstmt->rowCount() > 0){
            $district = $row["district"];
            $town = $row['town'];
           }
           
      }catch(PDOException $e){
        die("Connection failed".$e->getMessage());
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Page</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <link rel="stylesheet" href="./CSS/user_dashboard_styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-update {
            background-color: green;
            border-color: green;
            color: white;
        }
        .btn-change-password {
            background-color: green;
            border-color: green;
            color: white;
        }
        .btn-logout {
            background-color: blue;
            border-color: blue;
            color: white;
        }
        .btn-delete-account {
            background-color: red;
            border-color: red;
            color: white;
        }
    </style>
    <script>
     function updateAnswer() {
        alert("hh");
            var hValue = document.querySelector('select[name="h"]').value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST",window.location.href,true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector('select[name="a"]').value = xhr.responseText;
                }
            };
            xhr.send("h=" + encodeURIComponent(hValue));
            alert(hValue);
        }
</script>

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
        <main class="content">
            <h3>
                <?php
                 echo $_SESSION['username'];

                ?>
            </h3>
            <hr>
            <h4>Settings</h4>
            <hr>
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">
                        <?php
                          echo  "Email : ".$_SESSION['useremail'];

                        ?>

                    </label>
                    
                </div>
                
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name"  value="<?php echo $username; ?>"><br>
                    
                    <label for="name">Conatct No:</label>
                    <input type="text" class="form-control" name="contactNo" value="<?php 
                    $contactNum = str_pad($contactNum, 10, '0', STR_PAD_LEFT);
                    echo htmlspecialchars($contactNum, ENT_QUOTES, 'UTF-8'); ?>" ><br>

                    <label for="name">Address</label>
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" >
                </div>
                <div class="form_feild">   
                 
                 <label for="district">District:</label><br>
                 
                 <?php
                    $dbcon = new DbConnector();
                    $con = $dbcon->getConnection();

                    $sql = 'SELECT DISTINCT district FROM town';
                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                    $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                 
                 <select class="form-control"  id="dropdown1" name="district" onchange="updateTowns()">
                     <option value="" disabled selected><?php echo $district; ?></option>
                        <?php foreach ($districts as $district): ?>
                            <option value="<?= htmlspecialchars($district['district']) ?>"><?= htmlspecialchars($district['district']) ?></option>
                        <?php endforeach; ?>
                    </select>
               </div>
                    </br>
               <div class="form_feild">   
                <!-- <input class="feild1" type="text" name="town" placeholder="Town*" required=""><br><br>-->
                 <label for="town">Town:</label>
                 
                    <select class="form-control" name="town" id="a">
                       <option value="<?php echo $town; ?>"><?php echo $town; ?></option>
                    </select>
               </div>
                <button type="submit" class="btn btn-update" name="update_details">Update details</button>
                </form>
                 
                

                <!---------------------------------------------change password section --------------------------------------->
                <form action="" method="POST">
                <hr>
                <h3>Change Password</h3>
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" class="form-control" name="new-password">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" class="form-control" name="confirm-password">
                </div>
                <button type="submit" class="btn btn-change-password" name="paswword-change">Change password</button>
                <hr>
                
            </form>
            <form action="" method="post">
                <a href="logout.php" class="btn btn-logout">Logout</a>
                <input type="submit" name="delete-account" class="btn btn-delete-account" value="Delete Account">
            </form>
        </main>
    </div>
  
    <?php
      require_once './include/footer.php';
      
      
   
      //updating databse using user input
      if(isset($_POST['update_details'])){
          $nic = $_SESSION['id'];
          $name = $_POST['name'];
          $contactNum = $_POST['contactNo'];
          $address = $_POST['address'];
          $district = $_POST['district'];
          $town = $_POST['town'];
      
           $change = new Registered_user();

           $change->setUsername($name);
           $change->setContactNum($contactNum);
           $change->setAddress($address);
           $change->setTown($town);
           $change->setNic($_SESSION['id']);
           echo $town;

           if(!($change->validateUsername())){                            //checK username with regex
              echo "<script>alert('Enter valid name!')</script>";
           }
           else if(!($change->validateTelephone())){                     // checK contact number with regex
              echo "<script>alert('Enter valid contact number!')</script>";
           }
           else if(!($change->validateAddress())){                         //cheK address with regex
              echo "<script>alert('Enter valid address!')</script>";
           }
           else{
            
              // calling to updateUserDetails() to update the database
            
              $change->updateUserDetails();
              $_SESSION['username'] = $name;

               
           }
           
           echo "<script>window.location.href = 'user_dashboard.php';</script>";
           
        }
      
      
      //change password
      if(isset($_POST['paswword-change'])){
        
        $password = strip_tags($_POST['new-password']);
        $confirmPwd = strip_tags($_POST['confirm-password']);

        $changePwd = new Registered_user();
        $changePwd->setPassword($password);
        $changePwd->setconfirmPwd($confirmPwd);
        $changePwd->setNic($_SESSION['id']);

        if(!($changePwd->validatePassword())){                              //checK password with regex
            echo "<script>alert('Enter valid password')</script>";
        }
        else if(!($changePwd->passwordMatch())){                            //checK confirmpassword with regex
            echo "<script>alert('Passwords are not matching')</script>";
        }
        else{
           // $nic = $_SESSION['id'];
           $changePwd->changePassword();             // calling to cahngePassword() in the registered user class

        }
      }

      // delete account
      if(isset($_POST['delete-account'])){
        $nic = $_SESSION['id'];
       $dbcon = new dbConnector();
       $con = $dbcon->getConnection();
       $query = "DELETE FROM registered_users WHERE nic=?";

        try{
            $pstmt=$con->prepare($query);
            $pstmt->bindValue(1,$nic);
            $pstmt->execute();
            header("Location: index.php");
        }catch(PDOException $e){
            die("Connection fialed!".$e->getMessage());
        }
      }
     
      
      
    ?>

<script>
        function updateTowns() {
            var district = document.getElementById("dropdown1").value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './townlist_update.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("a").innerHTML = xhr.responseText;
                }
            };
            
            xhr.send("district=" + encodeURIComponent(district));
        }
    </script>

</body>
</html>