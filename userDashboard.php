<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
include 'dbconn.php';
$user_id = $_SESSION['id'];
$select_q = " SELECT * FROM user_regiter WHERE id = '$user_id' AND 
(  email = ''  OR  address = ''  OR  marStat = ''  
OR  lang = ''  OR  diet = ''  OR  height = ''  
OR  `sub-com` = ''  OR  `community-checkbox` = ''  
OR  HighEdu = ''  OR  collage = ''  OR  prof = ''  
OR  specialization = ''  OR  income = ''  OR  `yes/no` = ''  
OR  bGrp = ''  OR  bTime = ''  OR  bLocation = ''  
OR  filename = ''  OR  bio = ''  OR  other_lang = ''  
OR  smoking = ''  OR  drinking = ''  OR  gotra = ''  
OR  caste = ''  OR  native_place = ''   OR  out_of_india = '' 
OR  p_father = ''  OR  p_father_occ = ''  OR  p_mother = '' OR weight = '' 
OR  m_father_occ = ''  OR  m_father = ''  OR  m_mother = ''  )";
// OR  m_mother_occ = ''  OR no_of_brothers = ''  
// OR  no_of_sisters = ''  OR  brothers_details = ''  
// OR  sisters_details = ''OR  m_father_occ = '' 
$select_result = mysqli_query($conn, $select_q);
$user_no = 0;
while ($user_row = mysqli_fetch_assoc($select_result)) {

  $user_no++;
}
if ($user_no > 0) {
  $_SESSION["all_data_saved"] = "no";
} else {
  $_SESSION["all_data_saved"] = "yes";
}




