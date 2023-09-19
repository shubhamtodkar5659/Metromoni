<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php

session_start();

include 'dbconn.php';

if (isset($_POST['uLogin'])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    // echo $password ;
    $sql = "SELECT * FROM  `user_regiter` where `email`='$username'  AND `password`='$password' OR `phone`='$username'  AND `password`='$password'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {

        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $return_page = isset($_SESSION["return_page"]) ? $_SESSION["return_page"] : '';

        if (isset($_SESSION["id"])) {
            if (!empty($return_page)) {
                header("location:$return_page");
            } else {
                header("location:userDashboard.php");
            }
        } else { ?>
            <script>
                swal({
                    title: "Oops...",
                    text: "User Not Registerd",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                window.location.href = signup - couple.php;
            </script>
        <?php
        }
    }
}
if (isset($_POST['sendLink'])) {
    $username = $_POST['email'];
    $sql = "SELECT * FROM  `user_regiter` where `email`='$username' ";
    if ($sql) {
        ?>
        <script>
            $('exists').style.display = (block);
            $('dsntExist').style.display = (none);
        </script>
    <?php
    } else {
    ?>
        <script>
            $('exists').style.display = (none);
            $('dsntExist').style.display = (block);
        </script>
<?php
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevyogVivah | Matrimony for Doctors</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fontello.css">
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">

</head>

<body class="reg_bg">

    <!-- /.top search -->
    <!-- page header -->
    <!-- <div class="tp-page-head" style=" height: 27rem;">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center"  style="margin: 60px 0 0;">
                        <div class="icon-circle">
                            <i class="icon icon-size-60 icon-padlock-1 icon-white"></i>
                        </div>
                        <h1>Welcome back to your account</h1>
                        <p>We're happy to have you back.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- /.page header -->
    <div class="tp-breadcrumb" style="background-color: #fdfdf8;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Login Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- reg_bg -->
    <div class="main-container ">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 st-tabs mb40">
                    <!-- Nav tabs -->
                    <div class="well-box  shadow">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <!-- <div class="img-wellbox"> -->
                                <img src="images/login_mg.png" class="bg-login-image" width="90%" alt="">
                                <!-- </div> -->
                            </div>
                            <div class="col-md-6">
                                <div class="login-logo" style="text-align: center;">
                                    <img src="images/logo.png" width="65%" alt="">
                                </div>
                                <div class="mt30">
                                    <h1 class="text-center mt30">Login</h1>
                                    <form action="" method="post" class="">
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="control-label" for="mobile">Mobile Number/E-mail<span class="required">*</span></label>
                                            <input id="mobile" name="username" type="text" placeholder="Login with Mobile or E-mail" class="form-control input-md " required>
                                        </div>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="control-label" for="password">Password<span class="required">*</span></label>
                                            <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" required>
                                        </div>
                                        <!-- Button -->
                                        <div class="form-group top-margin ">
                                            <button id="uLogin" type="submit" name="uLogin" class="btn btn-warning ">Login</button>
                                            <div class="top-margin">
                                                <a data-toggle="modal" data-target="#enterEmail" style="cursor:pointer;"> <small>Forgot Password ?</small></a>
                                                <a href="signup-couple.php" class="pull-right" style="cursor:pointer;"> <small>Don't have an account ?</small></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                            <p id="result"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="">
                            <p class="text-success hide" id="exists" style="padding: 6px 12px; border: 1px solid green">An updated password has been sent to your Email Address. Or A link has been sent to your Email Address, Follow that link to reset your password.</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="">
                            <p class="text-danger hide" id="dsntExist" style="padding: 6px 12px; border: 1px solid red">Please enter Email that is registered with us.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <!-- <a href="forget-password.php"></a> -->
                    <button type="button" id="sendLink" name="sendLink" class="btn btn-warning">Send link</button>
                    <!-- <button type="button" href="login-page.php" class="btn btn-success">Go Back</button> -->
                </div>
            </div>
        </div>
    </div>

    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flex Nav Script -->
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/navigation.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script>
        $('#sendLink').on('click', function() {
            var email_val = $('#email').val();
            if (email_val) {
                $.ajax({
                    url: 'reset_password.php',
                    type: "POST",
                    data: {
                        email_val: email_val,
                        flag: 1
                    },
                    cache: false,
                    beforeSend: function() {
                        $("#overlay").fadeIn(300);
                    },
                    success: function(result) {
                        if (result == 0) {
                            $("#email").val('');
                            $("#exists").addClass("hide");
                            return false;
                        } else if (result == 1) {
                            $("#email").val('');
                            $("#exists").removeClass("hide");
                            return true;
                        }
                    }
                }).done(function() {
                    setTimeout(function() {
                        $("#overlay").fadeOut(300);
                    }, 500);
                });
            }
        });
        $('#email').on('change', function() {
            var email_val = this.value;
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if (!re) {
                $("#email").val('');
                $("#result").html("<span style=color:red>Email address must be valid</span>");
                return false;
            } else {
                $.ajax({
                    url: 'registration_validation.php',
                    type: "POST",
                    data: {
                        email_val: email_val,
                    },
                    cache: false,
                    success: function(result) {
                        if (result == 0) {
                            $("#email").val('');
                            $("#dsntExist").removeClass("hide");
                            // $("#result").html("<span style=color:red>Email address does not exist in system</span>");
                            return false;
                        } else if (result == 1) {
                            $("#dsntExist").addClass("hide");
                            // $("#result").html("");
                            return true;
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>