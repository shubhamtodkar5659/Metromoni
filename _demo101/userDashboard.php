<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
include 'dbconn.php';
$user_id = $_SESSION['id'];
$q = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE  `id` = 'user_id' ");
$r = mysqli_fetch_array($q);

if (isset($user_id)):

  if (isset($_POST['updateProfile'])):

    $profile_for = $_POST['profile_for'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $marStat = $_POST['marStat'];
    $uLang = $_POST['lang'];
    $uDiet = $_POST['diet'];
    $uHeight = $_POST['height'];
    $uReligion = $_POST['religion'];
    $uSubCom = $_POST['sub-com'];
    if (isset($_POST['community'])) {
      $communityCheckbox = $_POST['community'];
    } else {
      $communityCheckbox = "";
    }
    $HEduSearch = $_POST['HEduSearch'];
    $uCollage = $_POST['collage'];
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
    $uBio = $_POST['bio'];
    $filename1 = $_POST["userImg1"];
    $filename = $_FILES["userImg"]["name"];
    $tempname = $_FILES["userImg"]["tmp_name"];
    $folder = "user_image/" . $filename;
    // echo $_FILES["userImg"]["name"];
    if (!empty($_FILES["userImg"]["name"])) {
      $sql_edit = "UPDATE `user_regiter` SET `name`='$name',`email`='$email',`phone`='$phone',`country`='$country',`state`='$state',`city`='$city',`address`='$address',`marStat`='$marStat',`lang`='$uLang',`diet`='$uDiet',`height`='$uHeight',`religion`='$uReligion',`sub-com`='$uSubCom',`community-checkbox`='$communityCheckbox',`HighEdu`='$HEduSearch',`collage`='$uCollage',`prof`='$uProfession',`specialization`='$uSpecialization',`income`='$uIncome',`yes/no`='$uLiveWithFamily',`bGrp`='$uBloodGrp',`bDate`='$uBdate',`age`='$uAge',`gender`='$uGender',`bTime`='$uBtime',`bLocation`='$uBlocation',`filename`='$filename',`bio`='$uBio' where `id`='$user_id'";
      $update_q = mysqli_query($conn, $sql_edit);
      if (move_uploaded_file($tempname, $folder)) {
        echo '<script>
                 //  alert("");
                setTimeout(function() {
                    swal({
                        title: "Great",
                        text: "Image has been uploaded successully",
                        icon: "success",
                        buttons: true,
                        dangerMode: true,
                    })
                }, 10);
                </script>';
        echo '<script>window.location.href = "userDashboard.php";</script>';
      } else {
        echo '<script>
                setTimeout(function() {
                    swal({
                        title: "Oops...",
                        text: "Image not uploaded",
                        icon: "error",
                        buttons: true,
                        dangerMode: true,
                    })
                }, 10);
                </script>';
        echo '<script> window.location.href = "userDashboard.php";</script>';
      }
    } else {
      $sql_edit = "UPDATE `user_regiter` SET profile_for='$profile_for',`name`='$name',`email`='$email',`phone`='$phone',`country`='$country',`state`='$state',`city`='$city',`address`='$address',`marStat`='$marStat',`lang`='$uLang',`diet`='$uDiet',`height`='$uHeight',`religion`='$uReligion',`sub-com`='$uSubCom',`community-checkbox`='$communityCheckbox',`HighEdu`='$HEduSearch',`collage`='$uCollage',`prof`='$uProfession',`specialization`='$uSpecialization',`income`='$uIncome',`yes/no`='$uLiveWithFamily',`bGrp`='$uBloodGrp',`bDate`='$uBdate',`age`='$uAge',`gender`='$uGender',`bTime`='$uBtime',`bLocation`='$uBlocation',`bio`='$uBio' where `id`='$user_id'";
      $update_q = mysqli_query($conn, $sql_edit);
      header("location:userDashboard.php");
    }
  endif;

  ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="description" content="">
                <meta name="author" content="">
                <title>My Dashboard</title>
                <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
                <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
                <link href="./admin/css/styleAdmin.css" rel="stylesheet">
                <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
                <!-- toggle text show less  -->
                <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

                <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">

        
                    <!-- Bootstrap core JavaScript-->
                    <script src="./admin/vendor/jquery/jquery.min.js"></script>
                    <script src="./admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <!-- Core plugin JavaScript-->
                    <script src="./admin/vendor/jquery-easing/jquery.easing.min.js"></script>
                    <!-- Custom scripts for all pages-->
                    <script src="./admin/js/sb-admin-2.min.js"></script>
            </head>

            <body id="page-top">
                <div id="wrapper">
                    <?php
                    include 'panelHeader.php';
                    ?>
                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">
                        <!-- Main Content -->
                        <div id="content">
                            <!-- Topbar -->
                            <?php
                            include 'toppanel.php';
                            ?>
                            <!-- End of Topbar -->
                            <?php
                            $user_sql = "SELECT * FROM `user_regiter` where `id` =  '$user_id' ";
                            $result = mysqli_query($conn, $user_sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                              $user_country = '';
                              $user_state = '';
                              $user_city = '';
                              $user_religion_name = '';
                              $countries = (isset($row['country'])) ? $row['country'] : 0;
                              $countriessql1 = "SELECT * FROM countries where `id` = " . $countries;
                              $countriesresultid = mysqli_query($conn, $countriessql1);
                              while ($rowid = mysqli_fetch_array($countriesresultid)):
                                $user_country = $rowid['name'];
                              endwhile;

                              $states = (isset($row['state'])) ? $row['state'] : 0;
                              $statesql1 = "SELECT * FROM states where `id` = " . $states;
                              $stateresultid = mysqli_query($conn, $statesql1);
                              while ($rowid = mysqli_fetch_array($stateresultid)):
                                $user_state = $rowid['name'];
                              endwhile;

                              $cities = (isset($row['city'])) ? $row['city'] : 0;
                              $citiessql1 = "SELECT * FROM cities where `id` = " . $cities;
                              $citiesresultid = mysqli_query($conn, $citiessql1);
                              while ($rowid = mysqli_fetch_array($citiesresultid)):
                                $user_city = $rowid['name'];
                              endwhile;

                              $user_religion = (isset($row['religion'])) ? $row['religion'] : 0;
                              $religion_sql = "SELECT * FROM religion where `id` = " . $user_religion;
                              $religion_result = mysqli_query($conn, $religion_sql);

                              if ($religion_result):
                                while ($religion_row = mysqli_fetch_array($religion_result)):
                                  $user_religion_name = $religion_row['name'];
                                endwhile;
                              endif;
                              $add = " " . ucfirst($user_city) . ", " . ucfirst($user_state) . ", " . ucfirst($user_country);
                              $today = date("Y-m-d");
                              $expiry = $row['plan_expiry_date'];
                              if (isset($_GET['demo'])) {
                                if ($expiry >= $today) {
                                  ?>
                                                                <script>
                                                                    window.onload = function() {
                                                                        $("#exampleModalCenter").modal();
                                                                    }
                                                                </script>
                                                        <?php
                                }
                              }
                              ?>
                                        <input id="testModalButton" type="hidden" value="Click here to execute JS script">
                                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Uh Oh!</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Your <?php echo $row['type_plan']; ?> Plan has expired , to take advantage of all the features please subscribe to our membership plan, Thankyou.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <a href="user_plan.php"><button type="button" class="btn btn-primary">Subcribe</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="container-fluid">
                                            <div id="new_profile" class=" row card shadow">
                                                <div class="card-header py-3" style="background-image: linear-gradient(289deg, #000000c7 0%, #000000 100%);
">
                                                    <h6 class="m-0 font-weight-bold text-white text-center">Profile</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-4">
                                                        <div class="text-center">
                                                            <img class="img-fluid px-3 px-sm-4 mt-2 mb-4" style="width: 21rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div id="personal_details_accordion">
                                                            <button class="btn collapsed" id="personal_details" type="button" data-toggle="collapse" data-target="#personal_details_div" aria-expanded="false" aria-controls="personal_details_div">
                                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                                <b>Personal Details</b>
                                                            </button>
                                                            <div id="personal_details_div" class="p-3 collapse show" aria-labelledby="personal_details_heading" data-parent="#personal_details_accordion">
                                                                <b class="bold_title">Profile For :</b> <?php echo $row['profile_for']; ?><br>
                                                                <b class="bold_title">Name :</b> <?php echo $row['name']; ?><br>
                                                                <b class="bold_title">Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                <b class="bold_title">Religion :</b> <?php echo $user_religion_name; ?><br>
                                                                <b class="bold_title">Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                                                <b class="bold_title">Diet :</b> <?php echo $row['diet']; ?><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div id="physical_details_accordion">
                                                            <button class="btn collapsed" id="physical_details" type="button" data-toggle="collapse" data-target="#physical_details_div" aria-expanded="false" aria-controls="physical_details_div">
                                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                                <b>Physical Details</b>
                                                            </button>
                                                            <div id="physical_details_div" class="p-3 collapse show" aria-labelledby="physical_details_heading" data-parent="#physical_details_accordion">
                                                                <b class="bold_title">Birth Date :</b> <?php echo $row['bDate']; ?><br>
                                                                <b class="bold_title">Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                                                <b class="bold_title">Birth Location :</b> <?php echo $row['bLocation']; ?><br>
                                                                <b class="bold_title">Age :</b> <?php echo $row['age']; ?><br>
                                                                <b class="bold_title">Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                                                <b class="bold_title">Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                <b class="bold_title">Height :</b> <?php echo $row['height']; ?><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                               
                                                <div class="row ">
                                                    <div class="col-12 col-sm-6">
                                                        <div id="education_details_accordion">
                                                            <button class="btn collapsed" id="education_details" type="button" data-toggle="collapse" data-target="#education_details_div" aria-expanded="false" aria-controls="education_details_div">
                                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                                <b>Education Details</b>
                                                            </button>
                                                            <div id="education_details_div" class="p-3 collapse show " aria-labelledby="education_details_heading" data-parent="#education_details_accordion">
                                                                <b class="bold_title">Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                <b class="bold_title">Collage :</b> <?php echo $row['collage']; ?><br>
                                                                <b class="bold_title">Specialization :</b> <?php echo $row['specialization']; ?><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                 
                                                    <div class="col-12 col-sm-6">
                                                        <div id="occupation_details_accordion">
                                                            <button class="btn collapsed" id="occupation_details" type="button" data-toggle="collapse" data-target="#occupation_details_div" aria-expanded="false" aria-controls="occupation_details_div">
                                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                                <b>Occupation Details</b>
                                                            </button>
                                                            <div id="occupation_details_div" class="p-3 collapse show" aria-labelledby="occupation_details_heading" data-parent="#occupation_details_accordion">
                                                                <b class="bold_title">Profession :</b> <?php echo $row['prof']; ?><br>
                                                                <b class="bold_title">Income :</b> <?php echo $row['income']; ?><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                              
                                                <div class="row ">
                                                    <div class="col-12 col-sm-6">
                                                        <div id="family_details_accordion">
                                                            <button class="btn collapsed" id="family_details" type="button" data-toggle="collapse" data-target="#family_details_div" aria-expanded="false" aria-controls="family_details_div">
                                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                                <b>Family Details</b>
                                                            </button>
                                                            <div id="family_details_div" class="p-3 collapse show" aria-labelledby="family_details_heading" data-parent="#family_details_accordion">
                                                                <b class="bold_title">Live with family :</b> <?php echo $row['yes/no']; ?><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div id="contact_details_accordion">
                                                            <button class="btn collapsed in" id="contact_details" type="button" data-toggle="collapse" data-target="#contact_details_div" aria-expanded="false" aria-controls="contact_details_div">
                                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                                <b>Contact Details</b>
                                                            </button>
                                                            <div id="contact_details_div" class="p-3 collapse show" aria-labelledby="contact_details_heading" data-parent="#contact_details_accordion">
                                                                <b class="bold_title">E-mail :</b> <?php echo $row['email']; ?><br>
                                                                <b class="bold_title">Phone Number :</b> <?php echo $row['phone']; ?><br>
                                                                <b class="bold_title">Address :</b> <?php echo $row['address'];
                                                                echo $add; ?><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row ">
                                                    <div class="col-12">
                                                        <div id="partner_pref_accordion">
                                                            <button class="btn collapsed" id="partner_pref" type="button" data-toggle="collapse" data-target="#partner_pref_div" aria-expanded="false" aria-controls="partner_pref_div">
                                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                                <b>Partner pref Details</b>
                                                            </button>
                                                            <div id="partner_pref_div" class="p-3 collapse show" aria-labelledby="partner_pref_heading" data-parent="#partner_pref_accordion">
                                                                <b class="bold_title">I am not particular about my Partners Community :</b>
                                                                <?php echo (isset($row['community-checkbox']) && $row['community-checkbox'] != null ? 'True' : ''); ?>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                      
                                            <form action="" method="POST">
                                                <div class="text-center my-5">
                                                    <button class="btn btn-secondary btn-md" type="button" name="updtprof" id="updtprof" data-toggle="modal" data-target=".updtUserDetailModal">Update Profile</button>
                                                </div>
                                            </form>
                                            <!-- /.container-fluid -->
                                        </div>
                                </div>
                                <!-- End of Main Content -->
                                <?php
                                include 'panelFooter.php';
                                ?>

                                <!-- End of Content Wrapper -->
                            </div>
                            <!-- End of Page Wrapper -->
                            <!-- Scroll to Top Button-->
                            <a class="scroll-to-top rounded" href="#page-top">
                                <i class="fas fa-angle-up"></i>
                            </a>
                            <!-- ----------update model ----------------------- -->
                            <div class="modal fade updtUserDetailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form method="POST" action="" enctype="multipart/form-data">
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
                                                    <div class="mt-0 col-md-12">
                                                        <div class="form-group">
                                                            <label>This Profile is for <span class="required">*</span></label>
                                                            <?php $profile_for_var = (isset($row['profile_for'])) ? $row['profile_for'] : ''; ?>
                                                            <?php $profile_for_arr = array('Myself', 'My Son', 'My Daughter', 'My Brother', 'My Sister', 'My Friend', 'My Relative'); ?>

                                                            <select name="profile_for" class="form-control select" id="profile_for">
                                                                <?php if (empty($profile_for_var)): ?>
                                                                            <option value="">Select Profile For</option>
                                                                <?php endif; ?>
                                                                <?php
                                                                foreach ($profile_for_arr as $pf):
                                                                  $selected = '';
                                                                  if ($pf == $profile_for_var) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $pf; ?>"><?php echo $pf; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Your Name <span class="required">*</span></label>
                                                            <?php $name = (isset($row['name'])) ? $row['name'] : ''; ?>
                                                            <input class="form-control" type="text" id="username" name="name" value="<?php echo ucwords($name); ?>">
                                                            <p id="name"></p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Phone Number <span class="required">*</span></label>
                                                            <?php $phone = (isset($row['phone'])) ? $row['phone'] : ''; ?>
                                                            <input class="form-control" type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
                                                            <p id="phone"></p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Email Address <span class="required">*</span></label>
                                                            <?php $email = (isset($row['email'])) ? $row['email'] : ''; ?>
                                                            <input class="form-control" type="email" id="email" name="email" value="<?php echo $email; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Your country </label>
                                                            <select name="country" class="form-control select" onchange="getState(this.value);" type="text" id="country">
                                                                <?php
                                                                $my_country = (isset($row['country'])) ? $row['country'] : '';

                                                                $country_sql = "SELECT * FROM countries WHERE is_active = 1  ORDER BY name";
                                                                $country_result = mysqli_query($conn, $country_sql);
                                                                while ($country_row = mysqli_fetch_array($country_result)):
                                                                  $selected = '';
                                                                  if ($country_row['id'] == $my_country) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $country_row['id']; ?>">
                                                                                <?php echo $country_row['name']; ?>
                                                                            </option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Your State </label>
                                                            <select class="form-control select" type="text" onchange="getCity(this.value)" id="state" name="state">
                                                                <?php
                                                                $my_state = (isset($row['state'])) ? $row['state'] : '';

                                                                $state_sql = "SELECT * FROM states WHERE country_id = $my_country AND is_active = 1 ORDER BY name";
                                                                $state_result = mysqli_query($conn, $state_sql);

                                                                while ($state_row = mysqli_fetch_array($state_result)):
                                                                  $selected = '';
                                                                  if ($state_row['id'] == $my_state) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $state_row['id']; ?>">
                                                                                <?php echo $state_row['name']; ?>
                                                                            </option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Your city </label>
                                                            <select class="form-control select" type="text" id="city" name="city" id="city">
                                                                <?php
                                                                $my_city = (isset($row['city'])) ? $row['city'] : '';
                                                                $city_sql = "SELECT * FROM cities WHERE state_id = $my_state AND is_active = 1 ORDER BY name";
                                                                $city_result = mysqli_query($conn, $city_sql);
                                                                while ($city_row = mysqli_fetch_array($city_result)):
                                                                  $selected = '';
                                                                  if ($city_row['id'] == $my_city) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $city_row['id']; ?>"><?php echo $city_row['name']; ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Address </label>
                                                            <input class="form-control" type="text" id="address" name="address" value="<?php echo ucwords($row['address']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Marital Status </label>
                                                            <?php $marital_status = (isset($row['marStat'])) ? $row['marStat'] : ''; ?>
                                                            <?php $mstatus_arr = array('Never married', 'Divorced', 'Widowed'); ?>
                                                            <select name="marStat" class="form-control select" id="marStat">
                                                                <?php if (empty($marital_status)): ?>
                                                                            <option value="">Select option</option>
                                                                <?php endif; ?>
                                                                <?php
                                                                $city_sql = "SELECT * FROM cities WHERE state_id = $my_state AND is_active = 1 ORDER BY name";
                                                                $city_result = mysqli_query($conn, $city_sql);
                                                                foreach ($mstatus_arr as $status):
                                                                  $selected = '';
                                                                  if ($status == $marital_status) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label class="">Mother Tongue </label>
                                                            <?php $lang = (isset($row['lang'])) ? $row['lang'] : ''; ?>
                                                            <input class="form-control" type="text" id="lang" name="lang" value="<?php echo $lang; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Diet</label>
                                                            <?php $diet_arr = array('Veg', 'Non-Neg', 'Occasionally Non-Veg', 'Eggetarian', 'Jain', 'Vegan'); ?>
                                                            <select name="diet" class="form-control select" id="diet">
                                                                <?php $diet = (isset($row['diet'])) ? $row['diet'] : ''; ?>
                                                                <?php if (empty($diet)): ?>
                                                                            <option value="">Select option</option>
                                                                <?php endif; ?>
                                                                <?php
                                                                foreach ($diet_arr as $drow):
                                                                  $selected = '';
                                                                  if ($drow == $diet) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $drow; ?>"><?php echo $drow; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Height </label>
                                                            <?php $height = (isset($row['height'])) ? $row['height'] : ''; ?>
                                                            <input class="form-control" onkeypress="return float_validation(event, this.value)" type="text" id="height" name="height" value="<?php echo $height; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Religion </label>
                                                            <?php $religion = (isset($row['religion'])) ? $row['religion'] : ''; ?>
                                                            <select name="religion" class="form-control select" id="religion">
                                                                <?php if (empty($religion)): ?>
                                                                            <option value="">Select option</option>
                                                                <?php endif; ?>
                                                                <?php
                                                                $religion_sql = "SELECT * FROM religion WHERE is_active = 1 ORDER BY name";
                                                                $religion_result = mysqli_query($conn, $religion_sql);
                                                                while ($religion_row = mysqli_fetch_array($religion_result)):
                                                                  $selected = '';
                                                                  if ($religion_row['name'] == $religion) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $religion_row['id']; ?>">
                                                                                <?php echo $religion_row['name']; ?>
                                                                            </option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Sub Community </label>
                                                            <?php $subcom = (isset($row['sub-com'])) ? $row['sub-com'] : ''; ?>
                                                            <input class="form-control" type="text" id="sub-com" name="sub-com" value="<?php echo ucwords($subcom); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <?php $high_education = (isset($row['HighEdu'])) ? $row['HighEdu'] : ''; ?>

                                                            <label>Highest Education </label>
                                                            <select name="HEduSearch" class="form-control select" id="HEduSearch">
                                                                <?php if (empty($high_education)): ?>
                                                                            <option value="">Select option</option>
                                                                <?php endif; ?>
                                                                <?php
                                                                $sql_higher_education = "SELECT * FROM `higher_education` where is_active = 1 ";
                                                                $res_higher_education = mysqli_query($conn, $sql_higher_education);
                                                                ?>
                                                                <?php while ($rowe = mysqli_fetch_array($res_higher_education)): ?>
                                                                            <?php
                                                                            $name = $rowe['name'];
                                                                            $selected = '';
                                                                            if ($name == $high_education) {
                                                                              $selected = 'selected';
                                                                            }
                                                                            ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $name; ?>"><?php echo $name; ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Collage</label>
                                                            <?php $collage = (isset($row['collage'])) ? $row['collage'] : ''; ?>
                                                            <input class="form-control" type="text" id="collage" name="collage" value="<?php echo ucwords($collage); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Profession </label>
                                                            <?php
                                                            $prof = (isset($row['prof'])) ? $row['prof'] : '';
                                                            $profession_arr = array(
                                                              'other',
                                                              'Research',
                                                              'Armed Forces',
                                                              'Service with Govt',
                                                              'Own Family Hospital',
                                                              'Private Practice',
                                                              'Attached with Hospital Or Senior Doctor',
                                                              'Studying Practicing Doctor',
                                                              'Studying'
                                                            );
                                                            sort($profession_arr);
                                                            $sort_arr = count($profession_arr);

                                                            ?>
                                                            <select name="Prof" class="form-control select" id="Prof">
                                                                <?php if (empty($prof)): ?>
                                                                            <option value="">Select option</option>
                                                                <?php endif; ?>
                                                                <?php
                                                                $i = 0;
                                                                for ($i = 0; $i < $sort_arr; $i++):
                                                                  $selected = '';
                                                                  $var_p = $profession_arr[$i];
                                                                  if ($profession_arr[$i] == $prof) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $var_p; ?>"><?php echo $var_p; ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Specialization </label>
                                                            <?php $specialization = (isset($row['specialization'])) ? $row['specialization'] : ''; ?>
                                                            <input class="form-control" type="text" name="Specialization" id="Specialization" value="<?php echo $specialization; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Income (yearly)</label>
                                                            <?php $income = (isset($row['income'])) ? $row['income'] : ''; ?>
                                                            <input onkeypress="return float_validation(event, this.value)" class="form-control" type="text" id="income" name="income" value="<?php echo $income; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Your Blood Group </label>
                                                            <?php $bGrp = (isset($row['bGrp'])) ? $row['bGrp'] : ''; ?>

                                                            <?php $bg_arr = array('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'); ?>
                                                            <select name="bGrp" class="form-control select" id="BGrp">
                                                                <?php if (empty($bGrp)): ?>
                                                                            <option value="">Select option</option>
                                                                <?php endif; ?>
                                                                <?php
                                                                foreach ($bg_arr as $bgrow):
                                                                  $selected = '';
                                                                  if ($bgrow == $bGrp) {
                                                                    $selected = 'selected';
                                                                  }
                                                                  ?>
                                                                            <option <?php echo $selected; ?> value="<?php echo $bgrow; ?>"><?php echo $bgrow; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date</label>
                                                            <?php $bDate = (isset($row['bDate'])) ? $row['bDate'] : ''; ?>
                                                            <?php $age = (isset($row['age'])) ? $row['age'] : ''; ?>
                                                            <input class="form-control" onchange="getAge(this.value)" type="date" name="bDate" id="bDay" value="<?php echo $bDate; ?>">
                                                            <input class="form-control" type="hidden" name="age" id="age" value="<?php echo $age; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-3">
                                                        <div class="form-group">
                                                            <label>Birth Time</label>
                                                            <?php $bTime = (isset($row['bTime'])) ? $row['bTime'] : ''; ?>
                                                            <input class="form-control" type="time" name="bTime" id="bTime" value="<?php echo $bTime; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-3">
                                                        <div class="form-group">
                                                            <label>Birth Location</label>
                                                            <?php $bLocation = (isset($row['bLocation'])) ? $row['bLocation'] : ''; ?>
                                                            <input class="form-control" type="text" name="bLocation" id="bLocation" value="<?php echo $bLocation; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-6">
                                                        <div class="form-group">
                                                            <label>Image </label>
                                                            <div class=" mb-3">
                                                                <input type="file" class="form-control" name="userImg" id="userimage" accept="image/png, image/gif, image/jpeg">
                                                                <input type="hidden" class="form-control" name="userImg1" id="userimage1" value="<?php echo $row['filename']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-6">
                                                        <div class="form-group">
                                                            <label for="userBio">Enter something about your-self.</label>
                                                            <?php $bio = (isset($row['bio'])) ? $row['bio'] : ''; ?>
                                                            <textarea class="form-control" name="bio" id="exampleFormControlTextarea1" rows="3" value="<?php echo ucwords($bio); ?>"><?php echo $bio; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-6">
                                                        <label>Gender </label>
                                                        <div class="form-group mt-10">
                                                            <label class="" for="female">
                                                                <span>Female</span>
                                                                <input class=" input_sex" id="gender_m" type="radio" name="gender" value="Female" <?php echo (isset($row['gender']) && $row['gender'] == 'Female') ? 'checked' : '' ?> />
                                                            </label>
                                                            <label class="" for="male">
                                                                <span>Male</span>
                                                                <input class=" input_sex" id="gender_f" type="radio" name="gender" value="Male" <?php echo (isset($row['gender']) && $row['gender'] == 'Male') ? 'checked' : '' ?> />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-0 col-md-6">
                                                        <div class="form-group">
                                                            <label>Do You Live With your Family </label>
                                                            <div class="form-group">
                                                                <p>
                                                                    <input type="radio" id="yes" name="yes/no" value="yes" <?php echo (isset($row['yes/no']) && $row['yes/no'] == 'yes') ? 'checked' : '' ?>>Yes</input>
                                                                    <input type="radio" id="no" name="yes/no" value="no" <?php echo (isset($row['yes/no']) && $row['yes/no'] == 'no') ? 'checked' : '' ?>>No</input>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <input type="checkbox" name="community" id="communityCheckbox" value="I am not particular about my Partners Community" <?php echo (isset($row['community-checkbox']) && $row['community-checkbox'] != null ? 'checked' : ''); ?>>
                                                        I am not particular about my Partners Community
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button name="updateProfile" type="submit" class="btn btn-warning" id="updt_btn">Update</button>
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                                            </div>
                                        </div>
                                        <!--end Modal update -->
                                    </form>

                        <?php } ?>
                        </div>
                    </div>


                    <script>
                        $(document).ready(function() {
                            $("#showMore").click(function() {
                                if ($(this).text() == "Show Less") {
                                    $(this).text("Show More");
                                } else {
                                    $(this).text("Show Less");
                                };
                            });
                        });

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
                                    console.log(result);
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
                                    console.log(result2);
                                    $('#city').html(result2);
                                }
                            });
                        }

                        $(document).ready(function() {
                            $("#testModalButton").click(testModal);
                        })

                        var testModal = function() {
                            try {
                                $("#exampleModalCenter").modal();
                            } catch (e) {
                                alert(e);
                            }
                        }

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
                    </script>
            </body>

            </html>
        <?php
else:
  header("location:login-page.php");
endif;
?>