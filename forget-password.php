<?php
include "dbconn.php";
if (isset($_POST['reset'])) {
    $mail = $_POST['email'];
    $psswd = $_POST['psswd'];
    $cnfPsswd = $_POST['cnfPsswd'];
    $sql = mysqli_query($conn, "SELECT * FROM `user_regiter` where `email`='$mail' ");
    $row = mysqli_fetch_array($sql);
    if ($sql) {
        if ($row['email'] == $mail) {
            $updt = mysqli_query($conn, "UPDATE `user_regiter` SET `password` = '$psswd'");
            if ($updt) {
                echo "alert('You can now login with your new password');";
            } else {
                echo "alert('There was a Problem, Please try again');";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DevyogVivah | Matrimony</title>
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
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="reg_bg">
    <div class="collapse" id="searcharea">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn tp-btn-primary" type="button">Search</button>
            </span>
        </div>
    </div>
    <!-- <div class="tp-page-head"> -->
    <!-- page header -->
    <!-- <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle">
                            <i class="icon icon-size-60 icon-padlock-1 icon-white"></i>
                        </div>
                        <h1>Forgot your password?</h1>
                        <p>Have you forgotten your password? Please provide the email address you signed up with and we will send you a link to reset it.</p>
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
                        <li class="active">Forget Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container" style="padding-top: 10rem;">
            <!-- <div class="col-md-offset-3 col-md-6 well-box"> -->
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
                                    <img src="images/logo.png" width="50%" alt="">
                                </div>
                                <div class="mt30">
                                    <h1 class="text-center mt30">Reset Password</h1>
                                    <!-- <h1 class="h4 text-center text-gray-900 mb-2">Forgot Your Password?</h1> -->
                                        <!-- <p class="mb-4 text-center">We get it, stuff happens. Just enter your email address below -->
                                            <!-- and we'll send you a link to reset your password!</p> -->
                                    <form action="" method="post" class="">
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="control-label" for="email">E-mail</label>
                                            <input id="email" name="email" type="text" placeholder="E-Mail" class="form-control input-md" value="" required>
                                        </div>
                                        <div class="form-group"  id="psswdhide" >
                                            <label class="control-label" for="email">Password</label>
                                            <input id="psswd" name="psswd" type="" class="form-control input-md" required>
                                        </div>
                                        <div class="form-group"  id="cnfpsswdhide" >
                                            <label class="control-label" for="email">Confirm Password</label>
                                            <input id="cnfPsswd" name="cnfPsswd" type="" class="form-control input-md" required>
                                        </div>

                                        <div class="form-group top-margin">
                                            </a><button id="reset" name="reset" type="submit" class="btn btn-primary">Reset Password</button>
                                        </div>
                                        <div class="top-margin">
                                            <a href="login-page.php" class=""> <small>Login to your Account ?</small></a>
                                            <a href="signup-couple.php" class="pull-right"> <small>Don't have Account ?</small></a>
                                        </div>
                                    </form>
                                    <!-- Nav tabs -->
                                    <!-- Tab panes -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            //     $("#item").hide();
            // $("#item").show();
        </script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Flex Nav Script -->
        <script src="js/jquery.flexnav.js" type="text/javascript"></script>
        <script src="js/navigation.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/header-sticky.js"></script>
</body>

</html>