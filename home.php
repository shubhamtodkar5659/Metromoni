<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Are you local weddding vendor provider & looking for wedding vendor website template. Wedding Vendor Responsive Website Template suitable for wedding vendor supplier, wedding agency, wedding company, wedding events etc.. ">
  <meta name="keywords" content="Wedding Vendor, wedding template, wedding website template, events, wedding party, wedding cake, wedding dress, wedding couple, couple, Wedding Venues Website Template">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>DevyogVivah | Matrimony </title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Template style.css -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="css/owl.theme.css">
  <link rel="stylesheet" type="text/css" href="css/owl.transitions.css">
  <!-- Font used in template -->
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  <!--font awesome icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- favicon icon -->
  <link rel="icon" href="images/Golden_WC.ico" type="image/x-icon">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top">
  <?php
  include 'dbconn.php';
  include 'mainHeader.php';
  if (isset($_SESSION['id'])) {
    $current_user_id = $_SESSION['id'];
  }
  ?>

  <div class="slider-bg">
    <!-- slider start-->
    <div id="slider" class="owl-carousel owl-theme slider">
      <?php $slider_list_q = "Select * FROM sliders WHERE is_active = 1 "; ?>
      <?php $slider_list = mysqli_query($conn, $slider_list_q); ?>
      <?php while ($slider = mysqli_fetch_array($slider_list)) : ?>
        <?php $slider_img = $slider["image_name"]; ?>
        <?php $slider_img = "admin/sliders/" . $slider_img; ?>
        <?php //echo '<pre>';print_r( $slider_img);
        ?>
        <div class="item">
          <img class="img-responsive" src="<?php echo $slider_img; ?>" alt="">
        </div>
      <?php endwhile; ?>
    </div>
    <!-- <div class="item "><img class="img-responsive" src="images/pexels-subodh-bajpai-1994423.jpg" alt="Wedding couple just married"></div> -->
    <!-- <div class="item "><img class="img-responsive" src="images/Wedding photography.webp" alt="Wedding couple just married"></div> -->
    <!-- <div class="item "><img class="img-responsive" src="images/269847665_294811262605180_1971103402336625723_n-1024x683.webp" alt="Wedding couple just married"></div> -->
    <div class="find-section">
      <!-- Find search section-->
      <div class="container">
        <div class="row center">
          <div class="col-md-offset-1 col-md-10 tab-centr finder-block">
            <div class="finder-caption">
              <h1> Perfect Hindu Rajput Matirmony Site</h1>
              <div>Perfect Hindu Rajput Matrimony site where we help You to find right <strong> partner </strong> who value Your preferences.</div>
              <div>We are happy to help You, so lets get started.</div>

            </div>
            <div class="finderform">
              <div class="finder-caption">Find a suitable match NOW</div>
              <form method="GET" action="allProfile.php">
                <div class="row">
                  <div class="form-group col-md-4 ">
                    <div class="labelGender">
                      I'm looking for
                    </div>
                    <select class="form-control mob-hm required_f" name="gender" id="srch_gender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <input class="form-control" type="hidden" name="religion" id="religion" value="Hindu">

                  <!-- <div class="form-group  col-md-4">
                    <div class="labelRel">
                      Religion
                    </div>
                    <select name="religion" class="form-control mob-hm  required_f" id="religion">
                      <option value="">Select religion</option>
                      <?php
                      $sql_religion = "SELECT * FROM `religion` where is_active = 1";
                      $result = mysqli_query($conn, $sql_religion);
                      ?>
                      <?php while ($row = mysqli_fetch_array($result)) : ?>
                        <?php $name = $row['name']; ?>
                        <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div> -->
                  <div class="form-group col-md-2 col-sm-6">
                    <div class="labelAge">
                      Age From
                    </div>
                    <select class="form-control mob-hm required_f" name="age_min" id="age_min">
                      <option value="">Start range</option>
                      <option value="21">21</option>
                      <option value='22'>22</option>
                      <option value='23'>23</option>
                      <option value='24'>24</option>
                      <option value='25'>25</option>
                      <option value='26'>26</option>
                      <option value='27'>27</option>
                      <option value='28'>28</option>
                      <option value='29'>29</option>
                      <option value='30'>30</option>
                      <option value='31'>31</option>
                      <option value='32'>32</option>
                      <option value='33'>33</option>
                      <option value='34'>34</option>
                      <option value='35'>35</option>
                      <option value='36'>36</option>
                      <option value='37'>37</option>
                      <option value='38'>38</option>
                      <option value='39'>39</option>
                      <option value='40'>40</option>
                      <option value='41'>41</option>
                      <option value='42'>42</option>
                      <option value='43'>43</option>
                      <option value='44'>44</option>
                      <option value='45'>45</option>
                      <option value='46'>46</option>
                      <option value='47'>47</option>
                      <option value='48'>48</option>
                      <option value='49'>49</option>
                      <option value='50'>50</option>
                      <option value='51'>51</option>
                      <option value='52'>52</option>
                      <option value='53'>53</option>
                      <option value='54'>54</option>
                      <option value='55'>55</option>
                      <option value='56'>56</option>
                      <option value='57'>57</option>
                      <option value='58'>58</option>
                      <option value='59'>59</option>
                      <option value='60'>60</option>
                      <option value='61'>61</option>
                      <option value='62'>62</option>
                      <option value='63'>63</option>
                      <option value='64'>64</option>
                      <option value='65'>65</option>
                      <option value='above'>above</option>
                    </select>
                  </div>
                  <div class="form-group col-md-2 col-sm-6">
                    <div class="labelAge">
                      To
                    </div>
                    <select class="form-control mob-hm  required_f " name="age_max" id="age_max">
                      <option value="">End range</option>
                      <option value="21">21</option>
                      <option value='22'>22</option>
                      <option value='23'>23</option>
                      <option value='24'>24</option>
                      <option value='25'>25</option>
                      <option value='26'>26</option>
                      <option value='27'>27</option>
                      <option value='28'>28</option>
                      <option value='29'>29</option>
                      <option value='30'>30</option>
                      <option value='31'>31</option>
                      <option value='32'>32</option>
                      <option value='33'>33</option>
                      <option value='34'>34</option>
                      <option value='35'>35</option>
                      <option value='36'>36</option>
                      <option value='37'>37</option>
                      <option value='38'>38</option>
                      <option value='39'>39</option>
                      <option value='40'>40</option>
                      <option value='41'>41</option>
                      <option value='42'>42</option>
                      <option value='43'>43</option>
                      <option value='44'>44</option>
                      <option value='45'>45</option>
                      <option value='46'>46</option>
                      <option value='47'>47</option>
                      <option value='48'>48</option>
                      <option value='49'>49</option>
                      <option value='50'>50</option>
                      <option value='51'>51</option>
                      <option value='52'>52</option>
                      <option value='53'>53</option>
                      <option value='54'>54</option>
                      <option value='55'>55</option>
                      <option value='56'>56</option>
                      <option value='57'>57</option>
                      <option value='58'>58</option>
                      <option value='59'>59</option>
                      <option value='60'>60</option>
                      <option value='61'>61</option>
                      <option value='62'>62</option>
                      <option value='63'>63</option>
                      <option value='64'>64</option>
                      <option value='65'>65</option>
                      <option value='above'>above</option>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <button id="filter_search_btn" value="filter_search_btn" name="filter_search_btn" class="btn btn-warning custom-btn  top-margin mt50" style="padding: 6px 16px;">
                      <a class="text-white" type="submit">Search <i class="fa-solid fa-magnifying-glass"></i></a></button>
                    <!-- <button class="btn btn-block btn-warning btn-lg custom-btn btn-12 top-margin "><a class="text-white" href="allProfile.php">Find Match</a> </button> -->
                  </div>
                </div>
              </form>
            </div>
          </div>
          <form action="allProfile.php" method="GET">
            <div class="row  genderFltrBtn">
              <div class="col-md-6 ">
                <button name="profile_type" value="female_prof" id="female_prof" class="btn btn-default custom-btn btn-12 top-margin fmlProf">
                  Female Profiles
                </button>
              </div>
              <div class="col-md-6 ">
                <button name="profile_type" value="male_prof" id="male_prof" class="btn btn-default custom-btn btn-12 top-margin mlProf">
                  Male Profiles
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- <div class="genderFltrBtn row text-center">
    </div>        -->
    <!-- /.Find search section-->
  </div>
  <!-- slider end-->
  <div class=" section-space80  ">

    <!-- Feature Blog Start -->
    <div class="container">
      <div class="row forhight">
        <div class="col-md-12 col-12">
          <div class="section-title mb60 text-center mb_mt200 mb_pt50 mb_mt100">
            <h1 class="">Your specified Wedding Search gets easier here</h1>
            <!--<p class="text-dark">Special matrimony.</p>-->
          </div>
        </div>
      </div>
      <div class="row">
        <!-- feature center -->
        <div class="col-md-4 col-12 col-lg-4">
          <div class="feature-block feature-center">
            <!-- feature block -->
            <div class="feature-icon"><img src="images/vendor.svg" alt=""></div>
            <h2>Search worldwide without leaving your house.</h2>
            <p class="text-dark">Promote your profile without compromising your time and no traveling needed or no more telling you
              relatives.</p>
          </div>
        </div>
        <!-- /.feature block -->
        <div class="col-md-4 col-12 col-lg-4">
          <div class="feature-block feature-center">
            <!-- feature block -->
            <div class="feature-icon"><img src="images/mail.svg" alt=""></div>
            <h2>Findout about each other by Getting to know each other</h2>
            <p class="text-dark">Find out more about your match talk about your choices after you find your catergarised match.</p>
          </div>
        </div>
        <!-- /.feature block -->
        <div class="col-md-4 col-12 col-lg-4">
          <div class="feature-block feature-center">
            <!-- feature block -->
            <div class="feature-icon"><img src="images/couple.svg" alt=""></div>
            <h2>Get personalised filter for shortlisting profiles.</h2>
            <p class="text-dark">Get most option relative to your specifications ,and many option to choose from. pick what seems best for
              you.</p>
          </div>
        </div>
        <!-- /.feature block -->
      </div>
      <!-- /.feature center -->
    </div>




  </div>
  <!-- <hr class="dot" /> -->
  <!-- Feature Blog End -->
  <div class="main-container" id="search-by-detail">
    <div class="container ">
      <div class="tabFilter  col-md-12">
        <div class="well-box shadow">
          <div class="row">
            <div class="selectgender col-md-7">
              <h2 style="display:inline-block">Let's begine your search by looking at profiles! </h2>
              <p><small>First Select What you desire in your future partner.</small></p>
            </div>
            <div class="selectgender col-md-5">
              <label class="" for="gender">
                <h3>I'm Looking For</h3>
              </label>

              <div class="row">
                <div class="form-group  text-center">
                  <label class="mob-hm col-md-2 col-sm-6 col-xs-6" for="female">
                    <span class="text-dark">Female</span>
                    <input class=" input_gender" type="radio" onchange="selGender(this.value)" id="female" name="gender" value="Female" checked />
                  </label>
                  <label class="mob-hm col-md-2 col-sm-6 col-xs-6" for="male">
                    <span class="text-dark">Male</span>
                    <input class=" input_gender" type="radio" onchange="selGender(this.value)" id="male" name="gender" value="Male" />
                  </label>
                </div>
              </div>
            </div>

            <nav id="fmlPills">
              <ul class="nav nav-pills mb-3" id="pills-fml-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green active" name="countryTab" id="pills-cntry-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-cntry" type="button" role="tab" aria-controls="pills-cntry" aria-selected="true">country</button>
                </li>
                <li class="nav-item " role="presentation">
                  <button class="nav-link coral-green" name="stateTab" id="pills-state-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-state" type="button" role="tab" aria-controls="pills-state" aria-selected="false">state</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="cityTab" id="pills-city-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-city" type="button" role="tab" aria-controls="pills-city" aria-selected="false">city</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="religionTab" id="pills-relgn-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-relgn" type="button" role="tab" aria-controls="pills-relgn" aria-selected="false">Religion</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="casteTab" id="pills-caste-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-caste" type="button" role="tab" aria-controls="pills-caste" aria-selected="false">Caste</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="eduTab" id="pills-edu-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-edu" type="button" role="tab" aria-controls="pills-edu" aria-selected="false">Education</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="mediFieldTab" id="pills-medField-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-medField" type="button" role="tab" aria-controls="pills-medField" aria-selected="false">Medical Field</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="specTab" id="pills-spec-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-spec" type="button" role="tab" aria-controls="pills-spec" aria-selected="false">Specification</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="mothertngTab" id="pills-mthrTng-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-mthrTng" type="button" role="tab" aria-controls="pills-mthrTng" aria-selected="false">Mother Tongue</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="marStatTab" id="pills-marStat-fml-tab" data-bs-toggle="pill" data-bs-target="#pills-fml-marStat" type="button" role="tab" aria-controls="pills-marStat" aria-selected="false">Marital Status</button>
                </li>
              </ul>
              <div class="tab-content bg-white p_tab-content" id="pills-fml-tabContent">
                <div class="tab-pane fade show active row" id="pills-fml-cntry" role="tabpanel" aria-labelledby="pills-cntry-fml-tab">
                  <?php
                  $sqlC = "SELECT DISTINCT(country) FROM user_regiter  where `gender` = 'Female'";
                  $result = mysqli_query($conn, $sqlC);

                  while ($rows = mysqli_fetch_array($result)) {
                    $c_id = $rows['country'];
                    $where = "";
                    if (!empty($current_user_id))
                      $where = " and id != '$current_user_id' ";

                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `country` = $c_id AND `gender` = 'Female'   $where ");
                    $count = mysqli_num_rows($num_row);
                    $name = "SELECT * FROM `countries` WHERE `id` = $c_id";
                    $result1 = mysqli_query($conn, $name);
                    while ($row = mysqli_fetch_array($result1)) {
                  ?>
                      <a href="tabFilterProfiles.php?coldata=<?php echo $c_id; ?>&gender=Female" class="btn btn-default  col-md-2 mr20">
                        <?php echo $row['name'];
                        echo "(" . $count . ")"; ?>
                      </a>
                  <?php
                    }
                  }
                  ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-state" role="tabpanel" aria-labelledby="pills-state-fml-tab">
                  <?php
                  $sqlS = "SELECT DISTINCT(`state`) FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sqlS);
                  while ($rows = mysqli_fetch_array($result)) {
                    $s_id = $rows['state'];
                    // echo $s_id;
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `state` = $s_id   AND `gender` = 'Female'   $where ");
                    $count = mysqli_num_rows($num_row);
                    $name = "SELECT * FROM `states` WHERE `id` = $s_id";
                    $result2 = mysqli_query($conn, $name);
                    while ($row = mysqli_fetch_array($result2)) {
                  ?>

                      <a href="tabFilterProfiles.php?coldata=<?php echo $s_id; ?>&gender=Female" class="btn btn-default   col-md-2 mr20"><?php echo $row['name'];
                                                                                                                                          echo "(" . $count . ")";  ?></a>
                  <?php
                    }
                  }
                  ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-city" role="tabpanel" aria-labelledby="pills-city-fml-tab">
                  <?php
                  $sqlCt = "SELECT DISTINCT(`city`)  FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sqlCt);
                  while ($rows = mysqli_fetch_array($result)) {
                    $ct_id = $rows['city'];
                    // echo $ct_id;
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `city` = '$ct_id' AND `gender` = 'Female'  $where ");
                    $count = mysqli_num_rows($num_row);
                    $name = "SELECT * FROM `cities` WHERE `id` = $ct_id";
                    $result2 = mysqli_query($conn, $name);
                    while ($row = mysqli_fetch_array($result2)) {
                  ?>
                      <a href="tabFilterProfiles.php?coldata=<?php echo $ct_id; ?>&gender=Female" class="btn btn-default   col-md-2 mr20">
                        <?php echo $row['name'];
                        echo "(" . $count . ")";
                        ?>
                      </a>
                  <?php }
                  }
                  ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-relgn" role="tabpanel" aria-labelledby="pills-relgn-fml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(religion) FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($rows = mysqli_fetch_array($result)) {
                    $rel = $rows['religion'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `religion` = '$rel'  AND `gender` = 'Female' ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $rel; ?>&gender=Female" class="btn btn-default   col-md-2 mr20">
                      <?php echo $rows['religion'];
                      echo "(" . $count . ")";
                      ?>
                    </a>
                  <?php
                  }
                  ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-caste" role="tabpanel" aria-labelledby="pills-caste-fml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(`sub-com`) FROM user_regiter where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $cast = $row['sub-com'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `sub-com` = '$cast' and `gender` = 'Female'");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['sub-com']; ?>&gender=Female" class="btn btn-default   col-md-2 mr20"><?php echo $row['sub-com'];
                                                                                                                                                  echo "(" . $count . ")";  ?></a>
                  <?php  }   ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-edu" role="tabpanel" aria-labelledby="pills-edu-fml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(HighEdu) FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $edu = $row['HighEdu'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `HighEdu` = '$edu'  AND `gender` = 'Female' ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['HighEdu']; ?>&gender=Female" class="btn btn-default   col-md-2 mr20"><?php echo $row['HighEdu'];
                                                                                                                                                  echo "(" . $count . ")";  ?></a>
                  <?php }  ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-medField" role="tabpanel" aria-labelledby="pills-medField-fml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(prof) FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $prof = $row['prof'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `prof` = '$prof' and `gender` = 'Female'    $where ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['prof']; ?>&gender=Female" class="btn btn-default   col-md-2 mr20"><?php echo $prof;
                                                                                                                                              echo "(" . $count . ")";  ?></a>
                  <?php } ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-spec" role="tabpanel" aria-labelledby="pills-spec-fml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(specialization) FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $spec = $row['specialization'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `specialization` = '$spec'  AND `gender` = 'Female'   $where  ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['specialization']; ?>&gender=Female" class="btn btn-default   col-md-2 mr20"><?php echo $row['specialization'];
                                                                                                                                                        echo "(" . $count . ")";  ?></a>
                  <?php }
                  ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-mthrTng" role="tabpanel" aria-labelledby="pills-mthrTng-fml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(lang) FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $mT = $row['lang'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `lang` = '$mT'  AND `gender` = 'Female'   $where  ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['lang']; ?>&gender=Female" class="btn btn-default   col-md-2 mr20"><?php echo $row['lang'];
                                                                                                                                              echo "(" . $count . ")";  ?></a>
                  <?php }  ?>
                </div>

                <div class="tab-pane fade row" id="pills-fml-marStat" role="tabpanel" aria-labelledby="pills-marStat-fml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(marStat) FROM user_regiter  where `gender` = 'Female'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $mStat = $row['marStat'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `marStat` = '$mStat'  AND `gender` = 'Female'     $where ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['marStat']; ?>&gender=Female" class="btn btn-default   col-md-2 mr20"><?php echo $row['marStat'];
                                                                                                                                                  echo "(" . $count . ")";  ?></a>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </nav>

            <nav id="mlPills">
              <ul class="nav nav-pills mb-3" id="pills-ml-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green active" name="countryTab" id="pills-cntry-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-cntry" type="button" role="tab" aria-controls="pills-cntry" aria-selected="true">country</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="stateTab" id="pills-state-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-state" type="button" role="tab" aria-controls="pills-state" aria-selected="false">state</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="cityTab" id="pills-city-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-city" type="button" role="tab" aria-controls="pills-city" aria-selected="false">city</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="religionTab" id="pills-relgn-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-relgn" type="button" role="tab" aria-controls="pills-relgn" aria-selected="false">Religion</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="casteTab" id="pills-caste-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-caste" type="button" role="tab" aria-controls="pills-caste" aria-selected="false">Caste</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="eduTab" id="pills-edu-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-edu" type="button" role="tab" aria-controls="pills-edu" aria-selected="false">Education</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="mediFieldTab" id="pills-medField-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-medField" type="button" role="tab" aria-controls="pills-medField" aria-selected="false">Medical Field</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="specTab" id="pills-spec-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-spec" type="button" role="tab" aria-controls="pills-spec" aria-selected="false">Specification</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="mothertngTab" id="pills-mthrTng-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-mthrTng" type="button" role="tab" aria-controls="pills-mthrTng" aria-selected="false">Mother Tongue</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link coral-green" name="marStatTab" id="pills-marStat-ml-tab" data-bs-toggle="pill" data-bs-target="#pills-ml-marStat" type="button" role="tab" aria-controls="pills-marStat" aria-selected="false">Marital Status</button>
                </li>
              </ul>
              <div class="tab-content bg-white p_tab-content" id="pills-ml-tabContent">
                <div class="tab-pane fade show active row" id="pills-ml-cntry" role="tabpanel" aria-labelledby="pills-cntry-ml-tab">
                  <?php
                  $sqlC = "SELECT DISTINCT(country) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sqlC);
                  while ($rows = mysqli_fetch_array($result)) {
                    $c_id = $rows['country'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `country` = $c_id AND `gender` = 'Male'     $where ");
                    $count = mysqli_num_rows($num_row);
                    $name = "SELECT * FROM `countries` WHERE `id` = $c_id";
                    $result1 = mysqli_query($conn, $name);
                    while ($row = mysqli_fetch_array($result1)) {
                  ?>
                      <a href="tabFilterProfiles.php?coldata=<?php echo $c_id; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['name'];
                                                                                                                                      echo "(" . $count . ")";  ?></a>
                  <?php
                    }
                  }
                  ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-state" role="tabpanel" aria-labelledby="pills-state-ml-tab">
                  <?php
                  $sqlS = "SELECT DISTINCT(`state`) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sqlS);
                  while ($rows = mysqli_fetch_array($result)) {
                    $s_id = $rows['state'];
                    // echo $s_id;
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `state` = $s_id   AND `gender` = 'Male'   $where ");
                    $count = mysqli_num_rows($num_row);
                    $name = "SELECT * FROM `states` WHERE `id` = $s_id";
                    $result2 = mysqli_query($conn, $name);
                    while ($row = mysqli_fetch_array($result2)) {
                  ?>
                      <a href="tabFilterProfiles.php?coldata=<?php echo $s_id; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['name'];
                                                                                                                                      echo "(" . $count . ")";  ?></a>
                  <?php
                    }
                  }
                  ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-city" role="tabpanel" aria-labelledby="pills-city-ml-tab">
                  <?php
                  $sqlCt = "SELECT DISTINCT(`city`)  FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sqlCt);
                  while ($rows = mysqli_fetch_array($result)) {
                    $ct_id = $rows['city'];
                    // echo $ct_id;
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `city` = '$ct_id' AND `gender` = 'Male'    $where ");
                    $count = mysqli_num_rows($num_row);
                    $name = "SELECT * FROM `cities` WHERE `id` = $ct_id";
                    $result2 = mysqli_query($conn, $name);
                    while ($row = mysqli_fetch_array($result2)) {
                  ?>
                      <a href="tabFilterProfiles.php?coldata=<?php echo $ct_id; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['name'];
                                                                                                                                      echo "(" . $count . ")";  ?></a>
                  <?php }
                  }
                  ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-relgn" role="tabpanel" aria-labelledby="pills-relgn-ml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(religion) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $rel = $row['religion'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `religion` = '$rel'  AND `gender` = 'Male'    $where ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['religion']; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['religion'];
                                                                                                                                              echo "(" . $count . ")";  ?></a>
                  <?php
                  }
                  ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-caste" role="tabpanel" aria-labelledby="pills-caste-ml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(`sub-com`) FROM user_regiter where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $cast = $row['sub-com'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `sub-com` = '$cast' and `gender` = 'Male'   $where ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['sub-com']; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['sub-com'];
                                                                                                                                              echo "(" . $count . ")";  ?></a>
                  <?php  }   ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-edu" role="tabpanel" aria-labelledby="pills-edu-ml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(HighEdu) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $edu = $row['HighEdu'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `HighEdu` = '$edu'  AND `gender` = 'Male'    $where ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['HighEdu']; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['HighEdu'];
                                                                                                                                              echo "(" . $count . ")";  ?></a>
                  <?php }  ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-medField" role="tabpanel" aria-labelledby="pills-medField-ml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(prof) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $prof = $row['prof'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `prof` = '$prof' and `gender` = 'Male'    $where ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['prof']; ?>&gender=Male" class="btn btn-default col-md-2 mr20">
                      <?php echo $prof;
                      echo "(" . $count . ")";  ?>
                    </a>
                  <?php } ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-spec" role="tabpanel" aria-labelledby="pills-spec-ml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(specialization) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $spec = $row['specialization'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` where `specialization` = '$spec'  AND `gender` = 'Male'   $where  ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['specialization']; ?>&gender=Male" class="btn btn-default col-md-2 mr20">
                      <?php echo $row['specialization'];
                      echo "(" . $count . ")";  ?>
                    </a>
                  <?php }
                  ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-mthrTng" role="tabpanel" aria-labelledby="pills-mthrTng-ml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(lang) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $mT = $row['lang'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `lang` = '$mT'  AND `gender` = 'Male'    $where ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['lang']; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['lang'];
                                                                                                                                          echo "(" . $count . ")";  ?></a>
                  <?php }  ?>
                </div>
                <div class="tab-pane fade row" id="pills-ml-marStat" role="tabpanel" aria-labelledby="pills-marStat-ml-tab">
                  <?php
                  $sql = "SELECT DISTINCT(marStat) FROM user_regiter  where `gender` = 'Male'   $where ";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $mStat = $row['marStat'];
                    $num_row = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `marStat` = '$mStat'  AND `gender` = 'Male'   $where   ");
                    $count = mysqli_num_rows($num_row);
                  ?>
                    <a href="tabFilterProfiles.php?coldata=<?php echo $row['marStat']; ?>&gender=Male" class="btn btn-default col-md-2 mr20"><?php echo $row['marStat'];
                                                                                                                                              echo "(" . $count . ")";  ?></a>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </nav>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-space80 ">
    <!-- top location -->
    <div class="container">
      <div class="row text-center">
        <div class="col-md-12 ">
          <div class="section-title mb60 ">
            <h1> A Journey</h1>
            <p class="text-dark">from Single to Happily Married to Your Dream Partner.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 location-block">
          <!-- location block -->
          <div class="vendor-image">
            <a href="#"><img src="images/location-pic.jpg" alt="" class="img-responsive"></a> <a href="#" class="venue-lable"><span class="label label-default">Rajasthan</span></a>
          </div>
        </div> <!-- /.location block -->
        <div class="col-md-4 location-block">
          <!-- location block -->
          <div class="vendor-image">
            <a href="#"><img src="images/location-pic-2.jpg" alt="" class="img-responsive"></a> <a href="#" class="venue-lable"><span class="label label-default">Goa</span></a>
          </div>
        </div> <!-- /.location block -->
        <div class="col-md-4 location-block">
          <!-- location block -->
          <div class="vendor-image">
            <a href="#"><img src="images/location-pic-3.jpg" alt="" class="img-responsive"></a> <a href="#" class="venue-lable"><span class="label label-default">Mumbai</span></a>
          </div>
        </div> <!-- /.location block -->
        <div class="col-md-8 location-block">
          <!-- location block -->
          <div class="vendor-image">
            <a href="#"><img src="images/location-pic-4.jpg" alt="" class="img-responsive"></a> <a href="#" class="venue-lable"><span class="label label-default">chennai</span></a>
          </div>
        </div> <!-- /.location block -->
        <div class="col-md-4 location-block">
          <!-- location block -->
          <div class="vendor-image">
            <a href="#"><img src="images/location-pic-5.jpg" alt="" class="img-responsive"></a> <a href="#" class="venue-lable"><span class="label label-default">Pune</span></a>
          </div>
        </div> <!-- /.location block -->
      </div>
    </div>
  </div>
  <!-- /.top location -->
  <div class="section-space80  bg-toptoran" style="background-color: #f4f2ec;">
    <!-- Testimonial Section -->
    <div class="container">
      <div class="row">
        <div class="col-md-12 pt40">
          <div class="section-title mb60 text-center">
            <h1>Married Happy Couple</h1>
            <!-- <p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.</p> -->
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 tp-testimonial">
          <div id="testimonial" class="owl-carousel owl-theme">
            <?php
            $sql = mysqli_query($conn, " SELECT * FROM `success_story` ORDER BY RAND() LIMIT 6 ");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
              <div class="item testimonial-block">
                <div class="couple-pic"><img src="./admin/couple_img/<?php echo $row['filename']; ?>" alt="" class="img-circle" height="150px" width="150px"></div>
                <div class="feedback-caption">
                  <p>"<?php echo $row['message']; ?>."</p>
                </div>
                <div class="couple-info">
                  <div class="name"><?php echo $row['name']; ?></div>
                  <div class="date"><?php echo $row['location']; ?></div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    #mlPills {
      display: none;
    }
  </style>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <?php
  include 'footer.php';
  ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery.min.js"></script>
  <script src="admin/js/sb-admin-2.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Flex Nav Script -->
  <script src="js/jquery.flexnav.js" type="text/javascript"></script>
  <script src="js/navigation.js"></script>
  <!-- slider -->
  <script src="js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="js/slider.js"></script>
  <!-- testimonial -->
  <script type="text/javascript" src="js/testimonial.js"></script>
  <!-- sticky header -->
  <script src="js/jquery.sticky.js"></script>
  <script src="js/header-sticky.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    $("#filter_search_btn").on("click", function() {
      // alert()
      var flag = true;
      $('.required_f ').each(function() {
        var this_val = $(this).val();
        console.log('this_val ' + this_val);
        if (this_val == '') {
          // console.log('blank val');
          $(this).css('border', '3px solid red');
          flag = false;
        } else {
          $(this).css('border', '1px solid #e9e6e0');
        }
        // alert();
      });
      if (!flag) {
        swal({
          title: "Oops..",
          text: "Required fields are missing",
          icon: "error",
          buttons: true,
          dangerMode: true,
        })
      }
      return flag;
    });

    function selGender(name) {
      // alert(name);
      if (name == 'Female') {
        $('#fmlPills').show();
        $('#mlPills').hide();
      } else if (name == 'Male') {
        $('#mlPills').show();
        $('#fmlPills').hide();
      }
    }

    // backpress reload 
    window.addEventListener("pageshow", function(event) {
      var historyTraversal = event.persisted ||
        (typeof window.performance != "undefined" &&
          window.performance.navigation.type === 2);
      if (historyTraversal) {
        // Handle page restore.
        window.location.reload();
      }
    });
  </script>
</body>

</html>