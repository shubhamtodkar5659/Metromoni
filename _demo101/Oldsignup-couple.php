<?php

include 'dbconn.php';
require_once 'include/class-Emailer.php';
$mail_obj = new Emailer();
if (isset($_POST['u_register'])) {
    $name = ucwords($_POST['name']);
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $non_md5_pwd = $_POST['password'];
    $password = md5($_POST['password']);
    $country = ucwords($_POST['country']);
    $state = ucfirst($_POST['state']);
    $city = ucfirst($_POST['city']);
    $address = ucfirst($_POST['address']);
    $marStat = $_POST['marStat'];
    $uLang = $_POST['lang'];
    $uDiet = $_POST['diet'];
    $uHeight = $_POST['height'];
    $uReligion = $_POST['religion'];
    $uSubCom = ucfirst($_POST['sub-com']);
    if (isset($_POST['community'])) {
        $communityCheckbox = $_POST['community'];
    } else {
        $communityCheckbox = "";
    }
    $HEduSearch = $_POST['HEduSearch'];
    $uCollage = ucwords($_POST['collage']);
    $profile_for = $_POST['profile_for'];
    $uProfession = $_POST['Prof'];
    $uSpecialization = $_POST['Specialization'];
    $uIncome = $_POST['income'];
    $uLiveWithFamily = $_POST['yes/no'];
    $uBloodGrp = $_POST['bGrp'];
    $uBdate = $_POST['bDate'];
    $uAge = $_POST['age'];
    $uGender = $_POST['gender'];
    $uBtime = $_POST['bTime'];
    $uBlocation = $_POST['bLocation'];
    $uBio = ucfirst($_POST['bio']);
    $filename = $_FILES["userImg"]["name"];
    $tempname = $_FILES["userImg"]["tmp_name"];
    $folder = "user_image/" . $filename;

    $date = date('Y-m-d');
    $days =  30;
    $expiry = date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
    $check = mysqli_query($conn, "SELECT * FROM `states` WHERE `id` = '$state' ");
    $count = mysqli_num_rows($check);
    if ($count > 0) {
        $sql1 = "INSERT INTO `user_regiter`(`name`,profile_for, `email`, `phone`, `password`, `country`, `state`, `city`, `address`, `marStat`, `lang`, `diet`, `height`, `religion`, `sub-com`, `community-checkbox`, `HighEdu`, `collage`, `prof`, `specialization`, `income`, `yes/no`, `bGrp`, `bDate`, `age`, `gender`, `bTime`, `bLocation`, `filename`,`bio`,`plan_expiry_date`, `status`) 
        VALUES ('$name','$profile_for','$email','$phone','$password','$country','$state','$city','$address','$marStat','$uLang','$uDiet','$uHeight','$uReligion','$uSubCom','$communityCheckbox','$HEduSearch','$uCollage','$uProfession','$uSpecialization','$uIncome','$uLiveWithFamily','$uBloodGrp','$uBdate','$uAge','$uGender','$uBtime','$uBlocation','$filename','$uBio','$expiry','1')";

        if (mysqli_query($conn, $sql1)) {
            $user_body = "Hi $name, <br> You are successfully registered to the system. <br> Username: $email <br> Password: $non_md5_pwd ";
            $mail_obj->send_email('Welcome !!! ', $user_body, $email, '', '');
            if (move_uploaded_file($tempname, $folder)) {
                echo '<script>                
                        swal({
                             title: "Oops...",
                             text: "Image uploaded successfully",
                             icon: "error",
                             buttons: true,
                             dangerMode: true,
                         })</script>';
                echo '<script>window.location.href = "login-page.php";</script>';
            } else {
                echo '<script>                
                        swal({
                             title: "Oops...",
                             text: "Image not uploaded",
                             icon: "error",
                             buttons: true,
                             dangerMode: true,
                         })</script>';
                echo '<script> window.location.href = "login-page.php";</script>';
            }
        } else {
            echo '<script>                        
            swal({
                title: "Oops...",
                text: "User registration failed",
                icon: "error",
                buttons: true,
                dangerMode: true,
            })
            </script>';
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
    <title>DevyogVivah | Matrimony for Doctors</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fontello.css">
    <!-- jquery ui CSS -->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">
    <!-- codepen links -->
    <!--/---------step wizard----------- -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="tp-breadcrumb" style="background-color: #fdfdf8;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Sign-up Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- steeper section   -->
    <section class="signup-step-container  mt50 reg_bg">
        <div class="container">
            <div class="row d-flex justify-content-center pt40 shadow" style="background-color: white;padding-bottom:3%; border-radius: 10px">
                <div class="col-md-8  ">
                    <div class="wizard ">
                        <div class="wizard-inner pt50">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Step 1</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Step 2</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>Step 3</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i>Step 4</i></a>
                                </li>
                            </ul>
                        </div>
                        <form method="post" role="form" action="" class="login-box" enctype="multipart/form-data">
                            <div class="tab-content" id="main_form">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label> This Profile is for <span class="required">*</span></label>
                                                <select name="profile_for" class="form-control select" id="profile_for">
                                                    <option value="">Select Profile For</option>
                                                    <option value="Myself">Myself</option>
                                                    <option value="My Son">My Son</option>
                                                    <option value="My Daughter">My Daughter</option>
                                                    <option value="My Brother">My Brother</option>
                                                    <option value="My Sister">My Sister</option>
                                                    <option value="My Friend">My Friend</option>
                                                    <option value="My Relative">My Relative</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Your Name <span class="required">*</span></label>
                                                <input class="form-control" type="text" id="username" name="name" placeholder="Enter your Full Name" required>
                                                <p id="name"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number <span class="required">*</span></label>
                                                <input class="form-control numeric" maxlength="10" type="text" id="phone" name="phone" placeholder="Enter your Valid Mobile Number" required>
                                                <p id="phone"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email Address <span class="required">*</span></label>
                                                <input class="form-control" type="email" id="email" name="email" placeholder="Enter a Valid E-mail" required>
                                                <!-- <p id="result"></p> -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password <span class="required">*</span></label>
                                                <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password between Length of 6 to 8 Character" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Your country <span class="required">*</span></label>
                                                <select name="country" class="form-control select" onchange="getState(this.value);" type="text" id="country" placeholder="Select country first">
                                                    <?php
                                                    $sql1 = "SELECT * FROM countries WHERE is_active = 1  ";
                                                    $result = mysqli_query($conn, $sql1);
                                                    ?>
                                                    <option value="">Select Country</option>

                                                    <?php while ($row = mysqli_fetch_array($result)) : ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Your State <span class="required">*</span></label>
                                                <!-- <input class="form-control select" type="text" onchange="getCity(this.value)" id="state" list="statename" name="state" placeholder="Select State first"> -->
                                                <select class="form-control select" id="state" name="state" placeholder="Select State first" onchange="getCity(this.value)">
                                                    <?php
                                                    $sql2 = "SELECT * FROM states WHERE is_active = 1  ";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    ?>
                                                    <option value="">Select State</option>
                                                    <?php while ($row = mysqli_fetch_array($result2)) : ?>
                                                        <option value="<?php echo $row['id'] ?>"> <?php echo $row['name']; ?> </option>
                                                    <?php endwhile; ?>

                                                </select>

                                                <!-- </input> -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Your city <span class="required">*</span></label>
                                                <select class="form-control select" id="city" name="city" placeholder="Select City first">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address </label>
                                                <input class="form-control" type="text" id="address" name="address" placeholder="Enter your Address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Gender <span class="required">*</span></label>
                                            <div class="form-group  mt-10">
                                                <label class="mt-5" for="female">
                                                    <span>Female</span>
                                                    <input class="form-control input_sex" id="gender_m" type="radio" name="gender" value="Female" />
                                                </label>
                                                <label class="mt-5" for="male">
                                                    <span>Male</span>
                                                    <input class="form-control input_sex" id="gender_f" type="radio" name="gender" value="Male" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <p id="onchangeerr"></p>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" id="cont1" class="default-btn next-step">Continue </button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Marital Status <span class="required">*</span></label>
                                                <select name="marStat" class="form-control select" id="marStat">
                                                    <option value="">Select Marital Status</option>
                                                    <option value="Never married">Never married</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="">Mother Tongue <span class="required">*</span></label>
                                                <input class="form-control" type="text" id="lang" name="lang" placeholder="Enter your Mother tongue">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diet</label>
                                                <select name="diet" class="form-control select" id="diet">
                                                    <option value="">Select Diet</option>
                                                    <option value="Veg">Veg</option>
                                                    <option value="Non-Neg">Non-Neg</option>
                                                    <option value="Occasionally Non-Veg">Occasionally Non-Veg</option>
                                                    <option value="Eggetarian">Eggetarian</option>
                                                    <option value="Jain">Jain</option>
                                                    <option value="Vegan">Vegan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Height <span class="required">*</span></label>
                                                <input class="form-control" onkeypress="return float_validation(event, this.value)" type="text" id="height" name="height" placeholder="Enter height in feet" autofocus pattern="^\d+\.{0,1}\d{0,2}$" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Religion<span class="required">*</span> </label>
                                                <select name="religion" class="form-control select" id="religion">
                                                    <option value="">Select Religion</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Jain">Jain</option>
                                                    <option value="Sikh">Sikh</option>
                                                    <option value="Buddhist">Buddhist</option>
                                                    <option value="Christian">Christian</option>
                                                    <option value="Parsi">Parsi</option>
                                                    <option value="Bohra">Bohra</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Atheism_Agnosticism">Atheism/Agnosticism</option>
                                                    <option value="Confucianism">Confucianism</option>
                                                    <option value="Druze">Druze</option>
                                                    <option value="Gnosticism">Gnosticism</option>
                                                    <option value="Judaism">Judaism</option>
                                                    <option value="Rastafarianism">Rastafarianism</option>
                                                    <option value="Shinto">Shinto</option>
                                                    <option value="Zoroastrianism">Zoroastrianism</option>
                                                    <option value="Indigenous American Religions">Indigenous American Religions</option>
                                                    <option value="Traditional African Religions">Traditional African Religions</option>
                                                    <option value="African Diaspora Religions">African Diaspora Religions</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sub Community <span class="required">*</span></label>
                                                <input class="form-control" type="text" id="sub-com" name="sub-com" placeholder="eg. Maratha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comm-checkbx">
                                        <input type="checkbox" name="community" id="communityCheckbox" value="I am not particular about my Partners Community">I am not particular about my Partners Community
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step skip-btn">Back</button>
                                        </li>
                                        <!-- <li><button type="button" class="default-btn next-step skip-btn">Skip</button>
                                        </li> -->
                                        <li><button type="button" id="cont2" class="default-btn next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Highest Education </label>
                                                <select name="HEduSearch" class="form-control select" id="HEduSearch">
                                                    <option value="">Select Highest Education</option>
                                                    <?php
                                                    $sql_higher_education = "SELECT * FROM `higher_education` where is_active = 1";
                                                    $res_higher_education = mysqli_query($conn, $sql_higher_education);
                                                    ?>
                                                    <?php while ($row = mysqli_fetch_array($res_higher_education)) : ?>
                                                        <?php $name = $row['name']; ?>
                                                        <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Collage</label>
                                                <input class="form-control" type="text" id="collage" name="collage" placeholder=" Enter your Collage Name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profession </label>
                                                <select name="Prof" class="form-control select" id="Prof">
                                                    <option value="">Select Profession</option>
                                                    <option value="Studying">Studying</option>
                                                    <option value="Studying & Practicing Doctor">Studying & Practicing Doctor</option>
                                                    <option value="Attached with Hospital Or Senior Doctor">Attached with Hospital Or Senior Doctor
                                                    </option>
                                                    <option value="Private Practice">Private Practice</option>
                                                    <option value="Own Family Hospital">Own / Family Hospital</option>
                                                    <option value="Service with Govt">Service with Govt</option>
                                                    <option value="Armed Forces">Armed Forces</option>
                                                    <option value="Research">Research</option>
                                                    <option value="other">other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Specialization </label>
                                                <input class="form-control" type="text" name="Specialization" id="Specialization">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Income (yearly)</label>
                                                <input class="form-control " onkeypress="return float_validation(event, this.value)" type="text" id="income" name="income" placeholder="You can change the settings & select who can view.">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Do You Live With your Family </label>
                                                <div class="form-group">
                                                    <p>
                                                        <input type="radio" id="yes" name="yes/no" value="Yes" checked>Yes</input>
                                                        <input type="radio" id="no" name="yes/no" value="No">No</input>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step skip-btn">Back</button>
                                        </li>
                                        <!-- <li><button type="button" class="default-btn next-step skip-btn">Skip</button>
                                        </li> -->
                                        <li><button type="button" id="cont3" class="default-btn next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step4">
                                    <div class="row"></div>
                                    <div class="all-info-container">
                                        <h2 class="text-center">Almost Done!</h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Your Blood Group </label>
                                                    <select name="bGrp" class="form-control select" id="BGrp">
                                                        <option value="A+">A+</option>
                                                        <option value="A-">A-</option>
                                                        <option value="B+">B+</option>
                                                        <option value="B-">B-</option>
                                                        <option value="O+">O+</option>
                                                        <option value="O-">O-</option>
                                                        <option value="AB+">AB+</option>
                                                        <option value="AB-">AB-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Birth Date<span class="required">*</span></label>
                                                    <input class="form-control" onchange="getAge(this.value)" type="date" name="bDate" placeholder="Enter your Birth Date" id="bDay">
                                                </div>
                                            </div>
                                            <div class="col-md-6" hidden>
                                                <div class="form-group">
                                                    <!-- <label>Age</label> -->
                                                    <input class="form-control" type="hidden" name="age" id="age">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Birth Time</label>
                                                    <input class="form-control" type="time" name="bTime" placeholder="Enter your Birth Time" id="bTime">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Birth Location</label>
                                                    <input class="form-control" type="text" name="bLocation" id="bLocation" placeholder="city, state">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class=" mb-3">
                                                        <label>Image </label>
                                                        <img src="./images/download.png" style="float: right;" width="100px" alt="">
                                                        <input type="file" class="form-control" name="userImg" id="userimage" accept="image/png, image/gif, image/jpeg">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="userBio">Enter something about your-self.</label>
                                                    <textarea class="form-control" name="bio" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step skip-btn">Back</button>
                                        </li>
                                        <li><button type="submit" name="u_register" id="submitbtn" class="default-btn next-step">Finish</button></li>
                                    </ul>
                                </div>
                                <div class="clearfix">
                                    <a class="fixed_clearfix" href="login-page.php"> <small class="pt40">Already have an account ?</small></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="js/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flex Nav Script -->
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/navigation.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- <script type="text/javascript" src="../../../code.jquery.com/ui/1.12.0/jquery-ui.js"></script> -->
    <!-- <script src="js/date-script.js"></script> -->
    <!------------------ form validation script ----------------------->


    <!-------------------------steeper section js -------step-wizard----------------------------->
    <script>
        function validateFormFields() {
            var flag = 0;

            if ($('#profile_for').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Profile for is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#username').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Your name is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#phone').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Phone number is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#email').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Email address is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#password').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Password is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1; 
            } else if ($('#country').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Country is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($("#state").val() == '') {
                var state_val = $("#state").val();
                var state_obj = $("#statename").find("option[value='" + state_val + "']");
                console.log(state_val);
                if (state_obj != null && state_obj.length > 0) {
                    return true;
                } else {
                    swal({
                        title: "Oops...",
                        text: "State is required",
                        icon: "error",
                        buttons: true,
                        dangerMode: true,
                    })
                    flag = 1;
                }
            } else if ($('#city').val() == '') {
                swal({
                    title: "Oops...",
                    text: "City is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('input[name="gender"]:checked').length == 0) {
                swal({
                    title: "Oops...",
                    text: "Gender is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            }
            return flag;
        }

        function validateForm2Fields() {
            var flag = 0;
            if ($('#marStat').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Marital Status is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#lang').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Mother Tongue is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#height').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Height is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#religion').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Religion is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            } else if ($('#sub-com').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Sub Community is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            }
            return flag;
        }

        function validateForm3Fields() {
            var flag = 0;
            // if ($('#Specialization').val() == '') {
            //     swal({
            //         title: "Oops...",
            //         text: "Specialization is required",
            //         icon: "error",
            //         buttons: true,
            //         dangerMode: true,
            //     })
            //     flag = 1;
            // }
            return flag;
        }

        function validateForm4Fields() {
            var flag = 0;
            if ($('#bDay').val() == '') {
                swal({
                    title: "Oops...",
                    text: "Birth Date is required",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                flag = 1;
            }
            return flag;
        }
        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g, '');
        });


        $('#phone').on('change', function() {
            var phone_val = this.value;
            if (this.value.length < 10) {
                $("#phone").val('');
                $("#onchangeerr").html("<span style=color:red>Phone number must have 10 digit</span>");
                return false;
            } else if (this.value.length == 10) {
                $.ajax({
                    url: 'registration_validation.php',
                    type: "POST",
                    data: {
                        phone_val: phone_val,
                    },
                    cache: false,
                    success: function(result) {
                        if (result == 1) {
                            $("#phone").val('');
                            $("#onchangeerr").html("<span style=color:red>Phone number already exist</span>");
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
                $.ajax({
                    url: 'registration_validation.php',
                    type: "POST",
                    data: {
                        email_val: email_val,
                    },
                    cache: false,
                    success: function(result) {
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

        function float_validation(event, value) {
            if (event.which < 45 || event.which > 58 || event.which == 47) {
                return false;
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46 && value.indexOf('.') != -1) {
                return false;
                event.preventDefault();
            } // prevent if already dot

            if (event.which == 45 && value.indexOf('-') != -1) {
                return false;
                event.preventDefault();
            } // prevent if already dot

            if (event.which == 45 && value.length > 0) {
                event.preventDefault();
            } // prevent if already -

            return true;

        };
        $(document).ready(function() {
            // $("#btn_continue").hide();
            $('.nav-tabs > li a[title]').tooltip();
            //Wizard
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target);
                if (target.parent().hasClass('disabled')) {
                    return false;
                }
            });
            $(".next-step").click(function(e) {
                var btn_id = this.id;
                var flag = '';
                if (btn_id == 'cont1')
                    flag = validateFormFields();
                else if (btn_id == 'cont2')
                    flag = validateForm2Fields();
                else if (btn_id == 'cont3')
                    flag = validateForm3Fields();
                else if (btn_id == 'submitbtn')
                    flag = validateForm4Fields();
                if (flag == 0) {
                    var active = $('.wizard .nav-tabs li.active');
                    active.next().removeClass('disabled');
                    nextTab(active);
                } else {
                    return false;
                }
            });
            $(".prev-step").click(function(e) {
                var active = $('.wizard .nav-tabs li.active');
                prevTab(active);
            });
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }
        $('.nav-tabs').on('click', 'li', function() {
            $('.nav-tabs li.active').removeClass('active');
            $(this).addClass('active');
        });

        //  age calculator 

        function getAge() {
            var dob = document.getElementById('bDay').value;
            var start_date = new Date(dob);
            var date = new Date();
            var end_date = new Date(start_date);
            end_date.setFullYear(date.getFullYear() - start_date.getFullYear());
            $("#age").val(end_date.getFullYear());
        }

        function getState(id) {
            $.ajax({
                url: 'state.php',
                type: "POST",
                data: {
                    country_id: id,
                    country_value: 'country'
                },
                cache: false,
                success: function(result) {
                    // console.log(result);
                    $('#state').html(result);
                }
            });
        }

        function getCity(sid) {
            $.ajax({
                url: 'state.php',
                type: "POST",
                data: {
                    state_id: sid,
                    state_value: 'state'
                },
                cache: false,
                success: function(result2) {
                    // console.log(result2);
                    $('#city').html(result2);
                }
            })
        }
    </script>

</body>

</html>