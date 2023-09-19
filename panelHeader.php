<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- * Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com -->
    <link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- favicon icon -->
    <link rel="icon" href="images/Golden_WC.ico" type="image/x-icon">
</head>

<body>

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="userDashboard.php">

            <div class="sidebar-brand-text mx-3">User Dashboard<sup></sup></div>
        </a>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="userDashboard.php">
                <!-- <i class="fas fa-fw fa-tachometer-alt"></i> -->
                <i class="fas fa-user fa-sm fa-fw"></i>
                <span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="visitedProfiles.php">
                <i class="fas fa-eye  fa-sm fa-fw"></i>
                <span>Visited Profiles</span></a>
        </li>
        <!-- Nav Item - match -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="matches.php"> -->
        <!-- <i class="fa-solid fa-folder-heart"></i> -->
        <!-- <i class="fa-solid fa-thumbs-up"></i>
                <span>My Matches</span></a>
        </li> -->

        <!-- Nav Item - shortlist -->
        <li class="nav-item">
            <a class="nav-link" href="shortlist.php">
                <i class="fa-solid fa-heart fa-sm fa-fw"></i>
                <span>My Shortlist</span></a>
        </li>

        <!-- Nav Item - plan -->
        <li class="nav-item">
            <a class="nav-link" href="user_plan.php">
                <i class="fas fa-money-check"></i>
                <span>Membership plan</span></a>
        </li>
        <!-- Nav Item - plan purchase history -->
        <li class="nav-item">
            <a class="nav-link" href="user_purchase.php">
                <i class="fa-sharp fa-solid fa-clock-rotate-left"></i>
                <span>Purchase History </span></a>
        </li>
        <!-- Nav Item - all profiles -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="showAll.php">
                <i class="fa-solid fa-users"></i>
                <span>All Profiles </span></a>
        </li> -->
        <!-- inbox  -->
        <li class="nav-item">
            <a class="nav-link" href="inbox.php">
                <i class="fa fa-inbox" aria-hidden="true"></i>
                <span>Inbox </span></a>
        </li>
        <!--  outbox -->
        <li class="nav-item">
            <a class="nav-link" href="outbox.php">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                <span>Outbox </span></a>
        </li>
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->


    
</body>

</html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['all_data_saved']) && $_SESSION['all_data_saved'] == 'no') {
    $url =  $_SERVER['REQUEST_URI'];
    if (strpos($url, 'userDashboard.php') !== false) {
    } else {
        echo '<script> 
                window.location.href = "userDashboard.php";   
        </script>';
    }
}
