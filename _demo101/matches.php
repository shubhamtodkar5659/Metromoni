<?php
session_start();
include 'dbconn.php';
$u_id = $_SESSION['id'];
if (isset($u_id)) {
  $ur = "";
  $ua = "";
  $ug = "";
  $sql = "SELECT * FROM `user_regiter` where `id` = " . $_SESSION['id'];
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $ua = $row['age'];
    $ur = $row['religion'];
    $ug = $row['gender'];
  }
  if (isset($_POST['send_btn'])) {
    // $usrid = $_POST['usr_id'];
    $send_id = $_POST['send_id'];
    $sql2 = mysqli_query($conn, "INSERT INTO `requests`(`user_id`, `sent_id`) VALUES ('$u_id','$send_id')");
    if ($sql2) {
?>
      <script>
        alert("request sent successfuly");
      </script>
    <?php
    }
  }
  if (isset($_POST['delete_btn'])) {
    $del = $_POST['delete_id'];
    $sql = mysqli_query($conn, "DELETE FROM `requests` WHERE `user_id` =  '$u_id' AND `sent_id` = '$del' ");
    if ($sql) {
      // print_r($del);
    ?>
      <script>
        alert("request deleted successfuly");
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>My Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Custom styles for this template-->
    <link href="./admin/css/styleAdmin.css" rel="stylesheet">
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
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
          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Page Heading -->
            <div class="vendor-list-block card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">My Matches</h6>
              </div>
              <div class="card-body ">
                <div class="row profile mb-4">
                  <?php
                  $currentDate = date("Y-m-d");
                  $check = mysqli_query($conn, "SELECT * FROM `user_regiter` where `id` = '$u_id'  ");
                  $r = mysqli_fetch_array($check);
                  if ($r['community-checkbox'] != "") {
                    $status = "";
                    if ($ug == 'Female') {
                      $sql1 = "SELECT * FROM `user_regiter` WHERE `gender`='male' AND `age`>= '$ua' AND `status` != 0 ";
                      $result1 = mysqli_query($conn, $sql1);
                      while ($row = mysqli_fetch_array($result1)) {
                        $expiry = $row['plan_expiry_date'];
                        if ($expiry >= $currentDate) {
                          $abcdf = mysqli_query($conn, "SELECT * FROM `shortlist` where `user_id`= '$_SESSION[id]' AND  `liked_p_id` = '$row[id]'");
                          while ($num1 = mysqli_fetch_assoc($abcdf)) {
                            $status = $num1['status'];
                          }
                          $count = mysqli_num_rows($abcdf);
                          if ($status == 1 && $status != "" && $count != 0) {
                            // while ($num = mysqli_fetch_assoc($abcdf)) {
                  ?>
                            <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface">
                              <div class="vendor-list-block mb30 shadow card ">
                                <!-- match list block -->
                                <div class="vendor-img gradient-top" style="width: 100%;">
                                  <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                  <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                  <div class="<?php echo $row['label'] ?>"></div>
                                  <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                  <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                  <div class="price-lable"><?php echo $row['age']; ?></div>
                                  <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                </div>
                                <div class="card-body vendor-detail">
                                  <!-- Match details -->
                                  <div class="caption">
                                    <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                          echo $pieces[0]; ?></h2>
                                    <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                    <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                        <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                        $resultid = mysqli_query($conn, $sql1);
                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                          echo strtoupper($rowid['name']);
                                        } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                echo strtoupper($rowid['name']);
                                              } ?></span>
                                      <div>                                       
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3" name="view_user"><i class="fas fa-eye"></i></button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.Match details -->
                              </div>
                              <!-- /.match list block -->
                              <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="" method="post">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        Do You Really Want to Delete this Request?
                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                              <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="" method="post">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="example">Confirm To send?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                              <!-- ---------view users ----------- -->
                              <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                  <!-- Modal User Profile View -->
                                  <div class="modal-content">
                                    <div class="modal-header card-header ">
                                      <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body " style="padding: 2rem;">
                                      <!-- Begin Page Content -->
                                      <!-- <div class="container-fluid"> -->
                                      <!-- Page Heading -->
                                      <div class="row card shadow mb-4">
                                        <!-- Profil card -->
                                        <!-- <div class="card shadow mb-4"> -->
                                        <div class="card-header py-3">
                                          <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                        </div>
                                        <div class="card-body col-lmd-12">
                                          <div class="row" style="line-height: 2;">
                                            <div class="col-md-4">
                                              <div class="text-center">
                                                <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                              <b>Name :</b> <?php echo $row['name']; ?><br>
                                              <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                              <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                              <?php
                                              $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php
                                              }
                                              $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  }
                                              $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                // echo $row['city'];
                                              ?>
                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  } ?>
                                              <b>Address :</b> <?php echo $row['address']; ?><br>
                                              <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                              <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                              <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                              <b>Height :</b> <?php echo $row['height']; ?><br>
                                              <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                              <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                            </div>
                                            <div class="col-md-4">
                                              <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                              <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                              <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                              <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                              <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                              <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                              <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                              <b>Income :</b> <?php echo $row['income']; ?> <br>
                                              <?php
                                              $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                              if ($res) {
                                              ?>
                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                              <?php
                                              }
                                              ?>
                                            </div>

                                            <!-- </ul> -->
                                          </div>
                                        </div>
                                      </div>
                                      <!-- </div> -->
                                      <!-- </div> -->
                                      <div class="modal-footer">
                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end Modal User Profile View -->
                                </div>
                              </div>
                            </div>
                          <?php
                          } else if ($status == 0 || $count <= 0 || $status == "") {
                            if ($status == "" && $user_id == $row['id']) {
                              continue;
                            } // while ($num = mysqli_fetch_assoc($abcdf)){
                          ?>
                            <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface ">
                              <div class="vendor-list-block mb30 shadow card ">
                                <!-- match list block -->
                                <div class="vendor-img gradient-top" style="width: 100%;">
                                  <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                  <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                  <div class="<?php echo $row['label'] ?>"></div>
                                  <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' ></i></button> "; ?></div>
                                  <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                  <div class="price-lable"><?php echo $row['age']; ?></div>
                                  <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                </div>
                                <div class="card-body vendor-detail">
                                  <!-- Match details -->
                                  <div class="caption">
                                    <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                          echo $pieces[0]; ?></h2>
                                    <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                    <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                        <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                        $resultid = mysqli_query($conn, $sql1);
                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                          echo strtoupper($rowid['name']);
                                        } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                echo strtoupper($rowid['name']);
                                              } ?></span>
                                      <div >
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>

                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.Match details -->
                              </div>
                              <!-- /.match list block -->
                              <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="" method="post">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        Do You Really Want to Delete this Request?
                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                              <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="" method="post">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="example">Confirm To send?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                              <!-- ---------view users ----------- -->
                              <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                  <form method="POST" action="">
                                    <!-- Modal User Profile View -->
                                    <div class="modal-content">
                                      <div class="modal-header card-header ">
                                        <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body " style="padding: 2rem;">
                                        <!-- Begin Page Content -->
                                        <!-- <div class="container-fluid"> -->
                                        <!-- Page Heading -->
                                        <div class="row card shadow mb-4">
                                          <!-- Profil card -->
                                          <!-- <div class="card shadow mb-4"> -->
                                          <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                          </div>
                                          <div class="card-body col-lmd-12">
                                            <div class="row" style="line-height: 2;">
                                              <div class="col-md-4">
                                                <div class="text-center">
                                                  <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                </div>
                                              </div>
                                              <div class="col-md-4">
                                                <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                                <b>Name :</b> <?php echo $row['name']; ?><br>
                                                <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                                <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                                <?php
                                                $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                                $resultid = mysqli_query($conn, $sql1);
                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                ?>
                                                  <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                <?php
                                                }
                                                $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                                $resultid = mysqli_query($conn, $sql1);
                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                ?>
                                                  <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                <?php  }
                                                $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                $resultid = mysqli_query($conn, $sql1);
                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                  // echo $row['city'];
                                                ?>
                                                  <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                <?php  } ?>
                                                <b>Address :</b> <?php echo $row['address']; ?><br>
                                                <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                <b>Height :</b> <?php echo $row['height']; ?><br>
                                                <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                              </div>
                                              <div class="col-md-4">
                                                <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                                <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                                <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                                <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                                <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                                <b>Income :</b> <?php echo $row['income']; ?> <br>
                                                <?php
                                                $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                                if ($res) {
                                                ?>
                                                  <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                                <?php
                                                }
                                                ?>
                                              </div>

                                              <!-- </ul> -->
                                            </div>
                                          </div>
                                        </div>
                                        <!-- </div> -->
                                        <!-- </div> -->
                                        <div class="modal-footer">
                                          <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                          <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                    </div>
                                    <!--end Modal User Profile View -->
                                  </form>
                                </div>
                              </div>
                            </div>
                    <?php }
                        }
                      }
                    } ?>
                </div>
                <div class="row shadow mb-4">
                  <?php
                    $status = "";
                    $currentDate = date("Y-m-d");
                    if ($ug == 'Male') {
                      $sql2 = "SELECT * FROM `user_regiter` WHERE `gender`='female' AND `age`<= '$ua'  ";
                      $result2 = mysqli_query($conn, $sql2);
                      while ($row = mysqli_fetch_array($result2)) {
                        $expiry = $row['plan_expiry_date'];
                        if ($expiry >= $currentDate) {
                          $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' AND `status` != 0 ");
                          $countusr = mysqli_num_rows($clr);
                          while ($num1 = mysqli_fetch_array($clr)) {
                            $status = $num1['status'];
                          }
                          $count = mysqli_num_rows($clr);
                          if ($status == 1 && $status != "" && $count != 0) {
                  ?>
                          <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface ">
                            <div class="vendor-list-block mb30 shadow card ">
                              <!-- match list block -->
                              <div class="vendor-img gradient-top" style="width: 100%;">
                                <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                <div class="<?php echo $row['label'] ?>"></div>
                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                              </div>
                              <div class="card-body vendor-detail">
                                <!-- Match details -->
                                <div class="caption">
                                  <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                        echo $pieces[0]; ?></h2>
                                  <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                  <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                      <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                      $resultid = mysqli_query($conn, $sql1);
                                      while ($rowid = mysqli_fetch_array($resultid)) {
                                        echo strtoupper($rowid['name']);
                                      } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                            $resultid = mysqli_query($conn, $sql1);
                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                              echo strtoupper($rowid['name']);
                                            } ?></span>
                                    <div >
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>

                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.Match details -->
                            </div>
                            <!-- /.match list block -->
                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to Delete this Request?
                                      <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To send?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                      <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                      <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- /.match list block -->
                            <!-- ---------view users ----------- -->
                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <form method="POST" action="">
                                  <!-- Modal User Profile View -->
                                  <div class="modal-content">
                                    <div class="modal-header card-header ">
                                      <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body " style="padding: 2rem;">
                                      <!-- Begin Page Content -->
                                      <!-- <div class="container-fluid"> -->
                                      <!-- Page Heading -->
                                      <div class="row card shadow mb-4">
                                        <!-- Profil card -->
                                        <!-- <div class="card shadow mb-4"> -->
                                        <div class="card-header py-3">
                                          <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                        </div>
                                        <div class="card-body col-lmd-12">
                                          <div class="row" style="line-height: 2;">
                                            <div class="col-md-4">
                                              <div class="text-center">
                                                <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                              <b>Name :</b> <?php echo $row['name']; ?><br>
                                              <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                              <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                              <?php
                                              $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php
                                              }
                                              $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  }
                                              $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                // echo $row['city'];
                                              ?>
                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  } ?>
                                              <b>Address :</b> <?php echo $row['address']; ?><br>
                                              <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                              <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                              <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                              <b>Height :</b> <?php echo $row['height']; ?><br>
                                              <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                              <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                            </div>
                                            <div class="col-md-4">
                                              <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                              <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                              <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                              <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                              <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                              <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                              <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                              <b>Income :</b> <?php echo $row['income']; ?> <br>
                                              <?php
                                              $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                              if ($res) {
                                              ?>
                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                              <?php
                                              }
                                              ?>
                                            </div>

                                            <!-- </ul> -->
                                          </div>
                                        </div>
                                      </div>
                                      <!-- </div> -->
                                      <!-- </div> -->
                                      <div class="modal-footer">
                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end Modal User Profile View -->
                                </form>
                              </div>
                            </div>
                          </div>
                        <?php } else if ($status == 0 || $count <= 0 || $status == "") {
                            if ($status == "" && $user_id == $row['id']) {
                              continue;
                            } ?>
                          <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface ">
                            <div class="vendor-list-block mb30 shadow card ">
                              <!-- match list block -->
                              <div class="vendor-img gradient-top" style="width: 100%;">
                                <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                <div class="<?php echo $row['label'] ?>"></div>
                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                              </div>
                              <div class="card-body vendor-detail">
                                <!-- Match details -->
                                <div class="caption">
                                  <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                        echo $pieces[0]; ?></h2>
                                  <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                  <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                      <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                      $resultid = mysqli_query($conn, $sql1);
                                      while ($rowid = mysqli_fetch_array($resultid)) {
                                        echo strtoupper($rowid['name']);
                                      } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                            $resultid = mysqli_query($conn, $sql1);
                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                              echo strtoupper($rowid['name']);
                                            } ?></span>
                                    <div >
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button> <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>

                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.Match details -->
                              <!-- /.match list block -->
                              <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="" method="post">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        Do You Really Want to Delete this Request?
                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                              <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="" method="post">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="example">Confirm To send?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>                       
                            <!-- /.match list block -->
                            <!-- ---------view users ----------- -->
                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <form method="POST" action="">
                                  <!-- Modal User Profile View -->
                                  <div class="modal-content">
                                    <div class="modal-header card-header ">
                                      <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body " style="padding: 2rem;">
                                      <!-- Begin Page Content -->
                                      <!-- <div class="container-fluid"> -->
                                      <!-- Page Heading -->
                                      <div class="row card shadow mb-4">
                                        <!-- Profil card -->
                                        <!-- <div class="card shadow mb-4"> -->
                                        <div class="card-header py-3">
                                          <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                        </div>
                                        <div class="card-body col-lmd-12">
                                          <div class="row" style="line-height: 2;">
                                            <div class="col-md-4">
                                              <div class="text-center">
                                                <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                              <b>Name :</b> <?php echo $row['name']; ?><br>
                                              <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                              <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                              <?php
                                              $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php
                                              }
                                              $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  }
                                              $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                // echo $row['city'];
                                              ?>
                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  } ?>
                                              <b>Address :</b> <?php echo $row['address']; ?><br>
                                              <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                              <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                              <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                              <b>Height :</b> <?php echo $row['height']; ?><br>
                                              <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                              <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                            </div>
                                            <div class="col-md-4">
                                              <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                              <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                              <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                              <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                              <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                              <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                              <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                              <b>Income :</b> <?php echo $row['income']; ?> <br>
                                              <?php
                                              $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                              if ($res) {
                                              ?>
                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                              <?php
                                              }
                                              ?>
                                            </div>

                                            <!-- </ul> -->
                                          </div>
                                        </div>
                                      </div>
                                      <!-- </div> -->
                                      <!-- </div> -->
                                      <div class="modal-footer">
                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end Modal User Profile View -->
                                </form>
                              </div>
                            </div>
                            </div>
                          </div>
                        <?php }
                        }
                      }
                    }
                  } else {
                    $status = "";
                    $currentDate = date("Y-m-d");

                    if ($ug == 'Female') {
                      $sql1 = "SELECT * FROM `user_regiter` WHERE `gender`='male' AND `age`>= '$ua' AND `religion`= '$ur'   ";
                      $result1 = mysqli_query($conn, $sql1);
                      while ($row = mysqli_fetch_array($result1)) {
                        $expiry = $row['plan_expiry_date'];
                        if ($expiry >= $currentDate) {
                          $clr = "SELECT * FROM `shortlist` where `user_id`= '$_SESSION[id]' AND  `liked_p_id` = '$row[id]' AND `status` != 0 ";
                          $abcdf = mysqli_query($conn, $clr);
                          while ($num1 = mysqli_fetch_assoc($abcdf)) {
                            $status = $num1['status'];
                          }
                          $count = mysqli_num_rows($abcdf);
                          if ($status == 1 && $status != "" && $count != 0) {
                            // while ($num = mysqli_fetch_assoc($abcdf)) {
                        ?>
                          <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface ">
                            <div class="vendor-list-block mb30 shadow card ">
                              <!-- match list block -->
                              <div class="vendor-img gradient-top" style="width: 100%;">
                                <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                <div class="<?php echo $row['label'] ?>"></div>
                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                              </div>
                              <div class="card-body vendor-detail">
                                <!-- Match details -->
                                <div class="caption">
                                  <h2 class="title"> <?php echo $row['name']; ?></h2>
                                  <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                        echo $pieces[0]; ?></h2>
                                  <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                      <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                      $resultid = mysqli_query($conn, $sql1);
                                      while ($rowid = mysqli_fetch_array($resultid)) {
                                        echo strtoupper($rowid['name']);
                                      } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                            $resultid = mysqli_query($conn, $sql1);
                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                              echo strtoupper($rowid['name']);
                                            } ?></span>
                                    <div >
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>

                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.Match details -->
                            </div>
                            <!-- /.match list block -->
                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to Delete this Request?
                                      <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To send?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                      <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                      <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- /.match list block -->
                            <!-- ---------view users ----------- -->
                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <form method="POST" action="">
                                  <!-- Modal User Profile View -->
                                  <div class="modal-content">
                                    <div class="modal-header card-header ">
                                      <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body " style="padding: 2rem;">
                                      <!-- Begin Page Content -->
                                      <!-- <div class="container-fluid"> -->
                                      <!-- Page Heading -->
                                      <div class="row card shadow mb-4">
                                        <!-- Profil card -->
                                        <!-- <div class="card shadow mb-4"> -->
                                        <div class="card-header py-3">
                                          <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                        </div>
                                        <div class="card-body col-lmd-12">
                                          <div class="row" style="line-height: 2;">
                                            <div class="col-md-4">
                                              <div class="text-center">
                                                <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                              <b>Name :</b> <?php echo $row['name']; ?><br>
                                              <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                              <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                              <?php
                                              $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php
                                              }
                                              $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  }
                                              $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                // echo $row['city'];
                                              ?>
                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  } ?>
                                              <b>Address :</b> <?php echo $row['address']; ?><br>
                                              <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                              <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                              <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                              <b>Height :</b> <?php echo $row['height']; ?><br>
                                              <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                              <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                            </div>
                                            <div class="col-md-4">
                                              <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                              <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                              <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                              <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                              <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                              <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                              <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                              <b>Income :</b> <?php echo $row['income']; ?> <br>
                                              <?php
                                              $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                              if ($res) {
                                              ?>
                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                              <?php
                                              }
                                              ?>
                                            </div>

                                            <!-- </ul> -->
                                          </div>
                                        </div>
                                      </div>
                                      <!-- </div> -->
                                      <!-- </div> -->
                                      <div class="modal-footer">
                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end Modal User Profile View -->
                                </form>
                              </div>
                            </div>
                          </div>
                        <?php // }
                          } else if ($status == 0 || $count <= 0 || $status == "") {
                            if ($status == "" && $user_id == $row['id']) {
                              continue;
                            } // while ($num = mysqli_fetch_assoc($abcdf)){
                        ?>
                          <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface ">
                            <div class="vendor-list-block mb30 shadow card ">
                              <!-- match list block -->
                              <div class="vendor-img gradient-top" style="width: 100%;">
                                <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                <div class="<?php echo $row['label'] ?>"></div>
                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' ></i></button> "; ?></div>
                                <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                              </div>
                              <div class="card-body vendor-detail">
                                <!-- Match details -->
                                <div class="caption">
                                  <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                        echo $pieces[0]; ?></h2>
                                  <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                  <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                      <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                      $resultid = mysqli_query($conn, $sql1);
                                      while ($rowid = mysqli_fetch_array($resultid)) {
                                        echo strtoupper($rowid['name']);
                                      } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                            $resultid = mysqli_query($conn, $sql1);
                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                              echo strtoupper($rowid['name']);
                                            } ?></span>
                                    <div >
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.Match details -->
                            </div>
                            <!-- /.match list block -->
                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to Delete this Request?
                                      <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To send?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                      <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                      <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- /.match list block -->
                            <!-- ---------view users ----------- -->
                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <form method="POST" action="">
                                  <!-- Modal User Profile View -->
                                  <div class="modal-content">
                                    <div class="modal-header card-header ">
                                      <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body " style="padding: 2rem;">
                                      <!-- Begin Page Content -->
                                      <!-- <div class="container-fluid"> -->
                                      <!-- Page Heading -->
                                      <div class="row card shadow mb-4">
                                        <!-- Profil card -->
                                        <!-- <div class="card shadow mb-4"> -->
                                        <div class="card-header py-3">
                                          <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                        </div>
                                        <div class="card-body col-lmd-12">
                                          <div class="row" style="line-height: 2;">
                                            <div class="col-md-4">
                                              <div class="text-center">
                                                <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                              <b>Name :</b> <?php echo $row['name']; ?><br>
                                              <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                              <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                              <?php
                                              $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php
                                              }
                                              $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  }
                                              $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                // echo $row['city'];
                                              ?>
                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  } ?>
                                              <b>Address :</b> <?php echo $row['address']; ?><br>
                                              <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                              <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                              <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                              <b>Height :</b> <?php echo $row['height']; ?><br>
                                              <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                              <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                            </div>
                                            <div class="col-md-4">
                                              <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                              <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                              <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                              <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                              <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                              <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                              <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                              <b>Income :</b> <?php echo $row['income']; ?> <br>
                                              <?php
                                              $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                              if ($res) {
                                              ?>
                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                              <?php
                                              }
                                              ?>
                                            </div>

                                            <!-- </ul> -->
                                          </div>
                                        </div>
                                      </div>
                                      <!-- </div> -->
                                      <!-- </div> -->
                                      <div class="modal-footer">
                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end Modal User Profile View -->
                                </form>
                              </div>
                            </div>
                          </div>
                  <?php //}
                          }
                        }
                      }
                    } ?>
                </div>

                <div class="row  mb-4">
                  <?php
                    $status = "";
                    $currentDate = date("Y-m-d");
                    if ($ug == 'Male') {
                      $sql2 = "SELECT * FROM `user_regiter` WHERE `gender`='female' AND `age`<= '$ua' AND `religion`= '$ur'  ";
                      $result2 = mysqli_query($conn, $sql2);
                      while ($row = mysqli_fetch_array($result2)) {
                        $expiry = $row['plan_expiry_date'];
                        if ($expiry >= $currentDate) {
                          $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' AND `status` != 0 ");
                          while ($num1 = mysqli_fetch_array($clr)) {
                            $status = $num1['status'];
                          }
                          $count = mysqli_num_rows($clr);
                          if ($status == 1 && $status != "" && $count != 0) {
                  ?>
                          <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface ">
                            <div class="vendor-list-block mb30 shadow card ">
                              <!-- match list block -->
                              <div class="vendor-img gradient-top" style="width: 100%;">
                                <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                <div class="<?php echo $row['label'] ?>"></div>
                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                              </div>
                              <div class="card-body vendor-detail">
                                <!-- Match details -->
                                <div class="caption">
                                  <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                        echo $pieces[0]; ?></h2>
                                  <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                  <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                      <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                      $resultid = mysqli_query($conn, $sql1);
                                      while ($rowid = mysqli_fetch_array($resultid)) {
                                        echo strtoupper($rowid['name']);
                                      } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                            $resultid = mysqli_query($conn, $sql1);
                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                              echo strtoupper($rowid['name']);
                                            } ?></span>
                                    <div >
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>

                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.Match details -->
                            </div>
                            <!-- /.match list block -->
                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to Delete this Request?
                                      <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To send?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                      <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                      <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- /.match list block -->
                            <!-- ---------view users ----------- -->
                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <form method="POST" action="">
                                  <!-- Modal User Profile View -->
                                  <div class="modal-content">
                                    <div class="modal-header card-header ">
                                      <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body " style="padding: 2rem;">
                                      <!-- Begin Page Content -->
                                      <!-- <div class="container-fluid"> -->
                                      <!-- Page Heading -->
                                      <div class="row card shadow mb-4">
                                        <!-- Profil card -->
                                        <!-- <div class="card shadow mb-4"> -->
                                        <div class="card-header py-3">
                                          <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                        </div>
                                        <div class="card-body col-lmd-12">
                                          <div class="row" style="line-height: 2;">
                                            <div class="col-md-4">
                                              <div class="text-center">
                                                <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                              <b>Name :</b> <?php echo $row['name']; ?><br>
                                              <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                              <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                              <?php
                                              $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php
                                              }
                                              $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  }
                                              $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                // echo $row['city'];
                                              ?>
                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  } ?>
                                              <b>Address :</b> <?php echo $row['address']; ?><br>
                                              <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                              <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                              <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                              <b>Height :</b> <?php echo $row['height']; ?><br>
                                              <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                              <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                            </div>
                                            <div class="col-md-4">
                                              <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                              <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                              <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                              <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                              <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                              <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                              <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                              <b>Income :</b> <?php echo $row['income']; ?> <br>
                                              <?php
                                              $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                              if ($res) {
                                              ?>
                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                              <?php
                                              }
                                              ?>
                                            </div>

                                            <!-- </ul> -->
                                          </div>
                                        </div>
                                      </div>
                                      <!-- </div> -->
                                      <!-- </div> -->
                                      <div class="modal-footer">
                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end Modal User Profile View -->
                                </form>
                              </div>
                            </div>
                          </div>
                        <?php } else if ($status == 0 || $count <= 0 || $status == "") {
                            if ($status == "" && $user_id == $row['id']) {
                              continue;
                            } ?>
                          <div class="col-md-4 col-sm-8  col-lg-2  mt-4 surface ">
                            <div class="vendor-list-block mb30 shadow card ">
                              <!-- match list block -->
                              <div class="vendor-img gradient-top" style="width: 100%;">
                                <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                <!-- <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>"  class="btn mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                <div class="<?php echo $row['label'] ?>"></div>
                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                <div class="category-badge" class="category-link"><?php echo $row['specialization']; ?></div>
                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                              </div>
                              <div class="card-body vendor-detail">
                                <!-- Match details -->
                                <div class="caption">
                                  <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                        echo $pieces[0]; ?></h2>
                                  <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                  <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                      <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                      $resultid = mysqli_query($conn, $sql1);
                                      while ($rowid = mysqli_fetch_array($resultid)) {
                                        echo strtoupper($rowid['name']);
                                      } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                            $resultid = mysqli_query($conn, $sql1);
                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                              echo strtoupper($rowid['name']);
                                            } ?></span>
                                    <div >
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                      <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" name="view_user" class="btn btn-sm col-3 btn-warning mt-3"><i class="fas fa-eye"></i></button>

                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.Match details -->
                            </div>
                            <!-- /.match list block -->
                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to Delete this Request?
                                      <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="modal fade" id="send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="example">Confirm To send?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Do You Really Want to send this Request to <?php echo $row['name']; ?>?
                                      <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                      <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button name="send_btn" type="submit" class="btn btn-danger" id="send_btn">Confirm</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- ---------view users ----------- -->
                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <form method="POST" action="">
                                  <!-- Modal User Profile View -->
                                  <div class="modal-content">
                                    <div class="modal-header card-header ">
                                      <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body " style="padding: 2rem;">
                                      <!-- Begin Page Content -->
                                      <!-- <div class="container-fluid"> -->
                                      <!-- Page Heading -->
                                      <div class="row card shadow mb-4">
                                        <!-- Profil card -->
                                        <!-- <div class="card shadow mb-4"> -->
                                        <div class="card-header py-3">
                                          <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                        </div>
                                        <div class="card-body col-lmd-12">
                                          <div class="row" style="line-height: 2;">
                                            <div class="col-md-4">
                                              <div class="text-center">
                                                <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                              <b>Name :</b> <?php echo $row['name']; ?><br>
                                              <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                              <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                              <?php
                                              $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php
                                              }
                                              $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                              ?>
                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  }
                                              $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                              $resultid = mysqli_query($conn, $sql1);
                                              while ($rowid = mysqli_fetch_array($resultid)) {
                                                // echo $row['city'];
                                              ?>
                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                              <?php  } ?>
                                              <b>Address :</b> <?php echo $row['address']; ?><br>
                                              <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                              <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                              <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                              <b>Height :</b> <?php echo $row['height']; ?><br>
                                              <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                              <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                            </div>
                                            <div class="col-md-4">
                                              <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                              <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                              <b>Profession :</b> <?php echo $row['prof']; ?><br>
                                              <b>Specialization :</b> <?php echo $row['specialization']; ?><br>
                                              <b>Age :</b> <?php echo $row['bDate']; ?><br>
                                              <b>Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                              <b>Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                              <b>Income :</b> <?php echo $row['income']; ?> <br>
                                              <?php
                                              $res = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                              if ($res) {
                                              ?>
                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                              <?php
                                              }
                                              ?>
                                            </div>

                                            <!-- </ul> -->
                                          </div>
                                        </div>
                                      </div>
                                      <!-- </div> -->
                                      <!-- </div> -->
                                      <div class="modal-footer">
                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end Modal User Profile View -->
                                </form>
                              </div>
                            </div>
                            <!-- /.match list block -->
                          </div>
                <?php }
                        }
                      }
                    }
                  }
                ?>
                </div>

                <!-- Content Row -->
              </div>
              <!-- /.container-fluid -->
            </div>
          </div>
        </div>
        <!-- End of Main Content -->
        <?php include 'panelFooter.php'; ?>
      </div> <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <!--  -->
    <script>
      function like(id) {
        // alert(id);
        $.ajax({
          url: 'save_to_shortlist.php',
          type: "POST",
          data: {
            user_id: id,
          },
          cache: false,
          success: function(result) {
            var data = JSON.parse(result);
            console.log(data['status']);
            if (data['status'] == 200) {
              alert("Added to Shortlist");
              window.location.reload();
            } else if (data['status'] == 201) {
              alert("Removed from Shortlist");
              window.location.reload();
            } else if (data['status'] == 202) {
              alert("updated from Shortlist");
              window.location.reload();
            } else {
              alert("There is a problem ");
              window.location.reload();
            }
          }
        });
      }
    </script>
    <script src="./admin/vendor/jquery/jquery.min.js"></script>
    <script src="./admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="./admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="./admin/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="./admin/vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="./admin/js/demo/chart-area-demo.js"></script>
    <script src="./admin/js/demo/chart-pie-demo.js"></script>
  </body>

  </html>
<?php
} else {
  header("location:login-page.php");
}
?>