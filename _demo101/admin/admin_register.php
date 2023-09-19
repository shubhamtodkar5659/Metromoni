<?php
require_once 'load.php';
connect_db();
global $db;
include('admin_header.php');

if (isset($_POST['ad_register'])) :
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password =  md5($_POST['password']);

    $insert_query = "INSERT INTO `admin`( `name`, `email`, `mobile`, `password`) VALUES ('$name','$email','$mobile','$password')";
    $result = $db->query($insert_query);
    $success = $result['success'];

    if ($success) :
?>
        <script>
            setTimeout(function() {
                swal({
                    title: "Success",
                    text: "Admin Registered successfully",
                    icon: "success",
                    buttons: true,
                    //dangerMode: true,
                })
            }, 1000);
            setTimeout(function() {
                window.location.href = "index.php";
            }, 7000);
        </script>
    <?php else : ?>
        <script>
            setTimeout(function() {
                swal({
                    title: "Oops...",
                    text: "Admin could Not be Register",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
            }, 1000);
            setTimeout(function() {
                window.location.href = "admin_register.php";
            }, 3000);
        </script>
<?php
    endif;
endif;

?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <!-- <div class="card-body p-0"> -->
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block">
                    <img class=" login-img-logo" src="../images/login_mg.png" alt="">
                     
                </div>
                <div class="col-lg-6">

                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form method="POST" action="" class="user">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="InputEmail">Full Name<span class="text-danger">*</span></label>

                                    <input name="name" type="text" class="form-control form-control-user" id="name" placeholder="Full Name" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="InputEmail">E-Mail<span class="text-danger">*</span></label>

                                    <input name="email" type="email" class="form-control form-control-user" id="email" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="InputEmail">Mobile<span class="text-danger">*</span></label>

                                <input name="mobile" type="tel" class="form-control form-control-user numeric" id="mobile" placeholder="Mobile" required>
                            </div>
                            <div class="form-group">
                                <!-- <div class="col-sm-6 mb-3 mb-sm-0"> -->
                                <label for="InputPassword">Password<span class="text-danger">*</span></label>

                                <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                                <!-- </div> -->
                                <!-- <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div> -->
                            </div>
                            <p id="onchangeerr"></p>
                            <button type="submit" name="ad_register" href="index.php" class="btn btn-primary btn-user btn-block" id="submitbtn">Register Account</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="index.php">Already have an account? Login!</a>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g, '');
        });


        $('#mobile').on('change', function() {
            var phone_val = this.value;
            if (this.value.length < 10) {
                $("#phone").val('');
                $("#onchangeerr").html("<span style=color:red>Phone number must have 10 digit</span>");
                return false;
            } else if (this.value.length == 10) {
                $.ajax({
                    url: 'admin_registration_validation.php',
                    type: "POST",
                    data: {
                        phone_val: phone_val,
                    },
                    cache: false,
                    success: function(result) {
                        if (result == 1) {
                            $("#phone").val('');
                            $("#onchangeerr").html("<span style=color:red>Mobile number already exist</span>");
                            return false;
                        } else if (result == 0) {
                            $("#onchangeerr").html("");
                            return true;
                        }
                    }
                });
            }
        });

        $('#email').on('change', function() {
            var email_val = this.value;
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if (!re) {
                $("#email").val('');
                $("#onchangeerr").html("<span style=color:red>Email address must be valid</span>");
                return false;
            } else {
                $("#onchangeerr").html("");
                $.ajax({
                    url: 'admin_registration_validation.php',
                    type: "POST",
                    data: {
                        email_val: email_val,
                    },
                    cache: false,
                    success: function(result) {
                        // console.log(result)
                        if (result == 1) {
                            $("#email").val('');
                            $("#onchangeerr").html("<span style=color:red>Email address already exist</span>");
                            return false;
                        } else if (result == 0) {
                            $("#onchangeerr").html("");
                            return true;
                        }
                    }
                });

            }
        });
    </script>
    <?php include('admin_footer.php'); ?>