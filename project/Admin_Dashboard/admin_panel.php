<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();

if($_SESSION['status'] != 1){
    header("Location: login.php");
require_once '../classes/Admin.php';
require_once '../logIn.php';
}

if(isset($_SESSION['status'])){
    if($_SESSION['role'] != "admin") {
        header("Location: ../index.php");
        exit();
    }
}


?>




<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv='X-UA-Compatible'content='IE-edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>

        <title> Admin Dashboard</title>
        <link rel="icon" href="../images/logo.png" type="image/png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css">

        <link rel='stylesheet' href='admin_panel.css'>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <div class='wrapper'>
            <aside id='sidebar' class="expand">
                <div class='d-flex'>
                    <button id='toggle-btn' type='button'>
                        <i class="lni lni-grid-alt"></i>
                    </button>
                    <div class='sidebar-logo'>
                        <a href='#'>Menu</a>
                    </div>
                </div>
                <ul class='sidebar-nav'>
                    <li class='sidebar-item'>
                        <a href='admin_panel.php' class='sidebar-link'>
                            <i class="lni lni-user"></i>
                            <span>DashBoard</span>
                        </a>
                    </li>
                    <li class='sidebar-item'>
                        <a href='#' class='sidebar-link' id="changePassword">
                            <i class="lni lni-agenda"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li class='sidebar-item'>
                        <a href='#' class='sidebar-link has-dropdown oollapsed' data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                            <i class="lni lni-protection"></i>
                            <span>User Management</span>
                        </a>
                        <ul id='auth' class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link" id="removeUser">Remove Users</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link" id="banUser">Ban Users</a>
                            </li>
                        </ul>
                    </li>
                    <li class='sidebar-item'>
                        <a href='admin_panel.php' class='sidebar-link' id="viewBlack">
                            <i class="lni lni-user"></i>
                            <span>View Blacklist</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class ="sidebar-link has-dropdown oollapsed" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                            <i class="lni lni-layout"></i>
                            <span>View Advertisements</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link" id="bidAd">Bid - Advertisements</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link" id="nonBidAd">Non- bid Advertisements</a>
                            </li>
                        </ul>
                    </li>
                    <li class='sidebar-item'>
                        <a href='#' class='sidebar-link' id="removeAd">
                            <i class="lni lni-popup"></i>
                            <span>Remove Advertisements</span>
                        </a>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <a href="../logout.php" class="sidebar-link">
                        <i class="lni lni-exit"></i>
                        <span>Log Out</span>
                    </a>
                </div>
            </aside>
            
            <div class="main">
                <nav class="navbar navbar-expand px-4 px-3">
                    <a href="admin_panel.php">
                        <img src="img/logo.png" alt="logo" class="logo" >
                    </a>
                    <div class="navbar-collapse collapse">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-icon pe-md-o" data-bs-toggle="dropdown">
                                    <span class='user_name'>
                                        <?php
                                            if(isset($_SESSION['username'])){
                                                echo $_SESSION['username'];
                                            }
                                         ?>
                                    </span>
                                    <img src="img/profile.jpg" class="avatar img-fluid profile-img" alt="profile-pic">
                                    
                                </a>
                                <div class="dropdown-menu dropdown-menu-end rounded ">
                                    <a href="#" class="dropdown-item view_profile">
                                        <i class="lni lni-timer"></i>
                                        <span>View Profile</span>
                                    </a>
                                    <a href="#" class="dropdown-item"  id="changePasswordNav">
                                        <i class="lni lni-cog"></i>
                                        <span>Change Password</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                        <a href="../logout.php" class="dropdown-item">
                                            <i class="lni lni-exit"></i>
                                            <span>Log Out</span>
                                        </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main class="content px-3 p-4">
                    <div class="container-fluid">
                        <div class="mb-3" id="currentContent">
                            <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>
                            
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="card border-0 user-app">
                                        <div class="card-body py-4">
                                            <h5 class="mb-2 fw-bold">
                                                Check User Approval Requests
                                            </h5>
                                            <p class="mb-12 fw-bold">
                                               View Now
                                            </p>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">
                                                    <?php
                                                    require_once '../classes/Admin.php';

                                                    if (isset($_SESSION['useremail'])) {
                                                        $admin = new Admin($_SESSION['useremail']);
                                                        $admin->totalUsersCount();
                                                    }
                                                    
                                                    
                                                    ?>
                                                </span>
                                                <span class="fw-bold">
                                                    New Users
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card border-0 ad-app">
                                        <div class="card-body py-4">
                                            <h5 class="mb-2 fw-bold">
                                                Check Ad-Approval Requests
                                            </h5>
                                            <p class="mb-12 fw-bold">
                                                View Now
                                            </p>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">
                                                    <?php
                                                    require_once '../classes/Admin.php';

                                                    if (isset($_SESSION['useremail'])) {
                                                        $admin = new Admin($_SESSION['useremail']);
                                                        $admin->TotalPendingBidAdCount();
                                                    }
                                                    
                                                    
                                                    ?>
                                                </span>
                                                <span class="fw-bold">
                                                    New Advertisements
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card border-0">
                                        <a href="https://mail.google.com/mail/u/1/#inbox" class='emails'>
                                        <div class="card-body py-4">
                                            <h5 class="mb-2 fw-bold">
                                                Emails
                                            </h5>
                                            <p class="mb-12 fw-bold">
                                                click here to check emails
                                            </p>
                                            <!--
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">
                                                   New emails
                                                </span>
                                                <span class="fw-bold">
                                                   since last viewed
                                                </span>
                                            </div>
                                            -->
                                        </div>
                                            </a>
                                    </div>
                                </div>
                            </div>
                            <h3 class="fw-bold fs-4 my-3">Analytics</h3>
                            <div class="row">
                                <div class ="col-12">
                                    <div id="barchart_material" style="width: 100%; height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                        <div id="change_Password" style="display: none;">
                            <?php
                                if (isset($_GET["status"])) {
                                if ($_GET["status"] == 6) {
                                    echo "<script>alert('Enter a valid password')</script>";
                                    echo "<script>window.onload = function(){onloading();}</script>";
                                }elseif($_GET["status"]==2){
                                    echo "<script>alert('Passwords do not match')</script>";
                                    echo "<script>window.onload = function(){onloading();}</script>";
                                }elseif ($_GET["status"] == 3) {
                                    echo "<script>alert('Password changed successfully')</script>";
                                    echo "<script>window.onload = function(){onloading();}</script>";
                                } elseif ($_GET["status"] == 4) {
                                    echo "<script>alert('Current password incorrect')</script>";
                                    echo "<script>window.onload = function(){onloading();}</script>";
                                } elseif ($_GET["status"] == 5) {
                                    echo "<script>alert('Session useremail not set')</script>";
                                    echo "<script>window.onload = function(){onloading();}</script>";
                                } 
                             }

                             ?>
                        </div>
                        <div id="remove_Users" style="display:none;"></div>
                        <div id="ban_Users" style="display:none;"></div>
                        <div id="bid_Ads" style="display:none;"></div>
                        <div id="nonBid_Ads" style="display:none;"></div>
                        <div id="remove_Ads" style="display:none;"></div>
                        <div id="viewBlacklist" style="display:none;"></div>
                    </div>
                </main>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row text-body-secondary">
                            <div class="col-6 text-start">
                                <a href="#" class="text-body-secondary">
                                    <strong>estateEase</strong>
                                </a>
                            </div>
                            <div class="col-6 text-end text-body-secondary d-none d-md-block">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="#" class="text-body-secondary">Contact</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="text-body-secondary">About Us</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="text-body-secondary">Terms and Conditions</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </footer>
            </div>

        </div>

            <?php
            // put your code here
            ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
            <script src="admin.js"></script>
            
    </body>
</html>
