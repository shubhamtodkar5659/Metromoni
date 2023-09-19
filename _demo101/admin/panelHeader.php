<?php include('admin_header.php'); ?>

<body>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="adminDashboard.php">
            <div class="sidebar-brand-icon ">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel<sup></sup></div>
        </a>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="adminDashboard.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <!-- Divider -->
        <!-- Heading -->
        <div class="sidebar-heading">
        </div>
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link " href="users.php">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </li>
        <!-- Heading -->
        <div class="sidebar-heading">
        </div>
        <!-- Nav Item - plan -->
        <li class="nav-item">
            <a class="nav-link" href="pricingPlan.php">
                <i class="fas fa-money-check"></i>
                <span>Membership plan</span></a>
        </li>
        <!-- Nav Item - success story -->
        <li class="nav-item">
            <a class="nav-link" href="AddSuccessStory.php">
                <i class="fas fa-heart"></i>
                <span>Success Stories</span></a>
        </li>
        <!-- Nav Item - reviews -->
        <li class="nav-item">
            <a class="nav-link" href="add_review.php">
                <i class="fas fa-star-half-alt"></i>
                <span>Review</span>
            </a>
        </li>
        <!-- Nav Item - contact us -->
        <li class="nav-item">
            <a class="nav-link" href="inquiry.php">
                <i class="fas fa-envelope"></i>
                <span>Inquiry</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="sliders.php">
                <i class="fa fa-image"></i>
                <span>Sliders</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="add_religion.php">
                <i class="fa fa-image"></i>
                <span>Religion</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="add_higher_education.php">
                <i class="fa fa-image"></i>
                <span>Higher Education</span>
            </a>
        </li>
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->
</body>

</html>