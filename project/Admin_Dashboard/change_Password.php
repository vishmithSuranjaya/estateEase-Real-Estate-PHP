<?php
session_start();
require_once '../classes/Admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
   
    $newPassword = strip_tags($_POST['newPassword']);
    $confirmNewPwd = strip_tags($_POST['newPassword2']);
    $currentPassword = strip_tags($_POST['curPassword']);
    
    if (isset($_SESSION['useremail'])) {
        $admin = new Admin($_SESSION['useremail']);
        $admin->setNewPassword($newPassword);
        $admin->setNewConfirmPwd($confirmNewPwd);
        
        if ($admin->checkPassword($currentPassword)) {
            if (!$admin->validatePassword()) {
                header('Location: admin_panel.php?status=6');
            } elseif (!$admin->passwordMatch()) {
                header('Location: admin_panel.php?status=2');
            } else {
                $admin->changePassword();
                header('Location: admin_panel.php?status=3');
            }
        } else {
            header('Location: admin_panel.php?status=4');
        }
    } else {
        header('Location: admin_panel.php?status=5');
    }

    
}
?>

<div class="changePw">
    <form id="passwordForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="formCenter">
            <label for="enter_cur_pw">Enter the Current Password:</label>&nbsp;&nbsp;
            <input type="password" name="curPassword" class="pw"><br><br>
            <label for="enter_new_pw">Enter the New Password:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="password" name="newPassword" class="pw"><br><br>
            <label for="enter_new_pw">Confirm the New Password:</label>&nbsp;&nbsp;
            <input type="password" name="newPassword2" class="pw"><br><br>
            <div class="resetSub-container">
                <input type="submit" name="submit" value="Reset Password" class="resetSub">
            </div>
        </div>
    </form>
</div>