if (isset($user_id)):
  if (isset($_POST['updateProfile'])):
    // print_r($_POST);
    $profile_for = isset($_POST['profile_for']) ? $_POST['profile_for'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $marStat = isset($_POST['marStat']) ? $_POST['marStat'] : '';
    $diet = isset($_POST['diet']) ? $_POST['diet'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $lang = isset($_POST['lang']) ? $_POST['lang'] : '';
    $subcom = isset($_POST['sub-com']) ? $_POST['sub-com'] : '';
    $other_lang = isset($_POST['other_lang']) ? $_POST['other_lang'] : '';
    $smoking = isset($_POST['smoking']) ? $_POST['smoking'] : '';
    $drinking = isset($_POST['drinking']) ? $_POST['drinking'] : '';
    $gotra = isset($_POST['gotra']) ? $_POST['gotra'] : '';
    $caste = isset($_POST['caste']) ? $_POST['caste'] : '';
    $LiveWithFamily = isset($_POST['yes/no']) ? $_POST['yes/no'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $bDate = isset($_POST['bDate']) ? $_POST['bDate'] : '';
    $bTime = isset($_POST['bTime']) ? $_POST['bTime'] : '';
    $bLocation = isset($_POST['bLocation']) ? $_POST['bLocation'] : '';
    $height = isset($_POST['height']) ? $_POST['height'] : '';
    $BGrp = isset($_POST['bGrp']) ? $_POST['bGrp'] : '';
    $high_education = isset($_POST['HEduSearch']) ? $_POST['HEduSearch'] : '';
    $collage = isset($_POST['collage']) ? $_POST['collage'] : '';
    $Specialization = isset($_POST['Specialization']) ? $_POST['Specialization'] : '';
    $Prof = isset($_POST['Prof']) ? $_POST['Prof'] : '';
    $income = isset($_POST['income']) ? $_POST['income'] : '';
    $prof_country = isset($_POST['prof_country']) ? $_POST['prof_country'] : '';
    $p_father = isset($_POST['p_father']) ? $_POST['p_father'] : '';
    $p_father_occ = isset($_POST['p_father_occ']) ? $_POST['p_father_occ'] : '';
    $p_mother = isset($_POST['p_mother']) ? $_POST['p_mother'] : '';
    $p_mother_occ = isset($_POST['p_mother_occ']) ? $_POST['p_mother_occ'] : '';

    $m_father = isset($_POST['m_father']) ? $_POST['m_father'] : '';
    $m_father_occ = isset($_POST['m_father_occ']) ? $_POST['m_father_occ'] : '';
    $m_mother = isset($_POST['m_mother']) ? $_POST['m_mother'] : '';
    $m_mother_occ = isset($_POST['m_mother_occ']) ? $_POST['m_mother_occ'] : '';
    $no_of_brothers = isset($_POST['no_of_brothers']) ? $_POST['no_of_brothers'] : 0;
    $no_of_sisters = isset($_POST['no_of_sisters']) ? $_POST['no_of_sisters'] : 0;
    $brothers_details = isset($_POST['brothers_details']) ? $_POST['brothers_details'] : '';
    $sisters_details = isset($_POST['sisters_details']) ? $_POST['sisters_details'] : '';
    $community = isset($_POST['community']) ? $_POST['community'] : '';
    $native_place = isset($_POST['native_place']) ? $_POST['native_place'] : '';
    $bio = isset($_POST['bio']) ? $_POST['bio'] : '';
    $out_of_india = (isset($_POST['out_of_india'])) ? $_POST['out_of_india'] : '';
    $weight = (isset($_POST['weight'])) ? $_POST['weight'] : '';
    $age = (isset($_POST['age'])) ? $_POST['age'] : '';

    $sql_edit = "UPDATE `user_regiter` SET profile_for='$profile_for',`name`='$name',
                    `email`='$email',`phone`='$phone',`country`='$country',`state`='$state',`city`='$city',
                    `address`='$address',`marStat`='$marStat',`lang`='$lang',`diet`='$diet',`height`='$height',
                    `sub-com`='$subcom',`community-checkbox`='$community',
                    `HighEdu`='$high_education',`collage`='$collage',`prof`='$Prof',
                    `specialization`='$Specialization',`income`='$income',`yes/no`='$LiveWithFamily',
                    `bGrp`='$BGrp',`bDate`='$bDate',`gender`='$gender',`bTime`='$bTime',
                    `bLocation`='$bLocation',
                    no_of_brothers = $no_of_brothers, no_of_sisters =$no_of_sisters,
                    brothers_details = '$brothers_details', sisters_details = '$sisters_details',
                    p_father_occ = '$p_father_occ', m_father_occ = '$m_father_occ',
                    p_mother_occ = '$p_mother_occ', m_mother_occ = '$m_mother_occ',
                    p_mother = '$p_mother', m_mother = '$m_mother',
                    p_father = '$p_father', m_father = '$m_father',
                    caste = '$caste', gotra = '$gotra', age ='$age',
                    other_lang = '$other_lang', smoking = '$smoking',
                    drinking = '$drinking',surname='$surname', native_place = '$native_place'  
                    ,`bio`='$bio', prof_country ='$prof_country',religion=1, out_of_india = '$out_of_india',
                    weight = '$weight'                   
                    where `id`='$user_id'";
    $update_q = mysqli_query($conn, $sql_edit);
    if (!empty($_FILES["userImg"]["name"])):
      $total = count($_FILES['userImg']['name']);
      // Loop through each file
      for ($i = 0; $i < $total; $i++):

        //Get the temp file path
        $tmpFilePath = $_FILES['userImg']['tmp_name'][$i];

        //Make sure we have a file path
        if ($tmpFilePath != "") {
          //Setup our new file path
          $newFilePath = "user_image/" . $_FILES['userImg']['name'][$i];
          $filename = $_FILES["userImg"]["name"][$i];
          //Upload the file into the temp dir
          if (move_uploaded_file($tmpFilePath, $newFilePath)):

            $img_query = "INSERT INTO `user_profile_images`( `user_id`, `image_name`) 
                    VALUES ('$user_id','$filename')";
            $insert_result = mysqli_query($conn, $img_query);
            if ($i == 0):
              $sql_edit = "UPDATE `user_regiter` SET `filename`='$filename' where `id`='$user_id'";
              $update_profile = mysqli_query($conn, $sql_edit);
            endif;

          endif;
        }
      endfor;
    endif;

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
                                                    //echo '<br>';
                                                    $expiry = $row['plan_expiry_date'];
                                                    ?>
                                                                                    <?php //if (isset($_GET['demo'])) : 
                                                                                        ?>
                                                                                    <?php if ($expiry <= $today): ?>
                                                                                                                      <script>
                                                                                                                          window.onload = function() {
                                                                                                                              $("#exampleModalCenter").modal();
                                                                                                                          }
                                                                                                                      </script>
                                                                                    <?php endif; ?>
                                                                                    <?php //endif; 
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

                                                                                            <form action="" method="POST" enctype="multipart/form-data">
                                                                                                <div class="card-header py-3" >
                                                                                                    <h6 class="m-0 font-weight-bold text-white text-center">Profile</h6>
                                                                                                </div>
                                                                                                <?php if (isset($_SESSION['all_data_saved']) && $_SESSION['all_data_saved'] == 'no'): ?>
                                                                                                                                  <div class="container">
                                                                                                                                      <div class="row">
                                                                                                                                          <div class="profileerror required center">
                                                                                                                                              Please fill up your required profile data
                                                                                                                                          </div>
                                                                                                                                      </div>
                                                                                                                                  </div>
                                                                                                <?php endif; ?>

                                                                                                <div class="row">
                                                                                                    <div class="tabordion">
                                                                                                        <section id="section1">
                                                                                                            <input type="radio" name="sections" id="option1" checked>
                                                                                                            <label for="option1">Photos</label>
                                                                                                            <article>
                                                                                                                <h6>Photos</h6>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-sm-8">
                                                                                                                        <div class="w3-content w3-display-container">
                                                                                                                            <?php
                                                                                                                            $user_sql = "SELECT image_name FROM `user_profile_images` where `user_id` =  '$user_id' ";
                                                                                                                            $result = mysqli_query($conn, $user_sql);
                                                                                                                            while ($imagerow = mysqli_fetch_assoc($result)):
                                                                                                                              $image_name = $imagerow['image_name'];
                                                                                                                              ?>
                                                                                                                                                              <img class="mySlides" src="user_image/<?php echo $image_name; ?>" style="width:50%">
                                                                                                                                                          <?php
                                                                                                                            endwhile;
                                                                                                                            ?>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-sm-4">
                                                                                                                        Upload your photos <span class="required">*</span>
                                                                                                                        <input type="file" class="form-control" name="userImg[]" id="userimage" accept="image/png, image/gif, image/jpeg" multiple>
                                                                                                                        <input type="hidden" class="form-control" name="userImg1" id="userimage1" value="<?php echo $row['filename']; ?>">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>
                                                                                                        <section id="section2">
                                                                                                            <input type="radio" name="sections" id="option2">
                                                                                                            <label for="option2">Personal Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            This Profile is for <span class="required">*</span>
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
                                                                                                                        <div class="form-group">
                                                                                                                            Name <span class="required">*</span>
                                                                                                                            <?php $name = (isset($row['name'])) ? $row['name'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="username" name="name" value="<?php echo ucwords($name); ?>">
                                                                                                                            <p id="name"></p>
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Diet<span class="required">*</span>
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

                                                                                                                        <div class="form-group">
                                                                                                                            Mother Tongue<span class="required">*</span>
                                                                                                                            <?php $lang = (isset($row['lang'])) ? $row['lang'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="lang" name="lang" value="<?php echo $lang; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Other Languages<span class="required">*</span>
                                                                                                                            <?php $other_lang = (isset($row['other_lang'])) ? $row['other_lang'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="other_lang" name="other_lang" value="<?php echo $other_lang; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Enter something about your-self<span class="required">*</span>
                                                                                                                            <?php $bio = (isset($row['bio'])) ? $row['bio'] : ''; ?>
                                                                                                                            <textarea class="form-control" name="bio" id="exampleFormControlTextarea1" rows="3" value="<?php echo ucwords($bio); ?>"><?php echo $bio; ?></textarea>
                                                                                                                        </div>

                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Marital Status<span class="required">*</span>
                                                                                                                            <?php $marital_status = (isset($row['marStat'])) ? $row['marStat'] : ''; ?>
                                                                                                                            <?php $mstatus_arr = array('Never married', 'Divorced', 'Widowed'); ?>
                                                                                                                            <select name="marStat" class="form-control select" id="marStat">
                                                                                                                                <?php if (empty($marital_status)): ?>
                                                                                                                                                                  <option value="">Select option</option>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php

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
                                                                                                                        <div class="form-group ">
                                                                                                                            Surname <span class="required">*</span>
                                                                                                                            <?php $surname = (isset($row['surname'])) ? $row['surname'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="surname" name="surname" value="<?php echo ucwords($surname); ?>">
                                                                                                                            <p id="surname"></p>
                                                                                                                        </div>

                                                                                                                        <div class="form-group">
                                                                                                                            Gender<span class="required">*</span>
                                                                                                                            <div class="form-group mt-10">

                                                                                                                                <span>Female</span>
                                                                                                                                <input class=" input_sex" id="gender_m" type="radio" name="gender" value="Female" <?php echo (isset($row['gender']) && $row['gender'] == 'Female') ? 'checked' : '' ?> />

                                                                                                                                <span>Male</span>
                                                                                                                                <input class=" input_sex" id="gender_f" type="radio" name="gender" value="Male" <?php echo (isset($row['gender']) && $row['gender'] == 'Male') ? 'checked' : '' ?> />

                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Sub Community<span class="required">*</span>
                                                                                                                            <?php $subcom = (isset($row['sub-com'])) ? $row['sub-com'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="sub-com" name="sub-com" value="<?php echo ucwords($subcom); ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Smoking<span class="required">*</span>
                                                                                                                            <div class="form-group mt-10">
                                                                                                                                <span>Yes</span>
                                                                                                                                <input class=" input_sex" id="s_yes" type="radio" name="smoking" value="Yes" <?php echo (isset($row['smoking']) && $row['smoking'] == 'Yes') ? 'checked' : '' ?> />

                                                                                                                                <span>No</span>
                                                                                                                                <input class=" input_sex" id="s_no" type="radio" name="smoking" value="No" <?php echo (isset($row['smoking']) && $row['smoking'] == 'No') ? 'checked' : '' ?> />
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Drinking<span class="required">*</span>
                                                                                                                            <div class="form-group mt-10">
                                                                                                                                <span>Yes</span>
                                                                                                                                <input class="input_sex" id="d_yes" type="radio" name="drinking" value="Yes" <?php echo (isset($row['drinking']) && $row['drinking'] == 'Yes') ? 'checked' : '' ?> />

                                                                                                                                <span>No</span>
                                                                                                                                <input class="input_sex" id="d_no" type="radio" name="drinking" value="No" <?php echo (isset($row['drinking']) && $row['drinking'] == 'No') ? 'checked' : '' ?> />
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>
                                                                                                        <section id="section10">
                                                                                                            <input type="radio" name="sections" id="option10">
                                                                                                            <label for="option10">Family Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Gotra<span class="required">*</span>
                                                                                                                            <?php $gotra = (isset($row['gotra'])) ? $row['gotra'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="gotra" name="gotra" value="<?php echo $gotra; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            <div class="form-group">
                                                                                                                                Live with family<span class="required">*</span>
                                                                                                                                <input type="radio" id="yes" name="yes/no" value="yes" <?php echo (isset($row['yes/no']) && $row['yes/no'] == 'yes') ? 'checked' : '' ?>>Yes</input>
                                                                                                                                <input type="radio" id="no" name="yes/no" value="no" <?php echo (isset($row['yes/no']) && $row['yes/no'] == 'no') ? 'checked' : '' ?>>No</input>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Caste <span class="required">*</span>
                                                                                                                            <?php $caste = (isset($row['caste'])) ? $row['caste'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="caste" name="caste" value="<?php echo $caste; ?>">
                                                                                                                            <p id="caste"></p>
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Native Place<span class="required">*</span>
                                                                                                                            <?php $native_place = (isset($row['native_place'])) ? $row['native_place'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="native_place" name="native_place" value="<?php echo $native_place; ?>">
                                                                                                                            <p id="caste"></p>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>
                                                                                                        <section id="section9">
                                                                                                            <input type="radio" name="sections" id="option9">
                                                                                                            <label for="option9">Contact Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Email Address <span class="required">*</span>
                                                                                                                            <?php $email = (isset($row['email'])) ? $row['email'] : ''; ?>
                                                                                                                            <input class="form-control" type="email" id="email" name="email" value="<?php echo $email; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Address<span class="required">*</span>
                                                                                                                            <?php $address = (isset($row['address'])) ? $row['address'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="address" name="address" value="<?php echo $address; ?>">

                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Your State<span class="required">*</span>
                                                                                                                            <select class="form-control select" type="text" onchange="getCity(this.value)" id="state" name="state">
                                                                                                                                <?php
                                                                                                                                $my_country = (isset($row['country'])) ? $row['country'] : '';
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
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Phone Number <span class="required">*</span>
                                                                                                                            <?php $phone = (isset($row['phone'])) ? $row['phone'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
                                                                                                                            <p id="phone"></p>
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Your country<span class="required">*</span>
                                                                                                                            <select name="country" class="form-control select" onchange="getState(this.value);" type="text" id="country">
                                                                                                                                <?php

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
                                                                                                                        <div class="form-group">
                                                                                                                            Your city<span class="required">*</span>
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
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>
                                                                                                        <section id="section3">
                                                                                                            <input type="radio" name="sections" id="option3">
                                                                                                            <label for="option3">Birth & Physical Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Birth Date<span class="required">*</span>
                                                                                                                            <?php $bDate = (isset($row['bDate'])) ? $row['bDate'] : ''; ?>
                                                                                                                            <?php $age = (isset($row['age'])) ? $row['age'] : ''; ?>
                                                                                                                            <input class="form-control" onchange="getAge(this.value)" type="date" name="bDate" id="bDay" value="<?php echo $bDate; ?>">
                                                                                                                            <input class="form-control" type="hidden" name="age" id="age" value="<?php echo $age; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Birth Location<span class="required">*</span>
                                                                                                                            <?php $bLocation = (isset($row['bLocation'])) ? $row['bLocation'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" name="bLocation" id="bLocation" value="<?php echo $bLocation; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Height(In)<span class="required">*</span>
                                                                                                                            <?php $height = (isset($row['height'])) ? $row['height'] : ''; ?>
                                                                                                                            <input class="form-control" onkeypress="return float_validation(event, this.value)" type="text" id="height" name="height" value="<?php echo $height; ?>">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Birth Time<span class="required">*</span>
                                                                                                                            <?php $bTime = (isset($row['bTime'])) ? $row['bTime'] : ''; ?>
                                                                                                                            <input class="form-control" type="time" name="bTime" id="bTime" value="<?php echo $bTime; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Weight(Kg)<span class="required">*</span>
                                                                                                                            <?php $weight = (isset($row['weight'])) ? $row['weight'] : ''; ?>
                                                                                                                            <input class="form-control" onkeypress="return float_validation(event, this.value)" type="text" id="weight" name="weight" value="<?php echo $weight; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Blood Group<span class="required">*</span>
                                                                                                                            <?php $bGrp = (isset($row['bGrp'])) ? $row['bGrp'] : ''; ?>

                                                                                                                            <?php $bg_arr = array('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'); ?>
                                                                                                                            <select name="bGrp" class="form-control select" id="bGrp">
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
                                                                                                            </article>
                                                                                                        </section>
                                                                                                        <section id="section4">
                                                                                                            <input type="radio" name="sections" id="option4">
                                                                                                            <label for="option4">Educational & Professional Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            <?php $high_education = (isset($row['HighEdu'])) ? $row['HighEdu'] : ''; ?>

                                                                                                                            Highest Education<span class="required">*</span>
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
                                                                                                                        <div class="form-group">
                                                                                                                            Specialization<span class="required">*</span>
                                                                                                                            <?php $specialization = (isset($row['specialization'])) ? $row['specialization'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" name="Specialization" id="Specialization" value="<?php echo $specialization; ?>">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Collage<span class="required">*</span>
                                                                                                                            <?php $collage = (isset($row['collage'])) ? $row['collage'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="collage" name="collage" value="<?php echo ucwords($collage); ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Profession<span class="required">*</span>
                                                                                                                            <?php
                                                                                                                            $prof = (isset($row['prof'])) ? $row['prof'] : '';
                                                                                                                            // $profession_arr = array(
                                                                                                                            //     'other', 'Research', 'Armed Forces', 'Service with Govt',
                                                                                                                            //     'Own Family Hospital', 'Private Practice', 'Attached with Hospital Or Senior Doctor',
                                                                                                                            //     'Studying Practicing Doctor', 'Studying'
                                                                                                                            // );
                                                                                                                            // sort($profession_arr);
                                                                                                                            // $sort_arr = count($profession_arr);
                                                                                                                        
                                                                                                                            ?>
                                                                                                                            <input class="form-control" type="text" id="Prof" name="Prof" value="<?php echo $prof; ?>">

                                                                                                                            <!-- <select name="Prof" class="form-control select" id="Prof">
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
                                                                </select> -->
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">

                                                                                                                        <div class="form-group">
                                                                                                                            Working Out Of India<span class="required">*</span>
                                                                                                                            <?php $out_of_india = (isset($row['out_of_india'])) ? $row['out_of_india'] : ''; ?>
                                                                                                                            <?php $out_of_india_arr = array('Yes', 'No'); ?>
                                                                                                                            <select name="out_of_india" class="form-control select" id="out_of_india" onchange="getLocationTextbox(this.value)">
                                                                                                                                <?php if (empty($out_of_india)): ?>
                                                                                                                                                                  <option value="">Select option</option>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php
                                                                                                                                foreach ($out_of_india_arr as $ooistatus):
                                                                                                                                  $selectedi = '';
                                                                                                                                  if ($ooistatus == $out_of_india) {
                                                                                                                                    $selectedi = 'selected';
                                                                                                                                  }
                                                                                                                                  ?>
                                                                                                                                                                  <option <?php echo $selectedi; ?> value="<?php echo $ooistatus; ?>"><?php echo $ooistatus; ?></option>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <?php $showdiv = $out_of_india == 'Yes' ? '' : ' style =display:none; '; ?>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6 " id="prof_country_div" <?php echo $showdiv; ?>>
                                                                                                                        <div class="form-group">
                                                                                                                            Out Of India Location<span class="required">*</span>
                                                                                                                            <?php $prof_country = (isset($row['prof_country'])) ? $row['prof_country'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="prof_country" name="prof_country" value="<?php echo $prof_country; ?>">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Income (yearly)<span class="required">*</span>
                                                                                                                            <?php $income = (isset($row['income'])) ? $row['income'] : ''; ?>
                                                                                                                            <input onkeypress="return float_validation(event, this.value)" class="form-control" type="text" id="income" name="income" value="<?php echo $income; ?>">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>
                                                                                                        <!-- <section id="section5">
                                                <input type="radio" name="sections" id="option5">
                                                <label for="option5">Professional Details</label>
                                                <article>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                Profession<span class="required">*</span>
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
                                                            <div class="form-group">
                                                                India/Out Of India<span class="required">*</span>
                                                                <?php
                                                                $prof_country = (isset($row['prof_country'])) ? $row['prof_country'] : '';

                                                                ?>
                                                                <input class="form-control" type="text" id="prof_country" name="prof_country" value="<?php echo $prof_country; ?>">

                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                Income (yearly)<span class="required">*</span>
                                                                <?php $income = (isset($row['income'])) ? $row['income'] : ''; ?>
                                                                <input onkeypress="return float_validation(event, this.value)" class="form-control" type="text" id="income" name="income" value="<?php echo $income; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </section> -->
                                                                                                        <section id="section6">
                                                                                                            <input type="radio" name="sections" id="option6">
                                                                                                            <label for="option6">Paternal Side Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Father Name<span class="required">*</span>
                                                                                                                            <?php $p_father = (isset($row['p_father'])) ? $row['p_father'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="p_father" name="p_father" value="<?php echo $p_father; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Mother Name<span class="required">*</span>
                                                                                                                            <?php $p_mother = (isset($row['p_mother'])) ? $row['p_mother'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="p_mother" name="p_mother" value="<?php echo $p_mother; ?>">
                                                                                                                        </div>

                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Father Occupation<span class="required">*</span>
                                                                                                                            <?php $p_father_occ = (isset($row['p_father_occ'])) ? $row['p_father_occ'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="p_father_occ" name="p_father_occ" value="<?php echo $p_father_occ; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Mother Occupation
                                                                                                                            <?php $p_mother_occ = (isset($row['p_mother_occ'])) ? $row['p_mother_occ'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="p_mother_occ" name="p_mother_occ" value="<?php echo $p_mother_occ; ?>">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Numbers Of Brothers
                                                                                                                            <?php $no_of_brothers = (isset($row['no_of_brothers'])) ? $row['no_of_brothers'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="no_of_brothers" name="no_of_brothers" value="<?php echo $no_of_brothers; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Brothers Details
                                                                                                                            <?php $brothers_details = (isset($row['brothers_details'])) ? $row['brothers_details'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="brothers_details" name="brothers_details" value="<?php echo $brothers_details; ?>">
                                                                                                                        </div>

                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Numbers Of Sisters
                                                                                                                            <?php $no_of_sisters = (isset($row['no_of_sisters'])) ? $row['no_of_sisters'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="no_of_sisters" name="no_of_sisters" value="<?php echo $no_of_sisters; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Sisters Details
                                                                                                                            <?php $sisters_details = (isset($row['sisters_details'])) ? $row['sisters_details'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="sisters_details" name="sisters_details" value="<?php echo $sisters_details; ?>">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>
                                                                                                        <section id="section7">
                                                                                                            <input type="radio" name="sections" id="option7">
                                                                                                            <label for="option7">Maternal Side Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Father Name<span class="required">*</span>
                                                                                                                            <?php $m_father = (isset($row['m_father'])) ? $row['m_father'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="m_father" name="m_father" value="<?php echo $m_father; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Mother Name<span class="required">*</span>
                                                                                                                            <?php $m_mother = (isset($row['m_mother'])) ? $row['m_mother'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="m_mother" name="m_mother" value="<?php echo $m_mother; ?>">
                                                                                                                        </div>

                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            Father Occupation<span class="required">*</span>
                                                                                                                            <?php $m_father_occ = (isset($row['m_father_occ'])) ? $row['m_father_occ'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="m_father_occ" name="m_father_occ" value="<?php echo $m_father_occ; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            Mother Occupation
                                                                                                                            <?php $m_mother_occ = (isset($row['m_mother_occ'])) ? $row['m_mother_occ'] : ''; ?>
                                                                                                                            <input class="form-control" type="text" id="m_mother_occ" name="m_mother_occ" value="<?php echo $m_mother_occ; ?>">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>

                                                                                                        <section id="section11">
                                                                                                            <input type="radio" name="sections" id="option11">
                                                                                                            <label for="option11">Partner pref Details</label>
                                                                                                            <article>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                        <div class="form-group">
                                                                                                                            <input type="checkbox" name="community" id="communityCheckbox" value="I am not particular about my Partners Community" <?php echo (isset($row['community-checkbox']) && $row['community-checkbox'] != null ? 'checked' : ''); ?>>
                                                                                                                            I am not particular about my Partners Community<span class="required">*</span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col-xs-12 col-md-6 col-sm-6">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </article>
                                                                                                        </section>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <br>
      
                                                                                                <div class="">
                                                                                                    <!-- <button name="updateProfile" type="submit" class="btn btn-warning" id="updt_btn">Update</button> -->
                                                                                                    <button class="btn btn-secondary btn-md" type="submit" name="updateProfile" id="updateProfile">Update Profile</button>
                                                                                                </div>


                                                                                            </form>
                                                                                        </div>




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

                                      <?php } ?>

                                      <style>
                                          .mySlides {
                                              display: none;
                                          }
                                      </style>
                                      <script>
                                          var myIndex = 0;
                                          carousel();

                                          function carousel() {
                                              var i;
                                              var x = document.getElementsByClassName("mySlides");
                                              for (i = 0; i < x.length; i++) {
                                                  x[i].style.display = "none";
                                              }
                                              myIndex++;
                                              if (myIndex > x.length) {
                                                  myIndex = 1
                                              }
                                              x[myIndex - 1].style.display = "block";
                                              setTimeout(carousel, 4000); // Change image every 2 seconds
                                          }

                                          $(document).ready(function() {
                                              $("#showMore").click(function() {
                                                  if ($(this).text() == "Show Less") {
                                                      $(this).text("Show More");
                                                  } else {
                                                      $(this).text("Show Less");
                                                  };
                                              });
                                          });

                                          function getLocationTextbox(v) {
                                              if (v == 'Yes') {
                                                  $('#prof_country_div').show();
                                              } else if (v == 'No') {
                                                  $('#prof_country_div').hide();
                                                  $('#prof_country').val('');
                                              }
                                          }

                                          function getAge() {
                                              var dob = document.getElementById('bDay').value;
                                              var start_date = new Date(dob);
                                              var date = new Date();
                                              var end_date = new Date(start_date);
                                              end_date.setFullYear(date.getFullYear() - start_date.getFullYear());
                                              $("#age").val(end_date.getFullYear());


                                              var birthDate = new Date(inputDate);
    var currentDate = new Date();
    var minAge = 18; // Minimum age allowed

    if (isNaN(birthDate)) {
      document.getElementById("birthDateError").innerHTML = "Please enter a valid date.";
    } else if (birthDate >= currentDate) {
      document.getElementById("birthDateError").innerHTML = "Birth date cannot be in the future.";
    } else {
      var age = currentDate.getFullYear() - birthDate.getFullYear();
      var birthMonth = birthDate.getMonth();
      var currentMonth = currentDate.getMonth();

      if (currentMonth < birthMonth || (currentMonth === birthMonth && currentDate.getDate() < birthDate.getDate())) {
        age--;
      }

      if (age < minAge) {
        document.getElementById("birthDateError").innerHTML = "You must be at least " + minAge + " years old.";
      } else {
        document.getElementById("birthDateError").innerHTML = "";
      }
    }

  
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

                                      <div class="modal fade" id="requiredModalCenter" tabindex="-1" role="dialog" aria-labelledby="requiredModalCenterTitle" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="requiredModalCenterTitle">Uh Oh!</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      Please fill up your required profile data
                                                  </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                      <!-- <a href="user_plan.php"> -->
                                                      <button type="button" class="btn btn-primary">Subcribe</button>
                                                      <!-- </a> -->
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <?php
                                      // if (isset($_SESSION['all_data_saved']) && $_SESSION['all_data_saved'] == 'no') {
                                    
                                      // echo '<script>  
                                      //     alert();
                                      //     //window.onload = function() {
                                      //         $("#requiredModalCenter").modal();
                                      //     //}
                                      //     </script>';
                                      // }
                                      ?>
                                  </body>

                                  </html>
                              <?php
else:
  header("location:login-page.php");
endif;
?> 