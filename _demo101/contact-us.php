<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include 'dbconn.php';
require_once 'include/class-Emailer.php';

if (isset($_POST['contact'])) {
    $name = $_POST['first'];
    $mail = $_POST['email'];
    $phone = $_POST['phone'];
    $msg = $_POST['message'];
    $ins = mysqli_query($conn, "INSERT INTO `inquiry`(`name`, `email`, `phone`, `message`) VALUES ('$name','$mail','$phone','$msg')");
    if ($ins) {
        $body_text = 'Thank you for contacting us';
        $mail_obj = new Emailer();
        $data_var = $mail_obj->send_email('Contact us', $body_text, $mail, 'renukakul93@gmail.com', '');
        // echo $data_var; die;
        if ($data_var === 1) {
?>
            <script>
                // alert('Your message sent successully , Thankyou for contacting us');
                swal({
                    title: "Great",
                    text: "Your message sent successully , Thankyou for contacting us",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                })
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            swal({
                title: "Oops...",
                text: "There was a problem, Please try again",
                icon: "error",
                buttons: true,
                dangerMode: true,
            })
        </script>
<?php }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DevyogVivah | Matrimony for Doctors</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">
</head>

<body>
    <?php
    include 'mainHeader.php';
    ?>
    <!-- /.page header -->
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Contact us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container ">
        <div class="container">
            <div class="row mb30">
                <div class="col-md-6">
                    <div class="well-box shadow boxdight" style="background: #fff;
    padding: 36px;
}">
                        <p>Please fill out the form below and we will get back to you as soon as possible.</p>
                        <form id="contactus" method="POST">
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="control-label" for="first">Full Name <span class="required">*</span></label>
                                <input id="first" name="first" type="text" placeholder="Full Name" class="form-control input-md" required>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class=" control-label" for="email">E-Mail <span class="required">*</span></label>
                                <input id="email" name="email" type="text" placeholder="E-Mail" class="form-control input-md" required>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class=" control-label" for="phone">Phone <span class="required">*</span></label>
                                <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control input-md numeric" required>
                            </div>
                            <!-- Textarea -->
                            <div class="form-group">
                                <label class="  control-label" for="message">Message</label>
                                <textarea class="form-control" rows="6" id="message" name="message" placeholder="Write Your Message"></textarea>
                            </div>
                            <div class="err_div">
                            </div>
                            <!-- Button -->
                            <div class="form-group">
                                <button id="submit" name="contact" type="submit" class="btn btn-primary btn-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 contact-info">
                    <div class="well-box   shadow">
                        <ul class="listnone">
                            <li class="email">
                                <h2><i class="fa fa-envelope"></i>E-Mail</h2>
                                <p>Info@DevyogVivah.com</p>
                            </li>
                            <li class="call">
                                <h2><i class="fa fa-phone"></i>Contact</h2>
                                <p>+91 9873458974</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="well-box shadow">
                        <h2>Need Help ?</h2>
                        <p>DevyogVivah's team is always there to support you, New here, got doubts and queries? Don't Worry find all your answers right here.</p>
                        <p>We build Templates that are rich in content and have a good user interface to deliver a premium user experience for your customers.</p>

                    </div>
                </div>
          
            </div>
        </div>
    </div>
    
    </div>
    
    <div class="forcontactb">
     <?php
    include 'footer.php';
    ?>
    </div>
    
    
    
    <!-- <div class="map mb30" id=""><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3752.125897685637!2d75.36213586491368!3d19.87690508663353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bdba29337d1b167%3A0x50820e6a55898416!2sCIDCO%20Cannought%2C%20M%20G%20M%2C%20Aurangabad%2C%20Maharashtra%20431003!5e0!3m2!1sen!2sin!4v1662358831343!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div> -->
   <!--footer -->
   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flex Nav Script -->
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/navigation.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>

    <script>
        var myCenter = new google.maps.LatLng(23.0203458, 72.5797426);

        function initialize() {
            var mapProp = {
                center: myCenter,
                zoom: 9,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            var marker = new google.maps.Marker({
                position: myCenter,
                icon: 'images/pinkball.png'
            });
            marker.setMap(map);
            var infowindow = new google.maps.InfoWindow({
                content: "Hello Address"
            });
        }
        //google.maps.event.addDomListener(window, 'load', initialize);



        $('#submit').on('click', function() {
            var flag = 0;
            if ($('#first').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Full name is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#email').val() == '') {
                swal({
                    title: "Oops...",
                    text: "E-Mail is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#email').val() != '') {
                //val_flag2 = validateEmail($('#email').val());
                // Enter valid email format
                var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test($('#email').val());
                if (!re) {
                    swal({
                        title: "Oops...",
                        text: "Enter valid email format",
                        icon: "error",
                        buttons: true,
                        dangerMode: true,
                    })
                    flag = 1;
                } else {
                    flag = 0;
                }
            } else if ($('#phone').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Phone  is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#phone').val() != '') {
                val = $('#phone').val();
                if (val.length < 10) {
                    swal({
                        title: "Oops...",
                        text: "Enter 10 digit number",
                        icon: "error",
                        buttons: true,
                        dangerMode: true,
                    })
                    flag = 1;
                } else if (val.length > 10) {
                    swal({
                        title: "Oops...",
                        text: "Enter 10 digit number",
                        icon: "error",
                        buttons: true,
                        dangerMode: true,
                    })
                    flag = 1;
                } else if (val.length == 10) {
                    flag = 0;
                }
            }
            if (flag === 0) {
                // var val_flag1 = true;
                // var val_flag2 = true;
                // var val_flag3 = true;
                // val_flag1 = validateName($('#first').val());
                // val_flag2 = validateEmail($('#email').val());
                // val_flag3 = validatePhone($('#phone').val());
                // if (val_flag1 == true && val_flag2 == true && val_flag3 == true)
                document.getElementById('contactus').submit();
                // else
                //     return false;
                // return true;
            } else if (flag === 1) {
                return false;
            }
        });

        function validateEmail(val) {
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(val);
            if (!re) {

                $(".err_div").html(" <span style='font-weight: 400;color:red;'>Enter valid email format </span>");
                return false;
            } else {
                $(".err_div").html("");
                return true;
            }
        }

        function validatePhone(val) {
            val = val.replace(/\D/g, '');
            if (val.length < 10) {
                $(".err_div").html(" <span style='font-weight: 400;color:red;'>Enter 10 digit number </span>");
                return false;
            } else if (val.length > 10) {
                $(".err_div").html(" <span style='font-weight: 400;color:red;'>Enter 10 digit number </span>");
                return false;
            } else if (val.length == 10) {
                $(".err_div").html("");
                return true;
            }
        }

        function validateName(val) {
            if (val.length < 5) {
                $(".err_div").html(" <span style='font-weight: 400;color:red;'>Enter valid name </span>");
                return false;
            } else {
                $(".err_div").html("");
                return true;
            }
        }
        $('#email').on('keyup', function() {
            validateEmail(this.value);
        });
        $(document).on("input", ".numeric", function() {
            validatePhone($('#phone').val());
        });
        // $(document).on("input", "#first", function() {
        //     validatePhone($('#first').val());
        // });
    </script>
</body>

</html>