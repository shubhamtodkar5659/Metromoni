<?php

$adId = $_SESSION['admin_id'];

if (isset($adId)) {
    include('admin_header.php');
    $name = "";
    $email =  "";
    $mobile =  "";
    $result = $db->query_one("SELECT * FROM `admin` where `id` = $adId ");
    $res_rows = $result['rows'];
    $row_one = (isset($res_rows[0])) ? $res_rows[0] : array();

    if (!empty($row_one)) {
        $name = $row_one[1];
        $email = $row_one[2];
        $mobile = $row_one[3];
    }

    //while ($res_rows) {

?>

    <body>
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form> -->

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Nav Item - Alerts -->
                <!-- <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li> -->

                <!-- Nav Item - Messages -->
                <!-- <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                        problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how
                                        would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with
                                        the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                        told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li> -->

                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - Admin Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            <?php
                            $resName = $db->query_one("SELECT name FROM `admin` WHERE  `id` = $adId ");

                            if (!empty($resName[0])) {
                                $adminName = $resName[0]['name'];
                                echo ucfirst($adminName);
                            }

                            ?>
                        </span>
                        <img class="img-profile rounded-circle" src="img/admin.png">
                    </a>
                    <!-- Dropdown - Admin Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="adminDropdown">
                        <a class="dropdown-item" href="../index.php">
                            <i class="fa fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                            Home
                        </a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#adminModal" style="cursor: pointer;">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Admin Profile
                        </a>
                        <a class="dropdown-item" data-toggle="modal" data-target=".updtAdminDetailModal" style="cursor: pointer;">
                            <i class="fa fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                            Update Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- ----------------admin profile popup -->
        <div class="modal fade" id="adminModal" tabuserDashboard="-1" role="dialog" aria-labelledby="adminModaltitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminModaltitle">Admin Profile</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <b class="bold_title">Name :</b> <?php echo $name; ?><br>
                        <b class="bold_title">E-mail :</b> <?php echo $email; ?><br>
                        <b class="bold_title">Phone Number :</b> <?php echo $mobile; ?><br>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <!-- <a class="btn btn-primary" href="logout.php">Logout</a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ----------update model ----------------------- -->
        <?php
        if (isset($_POST['updateProfile'])) {
            $name = $_POST['name'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $editP = $_POST['edit_P'];

            // $sql = mysqli_query($conn, "UPDATE `admin` SET `name` = '$name' ,`email`='$email',`mobile`='$mobile' where `id` = '$editP' ");
            // if ($sql) {
            //     echo "alert('Profile updated successfully!😊');";
            //     header("location:adminDashboard.php");
            // } else {
            //     echo "alert('There was a problem!😯');";
            // header("location:adminDashboard.php");
            // }
        }
        ?>
        <div class="modal fade updtAdminDetailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="">
                    <!-- Modal update -->
                    <div class="modal-content">
                        <div class="modal-header card-header ">
                            <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body " style="padding: 2rem;">
                            <div class="row">
                                <div class="mt-0 col-md-4">
                                    <div class="form-group">
                                        <label>Your Name </label>
                                        <input class="form-control" type="text" id="adName" name="name" value="<?php echo  ucwords($name); ?>" placeholder="<?php echo  ucwords($name); ?>">
                                        <p id="name"></p>
                                    </div>
                                </div>
                                <div class="mt-0 col-md-4">
                                    <div class="form-group">
                                        <label>Your Email </label>
                                        <input class="form-control" type="text" id="adMail" name="email" value="<?php echo  $email; ?>" placeholder="<?php echo  $email; ?>">
                                        <p id="name"></p>
                                    </div>
                                </div>
                                <div class="mt-0 col-md-4">
                                    <div class="form-group">
                                        <label>Your Mobile no. </label>
                                        <input class="form-control" type="text" id="adMob" name="mobile" value="<?php echo $mobile; ?>" placeholder="<?php echo  $mobile; ?>">
                                        <p id="name"></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input name="edit_P" type="hidden" class="form-control" id="edit_P" value="<?php echo $id; ?>">

                                    <button name="updateProfile" type="submit" class="btn btn-warning" id="updt_btn">Update</button>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end Modal update -->
                </form>
                <?php // } // while
                ?>

            </div>
        </div>
    </body>

    </html>
<?php } ?>