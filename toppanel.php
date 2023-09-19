<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- favicon icon -->
    <link rel="icon" href="images/Golden_WC.ico" type="image/x-icon">

</head>

<body>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link coral-green d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

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
                                <button class="btn btn-success" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        <?php
                        include 'dbconn.php';
                        $user_id = $_SESSION['id'];
                        $Name = mysqli_query($conn, "SELECT * FROM `user_regiter` where `id` =  '$user_id'");
                        while ($row = mysqli_fetch_array($Name)) {
                            echo $row['name'];
                        ?>
                    </span>
                    <img class="img-profile rounded-circle" src="user_image/<?php echo $row['filename']; ?>"><?php  }  ?>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="index.php">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Home
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item pointer" data-toggle="modal" data-target="#resetPassword" id="rp_link">
                        <i class="fa fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                        Reset Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabuserDashboard="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-success" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal update -->
        <div class="modal fade" tabindex="-1" role="dialog" id="resetPassword" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header card-header ">
                        <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <div class="row">
                            <div class="mt-0 col-md-6">
                                <div class="form-group">
                                    <label>New Password </label>
                                    <input class="form-control" type="password" id="password" name="password" value="" placeholder="New Password">
                                </div>
                            </div>
                            <div class="mt-0 col-md-6">
                                <div class="form-group">
                                    <label>Confirm New Password </label>
                                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" value="" placeholder="Confirm New Password">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="pwd_err" style="color:red;padding-left: 1rem;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input name="current_user" type="hidden" class="form-control" id="current_user" value="<?php echo $user_id; ?>">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal" aria-label="Close" id="close_btn">Close</button>
                        <button name="reset_pwd" type="submit" class="btn btn-success" id="reset_pwd">Reset</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end Modal update -->
    </nav>
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

</body>
<script>
    $('#rp_link').on('click', function() {
        $("#pwd_err").html("");
        $("#password").val("");
        $("#confirm_password").val("");
        $("#password").css('border', '1px solid #d1d3e2');
        $("#confirm_password").css('border', '1px solid #d1d3e2');
    });
    $('#reset_pwd').on('click', function() {
        var password = $('#password').val();
        var current_user = $('#current_user').val();
        var confirmPassword = $("#confirm_password").val();
        $("#pwd_err").html("");
        if (password && confirmPassword) {
            if (password != confirmPassword) {
                $("#password").css('border', '1px solid red');
                $("#confirm_password").css('border', '1px solid red');
                $("#pwd_err").html("Passwords do not match.");
                return false;
            } else {
                $("#password").css('border', '1px solid #d1d3e2');
                $("#confirm_password").css('border', '1px solid #d1d3e2');
                $("#pwd_err").html("");
                $.ajax({
                    url: 'reset_password.php',
                    type: "POST",
                    data: {
                        password: password,
                        current_user: current_user,
                        flag: 2
                    },
                    cache: false,
                    beforeSend: function() {
                        console.log('b4')
                        $("#overlay").fadeIn(300);
                    },
                    success: function(result) {
                        console.log('result' + result)
                        if (result == 0) {
                            $("#password").val('');
                            $("#confirm_password").val('');
                            $("#pwd_err").html("Could not update password.");
                        } else if (result == 1) {
                            $("#password").val('');
                            $("#confirm_password").val('');
                            $("#pwd_err").html("Password updated.");
                            setTimeout(function() {
                                $("#close_btn").trigger("click");
                            }, 200);

                        }
                    }
                }).done(function() {
                    setTimeout(function() {
                        $("#overlay").fadeOut(300);
                    }, 500);
                });
            }



        } else {
            $("#password").css('border', '1px solid red');
            $("#confirm_password").css('border', '1px solid red');
            $("#pwd_err").html("Passwords can not be blank.");
            return false;
        }
    });
</script>

</html>