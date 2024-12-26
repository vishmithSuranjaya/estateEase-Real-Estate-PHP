<?php
session_start();
require_once '../classes/Admin.php';
if (isset($_SESSION['useremail'])){
    $admin = new Admin($_SESSION['useremail']);
}
?>


<div class="user-details-container">
    <h2>- Admin Profile Details -</h2>
    <table class="user-details" >
        <tr>
            <td><b>Name : </b></td>
            <td><?php echo $admin->userName()?></td>
        </tr>
        <tr>
            <td><b>NIC :</b></td>
            <td><?php echo $admin->idUser()?></td>
        </tr>
        <tr>
            <td><b>Email :</b></td>
            <td><?php echo $admin->userEmail()?></td>
        </tr>
        <tr>
            <td><b>Address :</b></td>
            <td><?php echo $admin->getAddress()?></td>
        </tr>
        <tr>
            <td><b>Contact No :</b></td>
            <td><?php echo $admin->getContact()?></td>
        </tr>
        <tr>
            <td><b>Residing Town :</b></td>
            <td><?php echo $admin->getTown()?></td>
        </tr>
        <tr>
            <td><b>Residing District :</b></td>
            <td><?php echo $admin->getDistrict()?></td>
        </tr>
        
        
    </table>
    
        <div class="button-group">
            <button class="close-btn">Close</button>

        </div>
</div>