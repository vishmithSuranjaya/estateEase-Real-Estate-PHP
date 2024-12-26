

<?php
session_start();
if(isset($_GET['nic']) && isset($_GET['rowNumber'])){
    $nic = htmlspecialchars($_GET['nic']);
    $rowNumber = $_GET['rowNumber'];
} else {
    echo '<h3 style="color:red">No NIC Provided!</h3>';
    exit();
}

require_once '../classes/Admin.php';

if (isset($_SESSION['useremail'])) {
    $admin = new Admin($_SESSION['useremail']);
    $user = $admin->viewBannedUserDetails($nic);
}


if($user){
    ?>
    <div class="user-details-container">
        <h2>- Details of the User -</h2>
        <table class="user-details">
                <tr>
                    <td><b>1) NIC Number : </b></td>
                    <td><?php echo htmlspecialchars($user['nic']); ?></td>
                    <td><b>8) Verification Document : </b>
                </tr>
                <tr>
                    <td><b>2) Name : </b></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td rowspan="6">
                        <div class="user-verification">
                            <?php 
                            if(!empty($user['verification_doc'])){
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($user['verification_doc']);
                                ?>
                                 <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['verification_doc']); ?>" alt='Verification Document' class="doc">
                                <?php

                            } else {
                                ?>
                                <p>No Verification Document Available</p>
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>3) Email : </b></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <td><b>4) Status : </b></td>
                    <td><?php if(htmlspecialchars($user['status']) == "Blacklisted"){
                        echo "<font style='color:red'>".htmlspecialchars($user['status'])."</font>";
                    }else{
                        echo htmlspecialchars($user['status']);
                    }; ?></td>
                </tr>
                <tr>
                    <td><b>5) Contact Number : </b></td>
                    <td><?php echo htmlspecialchars($user['contact_No']); ?></td>
                </tr>
                <tr>
                    <td><b>6) Residing District : </b></td>
                    <td><?php echo htmlspecialchars($user['district']); ?></td>
                </tr>
                <tr>
                <td><b>7) Residing Town : </b></td>
                <td><?php echo htmlspecialchars($user['town']); ?></td>
            </tr>
        </table>
        
        <div class="button-group">
            <button class="close-btn">Back</button>
            <button class="btn btn-sm btn-warning UD" id="removeBanButton" onclick="popupRemoveBanUser(<?php echo $rowNumber ?>)">Remove Ban</button>

        </div>
    </div>
    <?php    
} else {
    echo '<h3 style="color:red">User not found!</h3>';
    echo '</br><button class="close-btn">Back</button>';
}
?>
