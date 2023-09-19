<?php
session_start();
include 'dbconn.php';
include 'vars.php';
include 'include/load.php';
connect_db();
if (isset($_SESSION['id'])) {
  $sesn_id = $_SESSION['id'];
  $current_user_id = $_SESSION['id'];
  $current_user_name = "";
  $current_user_email = "";
  $current_user_plan = "";
  $sql = "SELECT * FROM `user_regiter` where `id` = " . $_SESSION['id'];
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $current_user_name = $row['name'];
    $current_user_email = $row['email'];
    $current_user_plan = $row['type_plan'];
  }
  if (isset($_POST['send_btn'])) {
    $send_id = $_POST['send_id'];
    $existing_data = $db->query("SELECT `id`, `user_id`, `sent_id`, `status`, `created_at`, `updated_at` FROM `requests` WHERE sent_id='$send_id' AND user_id='$current_user_id' ");
    $old_data = $existing_data["rows"];
    if (empty($old_data)) {
      $sql2 = $db->query("INSERT INTO `requests`(`user_id`, `sent_id`, status ) VALUES ('$_SESSION[id]','$send_id', 1)");
    } else {
      $db_update = $db->query_update("UPDATE requests SET status = 1 WHERE  sent_id='$send_id' AND user_id='$current_user_id'");
      $sql2 = $db_update['success']; //'Request already sent';
    }
    if ($sql2 == 1) {
      ?>
                        <script>
                            swal({
                                title: "Great",
                                text: "Your request has been sent successully",
                                icon: "success",
                                buttons: true,
                                dangerMode: true,
                            })
                        </script>
                    <?php
    } else if ($sql2 == 'Request already sent') {
      ?>
                            <script>
                                swal({
                                    title: "Oops...",
                                    text: "Your request has already been sent to this profile",
                                    icon: "error",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            </script>
                    <?php
    }
  }
  if (isset($_POST['delete_btn'])) {
    $del = $_POST['delete_id'];
    $sql = $db->query_update("UPDATE `requests` SET status = 0 WHERE `user_id` =  '$_SESSION[id]' AND `sent_id` = '$del' ");
    if ($sql) {
      ?>
                        <script>
                            setTimeout(function() {
                                swal({
                                    title: "Great",
                                    text: "Your request has been deleted successully",
                                    icon: "success",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            }, 10);
                        </script>
                <?php
    }
  }

  if (isset($_POST['accpt_btn'])) {
    $usrid = $_POST['usr_id']; // current login or interest shown in
    $send_id = $_POST['send_id']; // interest shown by
    // echo $rid = $_POST['r_id'];
    $accpt = $db->query_update("UPDATE `requests` SET `status` = 2 WHERE  `user_id`= '$send_id' AND sent_id = '$usrid' ");
  } else if (isset($_POST['rjct_btn'])) {
    $usrid = $_POST['usr_id']; // current login or interest shown in
    $send_id = $_POST['send_id']; // interest shown by
    // $rid = $_POST['r_id'];
    $rjct = $db->query_update("UPDATE `requests` SET `status` = 3 WHERE  `user_id`= '$send_id' AND sent_id = '$usrid' ");
  }

  ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>My Inbox</title>
            <!-- Custom fonts for this template-->
            <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
            <!-- Custom styles for this template-->
            <link href="./admin/css/styleAdmin.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
            <!-- favicon icon -->
            <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">
        </head>

        <body id="page-top" style="  font-family: 'Nunito', sans-serif;" onload="InGetRejectedData()">
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
                            <div class="row ">
                                <!-- Profil card -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold coral-green text-center">Inbox</h6>
                                    </div>
                                    <div class="card-body">
                                        <nav>
                                            <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
                                                <li class="nav-item userTab" role="presentation">
                                                    <button class="nav-link coral-green active" id="pills-recieved-tab" data-bs-toggle="pill" data-bs-target="#pills-recieved" type="button" role="tab" aria-controls="pills-recieved" aria-selected="true">Recieved</button>
                                                </li>
                                                <li class="nav-item userTab " role="presentation">
                                                    <button class="nav-link coral-green" id="pills-accepted-tab" data-bs-toggle="pill" data-bs-target="#pills-accepted" type="button" role="tab" aria-controls="pills-accepted" aria-selected="false">Accepted</button>
                                                </li>
                                                <li class="nav-item userTab" role="presentation">
                                                    <button class="nav-link coral-green" id="pills-likes-tab" data-bs-toggle="pill" data-bs-target="#pills-likes" type="button" role="tab" aria-controls="pills-likes" aria-selected="false">Likes</button>
                                                </li>
                                                <!-- <li class="nav-item userTab" role="presentation">
                                                <button class="nav-link coral-green" id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button" role="tab" aria-controls="pills-pending" aria-selected="false">pending</button>
                                            </li> -->
                                                <li class="nav-item userTab" role="presentation">
                                                    <button class="nav-link coral-green" id="pills-deleted-tab" data-bs-toggle="pill" data-bs-target="#pills-deleted" type="button" role="tab" aria-controls="pills-deleted" aria-selected="false">Rejected</button>
                                                </li>
                                            </ul>

                                            <div class="tab-content bg-light" id="pills-tabContent">
                                                <!-- ================================================================================================================= -->
                                                <!-- -------------recieved requests tab--------------- -->
                                                <div class="tab-pane fade show active" id="pills-recieved" role="tabpanel" aria-labelledby="pills-recieved-tab">
                                                    <div class="card-header">
                                                    <div class="text-center">   People who have sent you requests!</div>
                                                    </div>
                                                    <div class="card-body ">
                                                        <div class="row profile mb-4">
                                                            <?php
                                                            $recieved_query = "";
                                                            $recieved_query = "SELECT liker.id AS id, liker.name AS name, liker.plan_expiry_date, liker.label, liker.specialization, 
                                                                            liker.age, liker.religion, cities.name AS city_name, states.name AS state_name,
                                                                            liker.filename, liker.email, liker.phone, countries.name AS country_name, liker.address,
                                                                            liker.marStat, liker.lang, liker.HighEdu, liker.collage, liker.prof, liker.bDate, liker.bGrp
                                                                            , liker.bTime , liker.income, liker.`sub-com`, liker.height, liker.diet, liker.type_plan 
                                                                        FROM `requests` AS req  
                                                                        LEFT JOIN user_regiter AS liker ON liker.id = req.user_id AND liker.status = 1
                                                                        LEFT JOIN cities ON cities.id = liker.city AND cities.is_active = 1
                                                                        LEFT JOIN states ON states.id = liker.state AND states.is_active = 1
                                                                        LEFT JOIN countries ON countries.id = liker.country AND countries.is_active = 1 
                                                                        WHERE req.`sent_id` = '$current_user_id' AND req.status = 1
                                                                        ";
                                                            $requests = $db->query($recieved_query);
                                                            $interested_user_data_rows = ($requests['success'] == 1) ? $requests['rows'] : array(); //->query("SELECT * FROM `requests` WHERE `sent_id` = '$current_user_id' WHERE status =1 ");
                                                          
                                                            foreach ($interested_user_data_rows as $in_data) {
                                                              $currentDate = date("Y-m-d");
                                                              $plan_expiry_date = $in_data['plan_expiry_date'];
                                                              if ($plan_expiry_date > $currentDate) {
                                                                ?>
                                                                          <div class="col-md-3  col-lg-3 mt-4 surface ">
                                                                                <div class="vendor-list-block mb30 shadow card ">
                                                                                    <!-- match list block -->
                                                                                    <div class=" vendor-img gradient-top" style="width: 100%;">
                                                                                        <img src="user_image/<?php echo $in_data['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                                                                        <div class="<?php echo $in_data['label'] ?>"></div>
                                                                                        <div class="favourite-bg">
                                                                                            <button onclick="like( <?php echo $in_data['id']; ?>)" class='btn'>
                                                                                                <?php

                                                                                                $liked_icon = $db->query_one("SELECT status FROM `shortlist` WHERE liked_p_id = '$in_data[id]' AND user_id = '$current_user_id'");
                                                                                                $liked_icon = ($liked_icon['success'] == 1 && !empty($liked_icon['rows'])) ? $liked_icon['rows'][0][0] : 0;
                                                                                                $css_color = ($liked_icon) ? 'color:red' : '';
                                                                                                ?>
                                                                                                <i class='fa fa-heart like' style='<?php echo $css_color; ?>'> </i>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="category-badge"><a href="" class="category-link"><?php echo $in_data['specialization']; ?></a></div>
                                                                                        <div class="price-lable"><?php echo $in_data['age']; ?></div>
                                                                                    </div>
                                                                                    <div class="card-body vendor-detail">
                                                                                        <!-- Match details -->
                                                                                        <div class="caption">
                                                                                            <h2 class="title">
                                                                                                <?php
                                                                                                $pieces = explode(" ", $in_data['name']);
                                                                                                echo $pieces[0];
                                                                                                ?>
                                                                                            </h2>
                                                                                            <h4 class="relign"><?php echo $in_data['religion']; ?></h4>
                                                                                            <div class="vendor-meta"><span class="location">
                                                                                                    <i class="fa fa-map-marker map-icon"></i>
                                                                                                    <?php
                                                                                                    echo strtoupper($in_data['city_name']);
                                                                                                    ?> ,
                                                                                                    <?php
                                                                                                    echo strtoupper($in_data['state_name']);
                                                                                                    ?>
                                                                                                </span>
                                                                                                <div>
                                                                                                    <?php
                                                                                                    $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$in_data[id]' AND sent_id = '$current_user_id' ";
                                                                                                    $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                    $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                    ?>
                                                                                                    <?php if ($is_interest_shown == 1): ?>
                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@accept" class="btn btn-sm col-3 btn-primary mt-3" name="Req" id="Req"><i class="fa fa-check"></i></button>
                                                                                                    <?php else: ?>
                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                    <?php endif; ?>

                                                                                                    <?php if ($current_user_plan != 'Free'): ?>
                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_userone<?php echo $in_data['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3 view_btn" id="view_btn_<?php echo $in_data['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                    <?php else: ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.Match details -->
                                                                                </div>
                                                                                <!-- /.match list block -->
                                                                                <div class="modal fade" id="delete_confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <form action="" method="post">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    Do You Really Want to Delete this Request?
                                                                                                    <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $in_data['id']; ?>">
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                                    <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal fade" id="confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <form action="" method="post">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="example">Confirm To Accept ?</h5>
                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    Do You Really Want to Accept this Request from <?php echo $in_data['name']; ?>?
                                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $in_data['id']; ?>">
                                                                                                    <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                    <input name="r_id" type="hidden" class="form-control" id="r_id" value="<?php echo $rid; ?>">
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="submit" name="rjct_btn" id="rjct_btn" class="btn btn-secondary" data-bs-dismiss="modal">Reject</button>
                                                                                                    <button name="accpt_btn" type="submit" class="btn btn-danger" id="accpt_btn">Accept</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal fade" id="send_confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <form action="" method="post">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="example">Confirm To send?</h5>
                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    Do You Really Want to send this Request to <?php echo $in_data['name']; ?>?
                                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $in_data['id']; ?>">
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
                                                                                <div class="modal fade" id="view_fml_userone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-xl">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header ">
                                                                                                <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body " style="padding: 2rem;">
                                                                                                <div class="row card shadow mb-4">
                                                                                                    <div class="card-header py-3">
                                                                                                        <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                                                                                    </div>
                                                                                                    <div class="card-body col-lmd-12">
                                                                                                        <div class="row" style="line-height: 2;">
                                                                                                            <div class="col-md-4">
                                                                                                                <div class="text-center">
                                                                                                                    <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $in_data['filename']; ?>" alt="Upload Image">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <b>Name :</b> <?php echo $in_data['name']; ?><br>
                                                                                                                <b>E-mail :</b> <?php echo $in_data['email']; ?><br>
                                                                                                                <b>Phone Number :</b> <?php echo $in_data['phone']; ?><br>

                                                                                                                <b class="bold_title">Country :</b> <?php echo strtoupper($in_data['country_name']); ?><br>
                                                                                                                <b class="bold_title">State :</b> <?php echo strtoupper($in_data['state_name']); ?><br>
                                                                                                                <b class="bold_title">City :</b> <?php echo strtoupper($in_data['city_name']); ?><br>

                                                                                                                <b>Address :</b> <?php echo $in_data['address']; ?><br>
                                                                                                                <b>Marital Status :</b> <?php echo $in_data['marStat']; ?><br>
                                                                                                                <b>Mother Tongue :</b> <?php echo $in_data['lang']; ?><br>
                                                                                                                <b>Diet :</b> <?php echo $in_data['diet']; ?><br>
                                                                                                                <b>Height :</b> <?php echo $in_data['height']; ?><br>
                                                                                                                <b>Religion :</b> <?php echo $in_data['religion']; ?><br>
                                                                                                                <b>Sub-Community :</b> <?php echo $in_data['sub-com']; ?><br>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <b>Highest Education :</b> <?php echo $in_data['HighEdu']; ?><br>
                                                                                                                <b>Collage :</b> <?php echo $in_data['collage']; ?><br>
                                                                                                                <b>Profession :</b> <?php echo $in_data['prof']; ?><br>
                                                                                                                <b>Specialization :</b> <?php echo $in_data['specialization']; ?><br>
                                                                                                                <b>Age :</b> <?php echo $in_data['bDate']; ?><br>
                                                                                                                <b>Blood Group :</b> <?php echo $in_data['bGrp']; ?><br>
                                                                                                                <b>Birth Time :</b> <?php echo $in_data['bTime']; ?><br>
                                                                                                                <b>Income :</b> <?php echo $in_data['income']; ?> <br>
                                                                                                                <?php
                                                                                                                $res11 = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                                                                                                if ($res11) {
                                                                                                                  ?>
                                                                                                                        <b class="bold_title">Membership Plan :</b> <?php echo $in_data['type_plan']; ?>
                                                                                                                    <?php
                                                                                                                }
                                                                                                                ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                              }
                                                            }
                                                            ?>
                                                            <!-- ================================================================================================================= -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- ------------- accepted requests tab--------------- -->
                                                <div class="tab-pane fade show " id="pills-accepted" role="tabpanel" aria-labelledby="pills-accepted-tab">
                                                    <div class="card-header">
                                                        <h6>You accepted these Profiles!</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row profile mb-4">
                                                            <!-- ================================================================================================================= -->
                                                            <?php
                                                            // $rid = 0;
                                                            $accepted = $db->query("SELECT * FROM `requests` WHERE `sent_id` = '$sesn_id' AND `status` = 2");
                                                            $accepted_rows = ($accepted['success'] == 1) ? $accepted['rows'] : array();

                                                            foreach ($accepted_rows as $row_data) {

                                                              $interest_shown_by = $row_data['user_id'];
                                                              if ($row_data['status'] == 2) {
                                                                $currentDate = date("Y-m-d");
                                                                $interested_user_data = $db->query(" SELECT * FROM `user_regiter` WHERE `id` = '$interest_shown_by'  AND `status`= 1 ");
                                                                $interested_user_data_rows = ($interested_user_data['success'] == 1) ? $interested_user_data['rows'] : array();

                                                                foreach ($interested_user_data_rows as $in_data) {
                                                                  $plan_expiry_date = $in_data['plan_expiry_date'];
                                                                  if ($plan_expiry_date > $currentDate) {
                                                                    ?>
                                                                                           <div class="col-md-3  col-lg-3 mt-4 surface ">
                                                                                                <div class="vendor-list-block mb30 shadow card ">
                                                                                                    <!-- match list block -->
                                                                                                    <div class=" vendor-img gradient-top" style="width: 100%;">
                                                                                                        <img src="user_image/<?php echo $in_data['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                                                                                        <div class="<?php echo $in_data['label'] ?>"></div>
                                                                                                        <div class="favourite-bg">
                                                                                                            <button onclick="like( <?php echo $in_data['id']; ?>)" class='btn'>
                                                                                                                <?php
                                                                                                                $liked_icon = $db->query_one("SELECT status FROM `shortlist` WHERE liked_p_id = '$in_data[id]' AND user_id = '$current_user_id'");
                                                                                                                $liked_icon = ($liked_icon['success'] == 1 && !empty($liked_icon['rows'])) ? $liked_icon['rows'][0][0] : 0;
                                                                                                                $css_color = ($liked_icon) ? 'color:red' : '';
                                                                                                                ?>
                                                                                                                <i class='fa fa-heart like' style='<?php echo $css_color; ?>'> </i>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                        <div class="category-badge">
                                                                                                            <a href="" class="category-link">
                                                                                                                <?php echo $in_data['specialization']; ?>
                                                                                                            </a>
                                                                                                        </div>
                                                                                                        <div class="price-lable"><?php echo $in_data['age']; ?></div>
                                                                                                    </div>
                                                                                                    <div class="card-body vendor-detail">
                                                                                                        <!-- Match details -->
                                                                                                        <div class="caption">
                                                                                                            <h2 class="title">
                                                                                                                <?php
                                                                                                                $pieces = explode(" ", $in_data['name']);
                                                                                                                echo $pieces[0];
                                                                                                                ?>
                                                                                                            </h2>
                                                                                                            <h4 class="relign"><?php echo $in_data['religion']; ?></h4>
                                                                                                            <div class="vendor-meta"><span class="location">
                                                                                                                    <i class="fa fa-map-marker map-icon"></i>
                                                                                                                    <?php
                                                                                                                    $sql1 = "SELECT * FROM cities where `id` = " . $in_data['city'];
                                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                      echo strtoupper($rowid['name']);
                                                                                                                    }
                                                                                                                    ?> ,
                                                                                                                    <?php
                                                                                                                    $sql1 = "SELECT * FROM states where `id` = " . $in_data['state'];
                                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                      echo strtoupper($rowid['name']);
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </span>
                                                                                                                <div>
                                                                                                                    <?php
                                                                                                                    $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$in_data[id]' AND sent_id = '$current_user_id' ";
                                                                                                                    $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                                    $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                                    ?>
                                                                                                                    <?php if ($is_interest_shown == 2): ?>
                                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@accept" class="btn btn-sm col-3 btn-primary mt-3" name="Req" id="Req"><i class="fa fa-check"></i></button>
                                                                                                                            <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button> -->
                                                                                                                    <?php else: ?>
                                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                                    <?php endif; ?>
                                                                                                                    <?php if ($current_user_plan != 'Free'): ?>
                                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_userone<?php echo $in_data['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3 view_btn" id="view_btn_<?php echo $in_data['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                                    <?php else: ?>
                                                                                                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                                    <?php endif; ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!-- /.Match details -->
                                                                                                </div>
                                                                                                <!-- /.match list block -->
                                                                                                <div class="modal fade" id="delete_confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog">
                                                                                                        <div class="modal-content">
                                                                                                            <form action="" method="post">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    Do You Really Want to Delete this Request?
                                                                                                                    <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $in_data['id']; ?>">
                                                                                                                </div>
                                                                                                                <div class="modal-footer">
                                                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                                                    <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                                                                                                </div>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal fade" id="confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog">
                                                                                                        <div class="modal-content">
                                                                                                            <form action="" method="post">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="example">Confirm To Accept ?</h5>
                                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    Do You Really Want to Accept this Request from <?php echo $in_data['name']; ?>?
                                                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $in_data['id']; ?>">
                                                                                                                    <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                                    <input name="r_id" type="hidden" class="form-control" id="r_id" value="<?php echo $rid; ?>">
                                                                                                                </div>
                                                                                                                <div class="modal-footer">
                                                                                                                    <button type="submit" name="rjct_btn" id="rjct_btn" class="btn btn-secondary" data-bs-dismiss="modal">Reject</button>
                                                                                                                    <button name="accpt_btn" type="submit" class="btn btn-danger" id="accpt_btn">Accept</button>
                                                                                                                </div>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal fade" id="send_confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog">
                                                                                                        <div class="modal-content">
                                                                                                            <form action="" method="post">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="example">Confirm To send?</h5>
                                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    Do You Really Want to send this Request to <?php echo $in_data['name']; ?>?
                                                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $in_data['id']; ?>">
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
                                                                                                <div class="modal fade" id="view_fml_userone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-xl">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header ">
                                                                                                                <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                            </div>
                                                                                                            <div class="modal-body " style="padding: 2rem;">
                                                                                                                <div class="row card shadow mb-4">
                                                                                                                    <div class="card-header py-3">
                                                                                                                        <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                                                                                                    </div>
                                                                                                                    <div class="card-body col-lmd-12">
                                                                                                                        <div class="row" style="line-height: 2;">
                                                                                                                            <div class="col-md-4">
                                                                                                                                <div class="text-center">
                                                                                                                                    <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $in_data['filename']; ?>" alt="Upload Image">
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="col-md-4">
                                                                                                                                <b>Name :</b> <?php echo $in_data['name']; ?><br>
                                                                                                                                <b>E-mail :</b> <?php echo $in_data['email']; ?><br>
                                                                                                                                <b>Phone Number :</b> <?php echo $in_data['phone']; ?><br>
                                                                                                                                <?php
                                                                                                                                $sql1 = "SELECT * FROM `countries` where `id` = " . $in_data['country'];
                                                                                                                                $resultid = mysqli_query($conn, $sql1);
                                                                                                                                while ($in_dataid = mysqli_fetch_array($resultid)) {
                                                                                                                                  ?>
                                                                                                                                        <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                                    <?php
                                                                                                                                }
                                                                                                                                $sql1 = "SELECT * FROM `states` where `id` = " . $in_data['state'];
                                                                                                                                $resultid = mysqli_query($conn, $sql1);
                                                                                                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                                  ?>
                                                                                                                                        <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                                <?php }
                                                                                                                                $sql1 = "SELECT * FROM `cities` where `id` = " . $in_data['city'];
                                                                                                                                $resultid = mysqli_query($conn, $sql1);
                                                                                                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                                  ?>
                                                                                                                                        <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                                <?php } ?>
                                                                                                                                <b>Address :</b> <?php echo $in_data['address']; ?><br>
                                                                                                                                <b>Marital Status :</b> <?php echo $in_data['marStat']; ?><br>
                                                                                                                                <b>Mother Tongue :</b> <?php echo $in_data['lang']; ?><br>
                                                                                                                                <b>Diet :</b> <?php echo $in_data['diet']; ?><br>
                                                                                                                                <b>Height :</b> <?php echo $in_data['height']; ?><br>
                                                                                                                                <b>Religion :</b> <?php echo $in_data['religion']; ?><br>
                                                                                                                                <b>Sub-Community :</b> <?php echo $in_data['sub-com']; ?><br>
                                                                                                                            </div>
                                                                                                                            <div class="col-md-4">
                                                                                                                                <b>Highest Education :</b> <?php echo $in_data['HighEdu']; ?><br>
                                                                                                                                <b>Collage :</b> <?php echo $in_data['collage']; ?><br>
                                                                                                                                <b>Profession :</b> <?php echo $in_data['prof']; ?><br>
                                                                                                                                <b>Specialization :</b> <?php echo $in_data['specialization']; ?><br>
                                                                                                                                <b>Age :</b> <?php echo $in_data['bDate']; ?><br>
                                                                                                                                <b>Blood Group :</b> <?php echo $in_data['bGrp']; ?><br>
                                                                                                                                <b>Birth Time :</b> <?php echo $in_data['bTime']; ?><br>
                                                                                                                                <b>Income :</b> <?php echo $in_data['income']; ?> <br>
                                                                                                                                <?php
                                                                                                                                $res11 = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                                                                                                                if ($res11) {
                                                                                                                                  ?>
                                                                                                                                        <b class="bold_title">Membership Plan :</b> <?php echo $in_data['type_plan']; ?>
                                                                                                                                    <?php
                                                                                                                                }
                                                                                                                                ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="modal-footer">
                                                                                                                    <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                            <?php
                                                                  }
                                                                }
                                                              }
                                                            }

                                                            ?>
                                                            <!-- ================================================================================================================= -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -------------likes tab--------------- -->
                                                <div class="tab-pane fade show " id="pills-likes" role="tabpanel" aria-labelledby="pills-likes-tab">
                                                    <div class="card-header">
                                                        <h6>People who have Liked your Profile !</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row profile mb-4">
                                                            <!-- ================================================================================================================= -->
                                                            <?php
                                                            $liked_query = "SELECT liker.id AS id, liker.name AS name, liker.plan_expiry_date, liker.label, liker.specialization, 
                                                                                    liker.age, liker.religion, cities.name AS city_name, states.name AS state_name,
                                                                                    liker.filename, liker.email, liker.phone, countries.name AS country_name, liker.address,
                                                                                    liker.marStat, liker.lang, liker.HighEdu, liker.collage, liker.prof, liker.bDate, liker.bGrp
                                                                                    , liker.bTime , liker.income, liker.`sub-com`, liker.height, liker.diet, liker.type_plan 
                                                                                FROM shortlist AS sl
                                                                                LEFT JOIN user_regiter AS liker ON liker.id = sl.user_id AND liker.status = 1
                                                                                LEFT JOIN user_regiter AS liked ON liked.id = sl.liked_p_id AND liked.status = 1
                                                                                LEFT JOIN cities ON cities.id = liker.city AND cities.is_active = 1
                                                                                LEFT JOIN states ON states.id = liker.state AND states.is_active = 1
                                                                                LEFT JOIN countries ON countries.id = liker.country AND countries.is_active = 1
                                                                                WHERE sl.`liked_p_id`= '$current_user_id' AND sl.`status` = 1
                                                                                ";
                                                            $liked_result = $db->query($liked_query);
                                                            $liked_rows = ($liked_result['success'] && !empty($liked_result['rows'])) ? $liked_result['rows'] : array();


                                                            ?>
                                                            <?php foreach ($liked_rows as $row): ?>
                                                                <div class="col-md-3  col-lg-3 mt-4 surface ">
                                                                        <div class="vendor-list-block mb30 shadow card ">
                                                                            <!-- match list block -->
                                                                            <div class=" vendor-img gradient-top" style="width: 100%;">
                                                                                <!-- <a data-bs-toggle="modal" data-bs-target="#confirmfv<?php echo $row['id']; ?>" name="Req" id="Req"> -->
                                                                                <img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                                                                <!-- </a> -->
                                                                                <div class="<?php echo $row['label'] ?>"></div>
                                                                                <div class="favourite-bg">
                                                                                    <button onclick="like( <?php echo $row['id']; ?>)" class='btn'>
                                                                                        <?php
                                                                                        $liked_icon = $db->query_one("SELECT status FROM `shortlist` WHERE liked_p_id = '$row[id]' AND user_id = '$current_user_id'");
                                                                                        $liked_icon = ($liked_icon['success'] == 1 && !empty($liked_icon['rows'])) ? $liked_icon['rows'][0][0] : 0;
                                                                                        $css_color = ($liked_icon) ? 'color:red' : '';
                                                                                        ?>
                                                                                        <i class='fa fa-heart like' style='<?php echo $css_color; ?>'> </i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                            </div>
                                                                            <div class="card-body vendor-detail">
                                                                                <!-- Match details -->
                                                                                <div class="caption">
                                                                                    <h2 class="title">
                                                                                        <?php
                                                                                        $pieces = explode(" ", $row['name']);
                                                                                        echo $pieces[0];
                                                                                        ?>
                                                                                    </h2>
                                                                                    <h4 class="relign"><?php echo $row['religion']; ?></h4>
                                                                                    <div class="vendor-meta">
                                                                                        <span class="location">
                                                                                            <i class="fa fa-map-marker map-icon"></i>
                                                                                            <?php echo strtoupper($row['city_name']); ?> ,
                                                                                            <?php echo strtoupper($row['state_name']); ?>
                                                                                        </span>
                                                                                        <div>
                                                                                            <div>
                                                                                                <?php
                                                                                                $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                ?>
                                                                                                <?php if ($is_interest_shown == 0): ?>
                                                                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmfv<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#confirmone<?php echo $row['id']; ?>" data-bs-whatever="@accept" class="btn btn-sm col-3 btn-primary mt-3" name="Req" id="Req"><i class="fa fa-check"></i></button> -->
                                                                                                <?php elseif ($is_interest_shown == 1): ?>
                                                                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirmfive<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button>
                                                                                                <?php else: ?>
                                                                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmfv<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmone<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button> -->
                                                                                                <?php endif; ?>
                                                                                                <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_userone<?php echo $row['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3 view_btn" id="view_btn_<?php echo $in_data['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button> -->
                                                                                                <?php if ($current_user_plan != 'Free'): ?>
                                                                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_userone<?php echo $in_data['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3 view_btn" id="view_btn_<?php echo $in_data['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                        <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.Match details -->
                                                                        </div>
                                                                        <!-- /.match list block -->
                                                                        <div class="modal fade" id="delete_confirmfive<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                                        <div class="modal fade" id="send_confirmfv<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
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
                                                                        <div class="modal fade" id="view_fml_userfive<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-xl">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header ">
                                                                                        <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body " style="padding: 2rem;">
                                                                                        <div class="row card shadow mb-4">
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
                                                                                                        <b>Name :</b> <?php echo $row['name']; ?><br>
                                                                                                        <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                                                                                        <b>Phone Number :</b> <?php echo $row['phone']; ?><br>

                                                                                                        <b class="bold_title">Country :</b> <?php echo strtoupper($row['country_name']); ?><br>

                                                                                                        <b class="bold_title">State :</b> <?php echo strtoupper($row['state_name']); ?><br>

                                                                                                        <b class="bold_title">City :</b> <?php echo strtoupper($row['city_name']); ?><br>

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
                                                                                                        $res11 = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                                                                                        if ($res11) {
                                                                                                          ?>
                                                                                                                <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <?php endforeach; ?>

                                                            <!-- ================================================================================================================= -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -------------deleted requests tab--------------- -->
                                                <div class="tab-pane fade show " id="pills-deleted" role="tabpanel" aria-labelledby="pills-deleted-tab">
                                                    <div class="card-header">
                                                        <h6>You Rejected these Requests!</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row  profile mb-4">
                                                            <!-- ================================================================================================================= -->
                                                            <?php
                                                            $rejected_query = "SELECT liker.id AS id, liker.name AS name, liker.plan_expiry_date, liker.label, liker.specialization, 
                                                            liker.age, liker.religion, cities.name AS city_name, states.name AS state_name,
                                                            liker.filename, liker.email, liker.phone, countries.name AS country_name, liker.address,
                                                            liker.marStat, liker.lang, liker.HighEdu, liker.collage, liker.prof, liker.bDate, liker.bGrp
                                                            , liker.bTime , liker.income, liker.`sub-com`, liker.height, liker.diet, liker.type_plan 
                                                        FROM `requests` AS req  
                                                        LEFT JOIN user_regiter AS liker ON liker.id = req.user_id AND liker.status = 1
                                                        LEFT JOIN cities ON cities.id = liker.city AND cities.is_active = 1
                                                        LEFT JOIN states ON states.id = liker.state AND states.is_active = 1
                                                        LEFT JOIN countries ON countries.id = liker.country AND countries.is_active = 1 
                                                        WHERE req.`sent_id` = '$current_user_id' AND req.status = 3
                                                        ";
                                                            // $rejected = $db->query("SELECT * FROM `requests` WHERE `sent_id` = '$sesn_id' AND `status` = 3");
                                                            $rejected = $db->query($rejected_query);
                                                            $rejected_rows = ($rejected['success'] == 1) ? $rejected['rows'] : array();

                                                            foreach ($rejected_rows as $in_data) {
                                                              $currentDate = date("Y-m-d");
                                                              $plan_expiry_date = $in_data['plan_expiry_date'];
                                                              if ($plan_expiry_date > $currentDate) {
                                                                ?>
                                                                            <div class="col-md-3  col-lg-3 mt-4 surface ">
                                                                                <div class="vendor-list-block mb30 shadow card ">
                                                                                    <!-- match list block -->
                                                                                    <div class=" vendor-img gradient-top" style="width: 100%;">
                                                                                        <img src="user_image/<?php echo $in_data['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                                                                        <div class="<?php echo $in_data['label'] ?>"></div>
                                                                                        <div class="favourite-bg">
                                                                                            <button onclick="like( <?php echo $in_data['id']; ?>)" class='btn'>
                                                                                                <?php
                                                                                                $liked_icon = $db->query_one("SELECT status FROM `shortlist` WHERE liked_p_id = '$in_data[id]' AND user_id = '$current_user_id'");
                                                                                                $liked_icon = ($liked_icon['success'] == 1 && !empty($liked_icon['rows'])) ? $liked_icon['rows'][0][0] : 0;
                                                                                                $css_color = ($liked_icon) ? 'color:red' : '';
                                                                                                ?>
                                                                                                <i class='fa fa-heart like' style='<?php echo $css_color; ?>'> </i>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="category-badge"><a href="" class="category-link"><?php echo $in_data['specialization']; ?></a></div>
                                                                                        <div class="price-lable"><?php echo $in_data['age']; ?></div>
                                                                                    </div>
                                                                                    <div class="card-body vendor-detail">
                                                                                        <!-- Match details -->
                                                                                        <div class="caption">
                                                                                            <h2 class="title">
                                                                                                <?php
                                                                                                $pieces = explode(" ", $in_data['name']);
                                                                                                echo $pieces[0];
                                                                                                ?>
                                                                                            </h2>
                                                                                            <h4 class="relign"><?php echo $in_data['religion']; ?></h4>
                                                                                            <div class="vendor-meta"><span class="location">
                                                                                                    <i class="fa fa-map-marker map-icon"></i>
                                                                                                    <?php
                                                                                                    echo strtoupper($in_data['city_name']);
                                                                                                    ?> ,
                                                                                                    <?php
                                                                                                    echo strtoupper($in_data['state_name']);
                                                                                                    ?>
                                                                                                </span>
                                                                                                <div>
                                                                                                    <?php
                                                                                                    $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$in_data[id]' AND sent_id = '$current_user_id' ";
                                                                                                    $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                    $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                    ?>
                                                                                                    <?php if ($is_interest_shown == 3): ?>
                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@accept" class="btn btn-sm col-3 btn-primary mt-3" name="Req" id="Req"><i class="fa fa-check"></i></button>
                                                                                                    <?php else: ?>
                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                    <?php endif; ?>
                                                                                                    <?php if ($current_user_plan != 'Free'): ?>
                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_userone<?php echo $in_data['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3 view_btn" id="view_btn_<?php echo $in_data['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                    <?php else: ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.Match details -->
                                                                                </div>
                                                                                <!-- /.match list block -->
                                                                                <div class="modal fade" id="delete_confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <form action="" method="post">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    Do You Really Want to Delete this Request?
                                                                                                    <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $in_data['id']; ?>">
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                                    <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal fade" id="confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <form action="" method="post">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="example">Confirm To Accept ?</h5>
                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    Do You Really Want to Accept this Request from <?php echo $in_data['name']; ?>?
                                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $in_data['id']; ?>">
                                                                                                    <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                    <input name="r_id" type="hidden" class="form-control" id="r_id" value="<?php echo $rid; ?>">
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="submit" name="rjct_btn" id="rjct_btn" class="btn btn-secondary" data-bs-dismiss="modal">Reject</button>
                                                                                                    <button name="accpt_btn" type="submit" class="btn btn-danger" id="accpt_btn">Accept</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal fade" id="send_confirmone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <form action="" method="post">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="example">Confirm To send?</h5>
                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    Do You Really Want to send this Request to <?php echo $in_data['name']; ?>?
                                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $in_data['id']; ?>">
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
                                                                                <div class="modal fade" id="view_fml_userone<?php echo $in_data['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-xl">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header ">
                                                                                                <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body " style="padding: 2rem;">
                                                                                                <div class="row card shadow mb-4">
                                                                                                    <div class="card-header py-3">
                                                                                                        <h6 class="m-0 font-weight-bold text-primary text-center">Profile</h6>
                                                                                                    </div>
                                                                                                    <div class="card-body col-lmd-12">
                                                                                                        <div class="row" style="line-height: 2;">
                                                                                                            <div class="col-md-4">
                                                                                                                <div class="text-center">
                                                                                                                    <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $in_data['filename']; ?>" alt="Upload Image">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <b>Name :</b> <?php echo $in_data['name']; ?><br>
                                                                                                                <b>E-mail :</b> <?php echo $in_data['email']; ?><br>
                                                                                                                <b>Phone Number :</b> <?php echo $in_data['phone']; ?><br>

                                                                                                                <b class="bold_title">Country :</b> <?php echo strtoupper($in_data['country_name']); ?><br>
                                                                                                                <b class="bold_title">State :</b> <?php echo strtoupper($in_data['state_name']); ?><br>
                                                                                                                <b class="bold_title">City :</b> <?php echo strtoupper($in_data['city_name']); ?><br>

                                                                                                                <b>Address :</b> <?php echo $in_data['address']; ?><br>
                                                                                                                <b>Marital Status :</b> <?php echo $in_data['marStat']; ?><br>
                                                                                                                <b>Mother Tongue :</b> <?php echo $in_data['lang']; ?><br>
                                                                                                                <b>Diet :</b> <?php echo $in_data['diet']; ?><br>
                                                                                                                <b>Height :</b> <?php echo $in_data['height']; ?><br>
                                                                                                                <b>Religion :</b> <?php echo $in_data['religion']; ?><br>
                                                                                                                <b>Sub-Community :</b> <?php echo $in_data['sub-com']; ?><br>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <b>Highest Education :</b> <?php echo $in_data['HighEdu']; ?><br>
                                                                                                                <b>Collage :</b> <?php echo $in_data['collage']; ?><br>
                                                                                                                <b>Profession :</b> <?php echo $in_data['prof']; ?><br>
                                                                                                                <b>Specialization :</b> <?php echo $in_data['specialization']; ?><br>
                                                                                                                <b>Age :</b> <?php echo $in_data['bDate']; ?><br>
                                                                                                                <b>Blood Group :</b> <?php echo $in_data['bGrp']; ?><br>
                                                                                                                <b>Birth Time :</b> <?php echo $in_data['bTime']; ?><br>
                                                                                                                <b>Income :</b> <?php echo $in_data['income']; ?> <br>
                                                                                                                <?php
                                                                                                                $res11 = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                                                                                                if ($res11) {
                                                                                                                  ?>
                                                                                                                        <b class="bold_title">Membership Plan :</b> <?php echo $in_data['type_plan']; ?>
                                                                                                                    <?php
                                                                                                                }
                                                                                                                ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                              }
                                                            }
                                                            ?>

                                                            <!-- ================================================================================================================= -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->
                    <div class="modal fade" id="purchase" tabindex="-1" role="dialog" aria-labelledby="myModalplan">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                    <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    You have to purchase a membership plan to view this profile.
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                    <a name="ok" id="ok-btn" type="button" class="btn btn-primary" data-dismiss="modal">Ok</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    include 'panelFooter.php';
                    ?>
                </div>
                <!-- End of Content Wrapper -->
            </div>
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <input type="hidden" id="current_user_id" value="<?php echo $current_user_id; ?>">
            <input type='hidden' id='current_user_name' value='<?php echo $current_user_name; ?>'>
            <input type='hidden' id='current_user_email' value='<?php echo $current_user_email; ?>'>
            <!-- Bootstrap core JavaScript -->
            <script src="./admin/vendor/jquery/jquery.min.js"></script>
            <script src="./admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript -->
            <script src="./admin/vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="./admin/js/sb-admin-2.min.js"></script>
            <!-- Page level plugins -->
            <!-- <script src="./admin/vendor/chart.js/Chart.min.js"></script> -->
            <!-- Page level custom scripts -->
            <!-- <script src="./admin/js/demo/chart-area-demo.js"></script>
        <script src="./admin/js/demo/chart-pie-demo.js"></script> -->
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <script>
                $(".view_btn").on("click", function() {
                    var current_user_email = $('#current_user_email').val();
                    var current_user_name = $('#current_user_name').val();
                    var current_user_id = $("#current_user_id").val();
                    var key = this.id;
                    var user_id = (key.match(/\d+$/) || []).pop();
                    if (current_user_id != '') {
                        $.ajax({
                            url: 'profile_view_count.php',
                            type: "POST",
                            data: {
                                user_id: user_id,
                                current_user_id: current_user_id,
                            },
                            cache: false,
                            success: function(result) {
                                console.log(result);
                            }
                        });
                    }
                    $.ajax({
                        url: 'profile_view_email.php',
                        type: "POST",
                        data: {
                            user_id: user_id,
                            current_user_name: current_user_name,
                            current_user_email: current_user_email,
                        },
                        cache: false,
                        beforeSend: function() {
                            // setting a timeout
                            console.log('before profile_view_email');
                        },
                        success: function(result) {
                            console.log(result);
                            // var data = JSON.parse(result);
                            // console.log(data['status']);
                            // if (data['status'] == 200) { 
                            //     console.log("Email sent"); 
                            // } else {
                            //     console.log("There is a problem "); 
                            // }
                        }
                    });
                });

                function InGetRejectedData() {
                    // alert('jdhgsjk');
                    // $.ajax({
                    //     url: 'getRejectedData.php',
                    //     type: "POST",
                    //     data: {
                    //         InOutData: "InGetRejectedData",
                    //     },
                    //     cashe: false,
                    //     success: function(result) {
                    //         $('.rejectedprofile').html(result);
                    //     }
                    // });
                };

                function like(id) {
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
                                swal({
                                    title: "Great",
                                    text: "Added to Shortlist",
                                    icon: "success",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            } else if (data['status'] == 201) {
                                swal({
                                    title: "Great",
                                    text: "Removed from Shortlist",
                                    icon: "success",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            } else if (data['status'] == 202) {
                                swal({
                                    title: "Great",
                                    text: "updated from Shortlist",
                                    icon: "success",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            } else {
                                swal({
                                    title: "Oops...",
                                    text: "There was a problem, Please try again",
                                    icon: "error",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            }
                            setTimeout(function() {
                                document.location.reload();
                            }, 2000);

                        }
                    });
                }
            </script>

        </body>

        </html>
    <?php
} else {
  header("location:login-page.php");
}
?>