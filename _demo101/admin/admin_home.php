<?php
global $db;
include('admin_header.php');
session_start();

if (isset($_SESSION["admin_id"])) {
    header("location: adminDashboard.php");
}
if (isset($_POST['sendLink'])) :
    $username = $_POST['email'];
    $sql = "SELECT * FROM  `admin` where `email`='$username' ";
    if ($sql) :
?>
        <script>
            $('exists').style.display = (block);
            $('dsntExist').style.display = (none);
        </script>
    <?php
    else :
    ?>
        <script>
            $('exists').style.display = (none);
            $('dsntExist').style.display = (block);
        </script>
<?php
    endif;
endif;
?>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center" style="margin-top: 58px;">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img class=" login-img-logo" src="../images/1552561678_i_xLvmDxd_X2.webp" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post" action="login.php">
                                        <div class="form-group">
                                            <input name="username" type="text" class="form-control form-control-user" id="InputEmail" placeholder="Enter Email or Mobile no...." required>
                                        </div>
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user" id="InputPassword" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="admin_Login" class="btn btn-primary btn-user btn-block" id="admin_login_btn"> Login</button>
                                    </form>
                                    <hr>
                                    <!-- <div class="text-center">
                                        <a class="small" data-toggle="modal" data-target="#enterEmail">Forgot Password?</a>
                                    </div> -->
                                    <div class="text-center">
                                        <?php
                                        $admin_result = $db->query("SELECT * FROM `admin`");
                                        $rowCount =  $admin_result['count'];
                                        if ($rowCount < 2) :
                                        ?>
                                            <a class="small" href="admin_register.php">Create an Account!</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shubhangi.shinde1501@gmail.com -->
    <!-- Modal -->
    <div class="modal fade" id="enterEmail" tabindex="-1" role="dialog" aria-labelledby="eModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Varification</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Enter a Valid E-mail" required>
                            <!-- <p id="result"></p> -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="">
                            <p class="text-success" id="exists" style="padding: 6px 12px; border: 1px solid green">A link has been sent to your Email Address, Follow that link to reset your password.</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="">
                            <p class="text-danger" id="dsntExist" style="padding: 6px 12px; border: 1px solid red">Please enter Email that is registered with us.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="forget-password.php"></a><button type="button" type="submit" name="sendLink" class="btn btn-warning">Send link</button>
                    <!-- <button type="button" href="login-page.php" class="btn btn-success">Go Back</button> -->
                </div>
            </div>
        </div>
    </div>


</body>

<?php include('admin_footer.php'); ?>