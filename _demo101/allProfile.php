<?php
include 'dbconn.php';
include 'vars.php';
include 'include/load.php';
connect_db();
require_once 'include/class-Emailer.php';
$mail_obj = new Emailer();

?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!DOCTYPE html>
<html lang="en">

<!-- for blurr filter 
        style="-webkit-filter: blur(4px);filter: blur(10px);"   -->

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
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">
    <!-- animation link css  -->
    <link rel="https://unpkg.com/aos@2.3.0/dist/aos.css">
</head>

<body>
    <?php
    include 'mainHeader.php';
    ?>
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Reviews</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container">
            <div class="row ">
                <?php
                if (isset($_SESSION['id'])) { //if logged in
                  $current_user_id = $_SESSION['id'];
                  $current_user_email = "";
                  $current_user_name = "";

                  $ur = "";
                  $ua = "";
                  $ug = "";
                  $planType = "";
                  $type_plan_id = 0;
                  $sql = "SELECT * FROM `user_regiter` where `id` = " . $_SESSION['id'];
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $ua = $row['age'];
                    $ur = $row['religion'];
                    $ug = $row['gender'];
                    $planType = $row['type_plan'];
                    $type_plan_id = $row['type_plan_id'];
                    $current_user_email = $row['email'];
                    $current_user_name = $row['name'];
                  }
                  $CHECK = "SELECT IFNULL(COUNT(*),0) AS total FROM `visited_profile_records` WHERE `profile_viewer`='$current_user_id' AND `plan_id`='$type_plan_id'";
                  $CHECK_r = $db->query($CHECK);
                  $where_cond = "";
                  $check_total = ($CHECK_r['success'] == 1 && !empty($CHECK_r['rows'])) ? $CHECK_r['rows'][0]['total'] : 0;
                  if ($check_total == 0) {
                    $where_cond = " cp.id = ur.type_plan_id ";
                  } else {
                    $where_cond = " vpr.plan_id = ur.type_plan_id ";
                  }
                  $remaining_q = "SELECT GROUP_CONCAT( vpr.profile_viewed) AS visited_members,
                                    (ifnull(cp.visiblePro,0)  -  COUNT(vpr.id) ) AS remaining_profile_visit
                                    FROM
                                        `visited_profile_records` AS vpr
                                    LEFT JOIN user_regiter AS ur ON ur.id = vpr.profile_viewer
                                    LEFT JOIN create_plans AS cp ON cp.id = vpr.plan_id
                                    WHERE
                                        $where_cond AND vpr.profile_viewer = $current_user_id ";
                  $remaining_r = $db->query($remaining_q);
                  $remaining_profile_visit = ($remaining_r['success'] == 1 && !empty($remaining_r['rows'])) ? $remaining_r['rows'][0]['remaining_profile_visit'] : 0;
                  $visited_members = ($remaining_r['success'] == 1 && !empty($remaining_r['rows']) && !empty($remaining_r['rows'][0]['visited_members'])) ? explode(',', $remaining_r['rows'][0]['visited_members']) : array();
                  // print_r($visited_members);                    
                  if (isset($_POST['send_btn'])) {
                    // $usrid = $_POST['usr_id'];
                    $send_id = $_POST['send_id'];
                    $user_details = $db->query("SELECT * FROM `user_regiter` WHERE `id` =  $send_id");
                    $user_data = !empty($user_details['rows']) ? $user_details['rows'][0] : array();
                    $user_name = $user_data['name'];
                    $user_email = $user_data['email'];


                    $existing_data = $db->query("SELECT `id`, `user_id`, `sent_id`, `status`, `created_at`, `updated_at` FROM `requests` WHERE sent_id='$send_id' AND user_id='$current_user_id' ");
                    //echo '<pre>';
                    $old_data = $existing_data["rows"];
                    if (empty($old_data)) {
                      $sql2 = mysqli_query($conn, "INSERT INTO `requests`(`user_id`, `sent_id`, status ) VALUES ('$_SESSION[id]','$send_id', 1)");
                      //print_r($sql2);
                    } else {
                      $db_update = $db->query_update("UPDATE requests SET status = 1 WHERE  sent_id='$send_id' AND user_id='$current_user_id'");
                      $sql2 = $db_update['success']; //'Request already sent';
                    }
                    if ($sql2 == 1) {

                      $current_user_body = "Hi $current_user_name, <br>You have seen $user_name's profile ";
                      $mail_obj->send_email('Your have visited profile', $current_user_body, $current_user_email, '', '');
                      $user_body = "Hi $user_name, <br>Your profile was visited by $current_user_name ";
                      $mail_obj->send_email('Your profile was visited', $user_body, $user_email, '', '');
                      ?>
                                                    <script>
                                                        // alert("request sent successfuly");
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
                                                                // alert("request sent successfuly");
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
                    $sql = mysqli_query($conn, "UPDATE `requests` SET status = 0 WHERE `user_id` =  '$_SESSION[id]' AND `sent_id` = '$del' ");
                    if ($sql) {
                      ?>
                                                    <script>
                                                        // alert("request deleted successfuly");
                                                        swal({
                                                            title: "Great",
                                                            text: "Your request has been deleted successully",
                                                            icon: "success",
                                                            buttons: true,
                                                            dangerMode: true,
                                                        })
                                                    </script>
                                                    <?php
                    }
                  }
                  if (isset($_GET['filter_search_btn'])) {
                    $gender = $_GET['gender'];
                    $age_min = $_GET['age_min'];
                    $age_max = $_GET['age_max'];
                    $religion = $_GET['religion'];
                    $currentDate = date("Y-m-d");
                    $status = "";
                    if ($age_min == "" && $religion != "" || $age_max == null && $religion != null) {
                      // echo 'hello';
                      $sql = "SELECT * FROM  `user_regiter` where `gender`='$gender' AND  `religion`='$religion' AND `plan_expiry_date` >= '$currentDate' AND `id` != '$_SESSION[id]' AND `status` != 0";
                      $result = mysqli_query($conn, $sql);
                      //echo "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' ";
                      // die;
                      while ($row = mysqli_fetch_array($result)) {

                        $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' ");
                        while ($num1 = mysqli_fetch_array($clr)) {
                          $status = $num1['status'];
                          $userplan = $row['type_plan'];
                        }
                        $count = mysqli_num_rows($clr);
                        if ($status != 0 && $_SESSION['id'] != $row['id'] && $status != "" && $count != 0) {
                          ?>
                                                                            <div class="col-md-3  col-lg-3 col-sm-3  mt-4 ">
                                                                                <div class="vendor-list-block mb30 shadow card">


                                                                                    <!-- match list block -->
                                                                                    <div class="card-header vendor-img" style="width: 100%;">

                                                                                        <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" style="height: 17.5rem;width: 17rem; "></a>
                                                                                        <?php
                                                                                        // $label = mysqli_query($conn, " SELECT * FROM `create_plans` where `heading` = '$userplan' ");
                                                                                        // $labelname = mysqli_fetch_array($label);
                                                                                        ?>
                                                                                        <div class="<?php echo $row['label']; ?>"></div>
                                                                                        <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                                                                        <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                        <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                        <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                    </div>
                                                                                    <div class="card-body vendor-detail">
                                                                                        <!-- Match details -->
                                                                                        <div class="caption">
                                                                                            <h2><a href="" class="title">
                                                                                                    <?php $pieces = explode(" ", $row['name']);
                                                                                                    echo $pieces[0]; ?></h2></a>
                                                                                            </h2>
                                                                                            <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
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
                                                                                            </div>
                                                                                            <div>
                                                                                                <?php
                                                                                                $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                //  echo '------------------';
                                                                                                //  print_r($is_interest_shown);
                                                                                                ?>
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php endif; ?>
                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                        <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                        <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                    <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog">
                                                                                            <div class="modal-content">
                                                                                                <form action="" method="post">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        Do You Really Want to Delete this Request?
                                                                                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                        <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                        echo $pieces[0]; ?></h2>?
                                                                                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                        <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
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
                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-xl">
                                                                                            <!-- Modal User Profile View -->
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header card-header " style="margin: auto;">
                                                                                                    <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                </div>
                                                                                                <div class="modal-body " style="padding: 2rem;">
                                                                                                    <!-- Begin Page Content -->
                                                                                                    <!-- <div class="container-fluid"> -->
                                                                                                    <!-- Page Heading -->
                                                                                                    <div class="row card shadow mb-4">
                                                                                                        <!-- Profil card -->
                                                                                                        <!-- <div class="card shadow mb-4"> -->
                                                                                                        <div class="card-header py-3">
                                                                                                        </div>
                                                                                                        <div class="card-body col-md-12">
                                                                                                            <div class="row" style="line-height: 1.5;">
                                                                                                                <div class="col-md-12">
                                                                                                                    <div class="text-center" style="padding:1rem ;">
                                                                                                                        <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="row">
                                                                                                                <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                    $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                      // echo $row['city'];
                                                                                                                      ?>
                                                                                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                    <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                    <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                    <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                    <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                    <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                    <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                    <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                    <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                            </div>
                                                                                                            <!-- </ul> -->

                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!-- </div> -->
                                                                                                    <!-- </div> -->
                                                                                                    <div class="modal-footer">
                                                                                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                        <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--end Modal User Profile View -->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.Match details -->
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.match list block -->

                                                                <?php } else if ($status == 0 && $_SESSION['id'] != $row['id'] || $count <= 0 || $status == "") { ?>
                                                                                    <div class="col-md-3 col-lg-3 col-sm-3  mt-4 ">
                                                                                        <div class="vendor-list-block mb30 shadow card">
                                                                                            <!-- match list block -->
                                                                                            <div class="card-header vendor-img" style="width: 100%;">
                                                                                                <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                                <?php
                                                                                                // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                                // $labelname = mysqli_fetch_array($label);
                                                                                                ?>
                                                                                                <div class="<?php echo $row['label']; ?>"></div>
                                                                                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                                                                                <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                            </div>
                                                                                            <div class="card-body vendor-detail">
                                                                                                <!-- Match details -->
                                                                                                <div class="caption">
                                                                                                    <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                                                    echo $pieces[0]; ?></a></h2>
                                                                                                    <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
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
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <?php
                                                                                                        $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                        $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                        $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                        //  echo '------------------';
                                                                                                        //  print_r($is_interest_shown);
                                                                                                        ?>
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php endif; ?>
                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog">
                                                                                                    <div class="modal-content">
                                                                                                        <form action="" method="post">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to Delete this Request?
                                                                                                                <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                                echo $pieces[0]; ?></h2>?
                                                                                                                <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                                <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
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
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-xl">
                                                                                                    <!-- Modal User Profile View -->
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header card-header " style="margin: auto;">
                                                                                                            <h4 class="modal-title text-center " style="color: #f9a630;" id="exampleModalLabel">User Profile</h4>
                                                                                                        </div>
                                                                                                        <div class="modal-body " style="padding: 2rem;">
                                                                                                            <!-- Begin Page Content -->
                                                                                                            <!-- <div class="container-fluid"> -->
                                                                                                            <!-- Page Heading -->
                                                                                                            <div class="row card shadow mb-4">
                                                                                                                <!-- Profil card -->
                                                                                                                <!-- <div class="card shadow mb-4"> -->
                                                                                                                <div class="card-header py-3">
                                                                                                                </div>
                                                                                                                <div class="card-body col-md-12">
                                                                                                                    <div class="row" style="line-height: 1.5;">
                                                                                                                        <div class="col-md-12">
                                                                                                                            <div class="text-center" style="padding:1rem ;">
                                                                                                                                <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                              // echo $row['city'];
                                                                                                                              ?>
                                                                                                                                        <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                            <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                            <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                            <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                            <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                            <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                            <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-6">
                                                                                                                            <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                            <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                            <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                                    </div>
                                                                                                                    <!-- </ul> -->

                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!-- </div> -->
                                                                                                            <!-- </div> -->
                                                                                                            <div class="modal-footer">
                                                                                                                <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                                <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!--end Modal User Profile View -->
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                                <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                            <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- /.Match details -->
                                                                                    </div>
                                                                                    <!-- /.match list block -->

                                                                <?php }
                      }
                    } else if ($age_min != "" && $religion == "" || $age_max != null && $religion == null) {
                      //echo 'bye';
                      $status = "";
                      $sql = "SELECT * FROM  `user_regiter` where `gender`='$gender' AND  `age` BETWEEN '$age_min' and '$age_max' AND `plan_expiry_date` >= '$currentDate' AND `id` != '$_SESSION[id]' AND `status` != 0";

                      $result = mysqli_query($conn, $sql);
                      while ($row = mysqli_fetch_array($result)) {
                        $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' ");
                        while ($num1 = mysqli_fetch_array($clr)) {
                          $status = $num1['status'];
                        }
                        $count = mysqli_num_rows($clr);
                        if ($status != 0 && $_SESSION['id'] != $row['id'] && $status != "" && $count != 0) {
                          ?>
                                                                                    <div class="col-md-3 col-lg-3 col-sm-3  mt-4 ">
                                                                                        <div class="vendor-list-block mb30 shadow card">
                                                                                            <!-- match list block -->
                                                                                            <div class="card-header vendor-img" style="width: 100%;">
                                                                                                <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                                <?php
                                                                                                // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                                // $labelname = mysqli_fetch_array($label);
                                                                                                ?>
                                                                                                <div class="<?php echo $row['label']; ?>"></div>
                                                                                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                                                                                <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                            </div>
                                                                                            <div class="card-body vendor-detail">
                                                                                                <!-- Match details -->
                                                                                                <div class="caption">
                                                                                                    <h2>
                                                                                                        <a href="" class="title">
                                                                                                            <?php
                                                                                                            $pieces = explode(" ", $row['name']);
                                                                                                            echo $pieces[0];
                                                                                                            ?>
                                                                                                        </a>
                                                                                                    </h2>
                                                                                                    <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                                                    <div class="vendor-meta"><span class="location">
                                                                                                            <i class="fa fa-map-marker map-icon"></i>
                                                                                                    <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                      echo strtoupper($rowid['name']);
                                                                                                    } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                                                      $resultid = mysqli_query($conn, $sql1);
                                                                                                      while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                        echo strtoupper($rowid['name']);
                                                                                                      } ?></span>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <?php
                                                                                                        $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                        $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                        $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                        ?>
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                                    <!-- <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button> -->
                                                                                                <?php endif; ?>
                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog">
                                                                                                    <div class="modal-content">
                                                                                                        <form action="" method="post">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to Delete this Request?
                                                                                                                <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                                echo $pieces[0]; ?></h2>?
                                                                                                                <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                                <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
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
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                                <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                            <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-xl">
                                                                                                    <!-- Modal User Profile View -->
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header card-header " style="margin: auto;">
                                                                                                            <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                        </div>
                                                                                                        <div class="modal-body " style="padding: 2rem;">
                                                                                                            <!-- Begin Page Content -->
                                                                                                            <!-- <div class="container-fluid"> -->
                                                                                                            <!-- Page Heading -->
                                                                                                            <div class="row card shadow mb-4">
                                                                                                                <!-- Profil card -->
                                                                                                                <!-- <div class="card shadow mb-4"> -->
                                                                                                                <div class="card-header py-3">
                                                                                                                </div>
                                                                                                                <div class="card-body col-md-12">
                                                                                                                    <div class="row" style="line-height: 1.5;">
                                                                                                                        <div class="col-md-12">
                                                                                                                            <div class="text-center" style="padding:1rem ;">
                                                                                                                                <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                              // echo $row['city'];
                                                                                                                              ?>
                                                                                                                                        <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                            <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                            <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                            <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                            <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                            <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                            <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-6">
                                                                                                                            <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                            <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                            <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                                    </div>
                                                                                                                    <!-- </ul> -->

                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!-- </div> -->
                                                                                                            <!-- </div> -->
                                                                                                            <div class="modal-footer">
                                                                                                                <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                                <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!--end Modal User Profile View -->
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- /.Match details -->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.match list block -->

                                                                <?php } else if ($status == 0 && $_SESSION['id'] != $row['id'] || $count <= 0 || $status == "") { ?>
                                                                                            <div class="col-md-3  col-lg-3 col-sm-3  mt-4 ">
                                                                                                <div class="vendor-list-block mb30 shadow card">
                                                                                                    <!-- match list block -->
                                                                                                    <div class="card-header vendor-img" style="width: 100%;">
                                                                                                        <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                                <?php
                                                                                                // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                                // $labelname = mysqli_fetch_array($label);
                                                                                                ?>
                                                                                                        <div class="<?php echo $row['label']; ?>"></div>
                                                                                                        <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                                                                                        <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                                        <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                                        <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                                    </div>
                                                                                                    <div class="card-body vendor-detail">
                                                                                                        <!-- Match details -->
                                                                                                        <div class="caption">
                                                                                                            <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                                                            echo $pieces[0]; ?></a></h2>
                                                                                                            <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
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
                                                                                                            </div>
                                                                                                            <div>
                                                                                                        <?php
                                                                                                        $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                        $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                        $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                        ?>
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                                            <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php endif; ?>
                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                                        <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                                        <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                                        <div class="modal-dialog" role="document">
                                                                                                            <div class="modal-content">
                                                                                                                <div class="modal-header">
                                                                                                                    <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                                    <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                                </div>
                                                                                                                <div class="modal-footer">
                                                                                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                        <div class="modal-dialog">
                                                                                                            <div class="modal-content">
                                                                                                                <form action="" method="post">
                                                                                                                    <div class="modal-header">
                                                                                                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                                    </div>
                                                                                                                    <div class="modal-body">
                                                                                                                        Do You Really Want to Delete this Request?
                                                                                                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                                    </div>
                                                                                                                    <div class="modal-footer">
                                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                        <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                                    </div>
                                                                                                                    <div class="modal-body">
                                                                                                                        Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                                        echo $pieces[0]; ?></h2>?
                                                                                                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                                    </div>
                                                                                                                    <div class="modal-footer">
                                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                        <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                                    </div>
                                                                                                                </form>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
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
                                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                        <div class="modal-dialog modal-xl">
                                                                                                            <!-- Modal User Profile View -->
                                                                                                            <div class="modal-content">
                                                                                                                <div class="modal-header card-header " style="margin: auto;">
                                                                                                                    <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                                </div>
                                                                                                                <div class="modal-body " style="padding: 2rem;">
                                                                                                                    <!-- Begin Page Content -->
                                                                                                                    <!-- <div class="container-fluid"> -->
                                                                                                                    <!-- Page Heading -->
                                                                                                                    <div class="row card shadow mb-4">
                                                                                                                        <!-- Profil card -->
                                                                                                                        <!-- <div class="card shadow mb-4"> -->
                                                                                                                        <div class="card-header py-3">
                                                                                                                        </div>
                                                                                                                        <div class="card-body col-md-12">
                                                                                                                            <div class="row" style="line-height: 1.5;">
                                                                                                                                <div class="col-md-12">
                                                                                                                                    <div class="text-center" style="padding:1rem ;">
                                                                                                                                        <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                              // echo $row['city'];
                                                                                                                              ?>
                                                                                                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                                    <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                                    <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                                    <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                                    <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                                    <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                                    <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                                    <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                                    <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                                            </div>
                                                                                                                            <!-- </ul> -->

                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <!-- </div> -->
                                                                                                                    <!-- </div> -->
                                                                                                                    <div class="modal-footer">
                                                                                                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                                        <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!--end Modal User Profile View -->
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!-- /.Match details -->
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- /.match list block -->

                                                                    <?php }
                      }
                    } else if (($age_min != "" && $religion != "" || $age_max != null && $religion != null)) {
                      //   echo 'good bye';die;
                      $status = "";
                      $sql = "SELECT * FROM  `user_regiter` where `gender`='$gender'  AND  `religion`='$religion' AND  `age` BETWEEN '$age_min' and '$age_max' AND `plan_expiry_date` >= '$currentDate' AND `id` != '$_SESSION[id]' AND `status` != 0";

                      $result = mysqli_query($conn, $sql);

                      if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_array($result)) {

                          $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' ");
                          while ($num1 = mysqli_fetch_array($clr)) {
                            $status = $num1['status'];
                          }
                          //echo $status;
                          $count = mysqli_num_rows($clr);
                          if ($status != 0 && $_SESSION['id'] != $row['id'] && $status != "" && $count != 0) {
                            ?>
                                                                                                        <div class="col-md-3 col-lg-3 col-sm-3  mt-4 ">
                                                                                                            <div class="vendor-list-block mb30 shadow card">
                                                                                                                <!-- match list block -->
                                                                                                                <div class="card-header vendor-img" style="width: 100%;">
                                                                                                                    <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                                            <?php
                                                                                                            // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                                            // $labelname = mysqli_fetch_array($label);
                                                                                                            ?>
                                                                                                                    <div class="<?php echo $row['label']; ?>"></div>
                                                                                                                    <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                                                                                                    <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                                                    <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                                                    <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                                                </div>
                                                                                                                <div class="card-body vendor-detail">
                                                                                                                    <!-- Match details -->
                                                                                                                    <div class="caption">
                                                                                                                        <h2>
                                                                                                                            <a href="" class="title">
                                                                                                                        <?php
                                                                                                                        $pieces = explode(" ", $row['name']);
                                                                                                                        echo $pieces[0];
                                                                                                                        ?>
                                                                                                                            </a>
                                                                                                                        </h2>
                                                                                                                        <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                                                                        <div class="vendor-meta">
                                                                                                                            <span class="location">
                                                                                                                                <i class="fa fa-map-marker map-icon"></i>
                                                                                                                        <?php
                                                                                                                        $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                                                                        $resultid = mysqli_query($conn, $sql1);
                                                                                                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                          echo strtoupper($rowid['name']);
                                                                                                                        }
                                                                                                                        ?> ,
                                                                                                                        <?php
                                                                                                                        $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                                                                        $resultid = mysqli_query($conn, $sql1);
                                                                                                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                          echo strtoupper($rowid['name']);
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                    <?php
                                                                                                                    $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                                    $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                                    $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                                    //  echo '------------------';
                                                                                                                    //  print_r($is_interest_shown);
                                                                                                                    ?>
                                                                                                            <?php if ($is_interest_shown == 1): ?>
                                                                                                                                        <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                            <?php elseif ($is_interest_shown == 0): ?>
                                                                                                                                        <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                                        <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                                                        <!-- <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button> -->
                                                                                                            <?php endif; ?>
                                                                                                            <?php if ($planType == "Free"): ?>
                                                                                                                                        <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                        <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                                                    <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                                        <?php else: ?>
                                                                                                                                                    <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                                        <?php endif; ?>
                                                                                                            <?php endif; ?>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                                                    <div class="modal-dialog" role="document">
                                                                                                                        <div class="modal-content">
                                                                                                                            <div class="modal-header">
                                                                                                                                <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                                                <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                                            </div>
                                                                                                                            <div class="modal-body">
                                                                                                                                You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                                            </div>
                                                                                                                            <div class="modal-footer">
                                                                                                                                <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                                                <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                                                <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                                    <div class="modal-dialog">
                                                                                                                        <div class="modal-content">
                                                                                                                            <form action="" method="post">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">
                                                                                                                                    Do You Really Want to Delete this Request?
                                                                                                                                    <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                                    <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">
                                                                                                                                    Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                                                    echo $pieces[0]; ?></h2>?
                                                                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                                                    <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                                    <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                                                </div>
                                                                                                                            </form>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
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
                                                                                                                                <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                                                <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                                    <div class="modal-dialog modal-xl">
                                                                                                                        <!-- Modal User Profile View -->
                                                                                                                        <div class="modal-content">
                                                                                                                            <div class="modal-header card-header " style="margin: auto;">
                                                                                                                                <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                                            </div>
                                                                                                                            <div class="modal-body " style="padding: 2rem;">
                                                                                                                                <!-- Begin Page Content -->
                                                                                                                                <!-- <div class="container-fluid"> -->
                                                                                                                                <!-- Page Heading -->
                                                                                                                                <div class="row card shadow mb-4">
                                                                                                                                    <!-- Profil card -->
                                                                                                                                    <!-- <div class="card shadow mb-4"> -->
                                                                                                                                    <div class="card-header py-3">
                                                                                                                                    </div>
                                                                                                                                    <div class="card-body col-md-12">
                                                                                                                                        <div class="row" style="line-height: 1.5;">
                                                                                                                                            <div class="col-md-12">
                                                                                                                                                <div class="text-center" style="padding:1rem ;">
                                                                                                                                                    <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="row">
                                                                                                                                            <div class="col-md-6">
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
                                                                                                                                <?php }
                                                                                                                                        $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                                        $resultid = mysqli_query($conn, $sql1);
                                                                                                                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                                          // echo $row['city'];
                                                                                                                                          ?>
                                                                                                                                                            <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                                <?php } ?>
                                                                                                                                                <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                                                <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                                                <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                                                <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                                                <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                                                <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-6">
                                                                                                                                                <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                                                <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                                                <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                                                        </div>
                                                                                                                                        <!-- </ul> -->

                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <!-- </div> -->
                                                                                                                                <!-- </div> -->
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                                                    <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <!--end Modal User Profile View -->
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!-- /.Match details -->
                                                                                                        </div>
                                                                                                        <!-- /.match list block -->

                                                                            <?php } else if ($status == 0 && $_SESSION['id'] != $row['id'] || $count <= 0 || $status == "") { ?>
                                                                                                                <div class="col-md-3 col-lg-3 col-sm-3  mt-4 ">
                                                                                                                    <div class="vendor-list-block mb30 shadow card">
                                                                                                                        <!-- match list block -->
                                                                                                                        <div class="card-header vendor-img" style="width: 100%;">
                                                                                                                            <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                                            <?php
                                                                                                            // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                                            // $labelname = mysqli_fetch_array($label);
                                                                                                            ?>
                                                                                                                            <div class="<?php echo $row['label']; ?>"></div>
                                                                                                                            <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                                                                                                            <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                                                            <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                                                            <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                                                        </div>
                                                                                                                        <div class="card-body vendor-detail">
                                                                                                                            <!-- Match details -->
                                                                                                                            <div class="caption">
                                                                                                                                <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                                                                                echo $pieces[0]; ?></a></h2>
                                                                                                                                <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
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
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                    <?php
                                                                                                                    $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                                    $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                                    $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';

                                                                                                                    ?>
                                                                                                            <?php if ($is_interest_shown == 1): ?>
                                                                                                                                                <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                            <?php elseif ($is_interest_shown == 0): ?>
                                                                                                                                                <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                                                <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                                                                <!-- <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button> -->
                                                                                                            <?php endif; ?>
                                                                                                            <?php if ($planType == "Free"): ?>
                                                                                                                                                <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                        <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                                                            <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                                        <?php else: ?>
                                                                                                                                                            <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                                        <?php endif; ?>
                                                                                                            <?php endif; ?>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                                                            <div class="modal-dialog" role="document">
                                                                                                                                <div class="modal-content">
                                                                                                                                    <div class="modal-header">
                                                                                                                                        <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                                                        <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-body">
                                                                                                                                        You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-footer">
                                                                                                                                        <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                                                        <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                                                        <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                                            <div class="modal-dialog">
                                                                                                                                <div class="modal-content">
                                                                                                                                    <form action="" method="post">
                                                                                                                                        <div class="modal-header">
                                                                                                                                            <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                                                        </div>
                                                                                                                                        <div class="modal-body">
                                                                                                                                            Do You Really Want to Delete this Request?
                                                                                                                                            <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                                                        </div>
                                                                                                                                        <div class="modal-footer">
                                                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                                            <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                                                        </div>
                                                                                                                                        <div class="modal-body">
                                                                                                                                            Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                                                            echo $pieces[0]; ?></h2>?
                                                                                                                                            <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                                                            <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                                                        </div>
                                                                                                                                        <div class="modal-footer">
                                                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                                            <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                                                        </div>
                                                                                                                                    </form>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
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
                                                                                                                                        <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                                                        <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                                            <div class="modal-dialog modal-xl">
                                                                                                                                <!-- Modal User Profile View -->
                                                                                                                                <div class="modal-content">
                                                                                                                                    <div class="modal-header card-header " style="margin: auto;">
                                                                                                                                        <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-body " style="padding: 2rem;">
                                                                                                                                        <!-- Begin Page Content -->
                                                                                                                                        <!-- <div class="container-fluid"> -->
                                                                                                                                        <!-- Page Heading -->
                                                                                                                                        <div class="row card shadow mb-4">
                                                                                                                                            <!-- Profil card -->
                                                                                                                                            <!-- <div class="card shadow mb-4"> -->
                                                                                                                                            <div class="card-header py-3">
                                                                                                                                            </div>
                                                                                                                                            <div class="card-body col-md-12">
                                                                                                                                                <div class="row" style="line-height: 1.5;">
                                                                                                                                                    <div class="col-md-12">
                                                                                                                                                        <div class="text-center" style="padding:1rem ;">
                                                                                                                                                            <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="row">
                                                                                                                                                    <div class="col-md-6">
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
                                                                                                                                <?php }
                                                                                                                                        $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                                        $resultid = mysqli_query($conn, $sql1);
                                                                                                                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                                          // echo $row['city'];
                                                                                                                                          ?>
                                                                                                                                                                    <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                                <?php } ?>
                                                                                                                                                        <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                                                        <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                                                        <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                                                        <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                                                        <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                                                        <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-md-6">
                                                                                                                                                        <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                                                        <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                                                        <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                                                                </div>
                                                                                                                                                <!-- </ul> -->

                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <!-- </div> -->
                                                                                                                                        <!-- </div> -->
                                                                                                                                        <div class="modal-footer">
                                                                                                                                            <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                                                            <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <!--end Modal User Profile View -->
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <!-- /.Match details -->
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <!-- /.match list block -->

                                                                        <?php }
                        }
                      } else {
                        ?>
                                                                                <div class="no_records_found">
                                                                                    No records found
                                                                                </div>
                                                                <?php
                      }
                      //  die;
                    }
                  }
                  if (isset($_GET['profile_type']) && $_GET['profile_type'] == "female_prof") {
                    $currentDate = date("Y-m-d");
                    $status = "";

                    $sqlfml = "SELECT * FROM  `user_regiter` where `gender` = 'Female' AND `plan_expiry_date` >= '$currentDate' AND `id` != '$_SESSION[id]' AND `status` != 0";

                    $result1 = mysqli_query($conn, $sqlfml);
                    if ($result1->num_rows > 0) {
                      while ($row = mysqli_fetch_array($result1)) {
                        $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' ");
                        while ($num1 = mysqli_fetch_array($clr)) {
                          $status = $num1['status'];
                        }
                        $count = mysqli_num_rows($clr);
                        if ($status != 0 && $_SESSION['id'] != $row['id'] && $status != "" && $count != 0) {
                          ?>
                                                                            <div class="col-md-3  col-lg-3  mt-4 ">
                                                                                <div class="vendor-list-block mb30 shadow card">
                                                                                    <!-- match list block -->
                                                                                    <div class="card-header vendor-img" style="width: 100%;">
                                                                                        <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                         
                                                                                        <div class="<?php echo $row['label']; ?>"></div>
                                                                                        <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                                                                        <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                        <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                        <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                    </div>
                                                                                    <div class="card-body vendor-detail">
                                                                                        <!-- Match details -->
                                                                                        <div class="caption">
                                                                                            <h2>
                                                                                                <a href="" class="title">
                                                                                                    <?php
                                                                                                    $pieces = explode(" ", $row['name']);
                                                                                                    echo $pieces[0];
                                                                                                    ?>
                                                                                                </a>
                                                                                            </h2>
                                                                                            <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                                            <div class="vendor-meta">
                                                                                                <span class="location">
                                                                                                    <i class="fa fa-map-marker map-icon"></i>
                                                                                                    <?php
                                                                                                    $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                      echo strtoupper($rowid['name']);
                                                                                                    }
                                                                                                    ?> ,
                                                                                                    <?php
                                                                                                    $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                      echo strtoupper($rowid['name']);
                                                                                                    }
                                                                                                    ?>
                                                                                                </span>
                                                                                            </div>
                                                                                            <div>
                                                                                                <?php
                                                                                                $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                ?>
                                                        
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php endif; ?>
                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                   
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                        <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                        <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                    <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog">
                                                                                            <div class="modal-content">
                                                                                                <form action="" method="post">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        Do You Really Want to Delete this Request?
                                                                                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                        <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                        echo $pieces[0]; ?></h2>?
                                                                                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                        <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
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
                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-xl">
                                                                                            <!-- Modal User Profile View -->
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header card-header " style="margin: auto;">
                                                                                                    <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                </div>
                                                                                                <div class="modal-body " style="padding: 2rem;">
                                                                                                    <!-- Begin Page Content -->
                                                                                                    <!-- <div class="container-fluid"> -->
                                                                                                    <!-- Page Heading -->
                                                                                                    <div class="row card shadow mb-4">
                                                                                                        <!-- Profil card -->
                                                                                                        <!-- <div class="card shadow mb-4"> -->
                                                                                                        <div class="card-header py-3">
                                                                                                        </div>
                                                                                                        <div class="card-body col-md-12">
                                                                                                            <div class="row" style="line-height: 1.5;">
                                                                                                                <div class="col-md-12">
                                                                                                                    <div class="text-center" style="padding:1rem ;">
                                                                                                                        <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="row">
                                                                                                                <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                    $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                      // echo $row['city'];
                                                                                                                      ?>
                                                                                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                    <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                    <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                    <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                    <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                    <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                    <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                    <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                    <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                            </div>
                                                                                                            <!-- </ul> -->

                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!-- </div> -->
                                                                                                    <!-- </div> -->
                                                                                                    <div class="modal-footer">
                                                                                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                        <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--end Modal User Profile View -->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.Match details -->
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.match list block -->

                                                                <?php } else if ($status == 0 && $_SESSION['id'] != $row['id'] || $count <= 0 || $status == "") { ?>
                                                                                    <div class="col-md-3  col-lg-3  mt-4 ">
                                                                                        <div class="vendor-list-block mb30 shadow card">
                                                                                            <!-- match list block -->
                                                                                            <div class="card-header vendor-img" style="width: 100%;">
                                                                                                <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                
                                                                                                <div class="<?php echo $row['label']; ?>"></div>
                                                                                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                                                                                <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                            </div>
                                                                                            <div class="card-body vendor-detail">
                                                                                                <!-- Match details -->
                                                                                                <div class="caption">
                                                                                                    <h2><a href="" class="title">
                                                                                                            <?php
                                                                                                            $pieces = explode(" ", $row['name']);
                                                                                                            echo $pieces[0];
                                                                                                            ?>
                                                                                                        </a>
                                                                                                    </h2>
                                                                                                    <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                                                    <div class="vendor-meta">
                                                                                                        <span class="location">
                                                                                                            <i class="fa fa-map-marker map-icon"></i>
                                                                                                            <?php
                                                                                                            $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                              echo strtoupper($rowid['name']);
                                                                                                            }
                                                                                                            ?> ,
                                                                                                            <?php
                                                                                                            $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                              echo strtoupper($rowid['name']);
                                                                                                            }
                                                                                                            ?>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <?php
                                                                                                        $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                        $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                        $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';

                                                                                                        ?>
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php endif; ?>

                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <?php //echo '<pre><br> remaining_profile_visit'; print_r($remaining_profile_visit); ?>
                                                                                                            <?php // echo '<br> visited_members'; print_r($visited_members); ?>
                                                                                                            <?php // echo '<br> row id'; print_r($row['id']); //die;?>
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                                <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                            <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog">
                                                                                                    <div class="modal-content">
                                                                                                        <form action="" method="post">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to Delete this Request?
                                                                                                                <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                                echo $pieces[0]; ?></h2>?
                                                                                                                <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                                <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
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
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-xl">
                                                                                                    <!-- Modal User Profile View -->
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header card-header " style="margin: auto;">
                                                                                                            <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                        </div>
                                                                                                        <div class="modal-body " style="padding: 2rem;">
                                                                                                            <!-- Begin Page Content -->
                                                                                                            <!-- <div class="container-fluid"> -->
                                                                                                            <!-- Page Heading -->
                                                                                                            <div class="row card shadow mb-4">
                                                                                                                <!-- Profil card -->
                                                                                                                <!-- <div class="card shadow mb-4"> -->
                                                                                                                <div class="card-header py-3">
                                                                                                                </div>
                                                                                                                <div class="card-body col-md-12">
                                                                                                                    <div class="row" style="line-height: 1.5;">
                                                                                                                        <div class="col-md-12">
                                                                                                                            <div class="text-center" style="padding:1rem ;">
                                                                                                                                <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                              // echo $row['city'];
                                                                                                                              ?>
                                                                                                                                        <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                            <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                            <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                            <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                            <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                            <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                            <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-6">
                                                                                                                            <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                            <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                            <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                                    </div>
                                                                                                                    <!-- </ul> -->
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!-- </div> -->
                                                                                                            <!-- </div> -->
                                                                                                            <div class="modal-footer">
                                                                                                                <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                                <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!--end Modal User Profile View -->
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- /.Match details -->
                                                                                    </div>
                                                                                    <!-- /.match list block -->

                                                            <?php }
                      }
                    } else {
                      ?>
                                                    <div class="no_records_found">
                                                        No records found
                                                    </div>
                                                    <?php
                    }
                  }
                  if (isset($_GET['profile_type']) && $_GET['profile_type'] == "male_prof") {
                    $currentDate = date("Y-m-d");
                    $status = "";
                    $sqlml = "SELECT * FROM  `user_regiter` where `gender` = 'Male' AND `plan_expiry_date` >= '$currentDate' AND `id` != '$_SESSION[id]' AND `status` != 0";
                    $result2 = mysqli_query($conn, $sqlml);
                    if ($result2->num_rows > 0) {
                      while ($row = mysqli_fetch_array($result2)) {
                        $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' ");
                        while ($num1 = mysqli_fetch_array($clr)) {
                          $status = $num1['status'];
                        }
                        $count = mysqli_num_rows($clr);
                        if ($status != 0 && $_SESSION['id'] != $row['id'] && $status != "" && $count != 0) {
                          ?>
                                                                            <div class="col-md-3  col-lg-3  mt-4 ">
                                                                                <div class="vendor-list-block mb30 shadow card">
                                                                                    <!-- match list block -->
                                                                                    <div class="card-header vendor-img" style="width: 100%;">
                                                                                        <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" style="height: 17.5rem;width: 17rem;  "></a>
                                                                                        <?php
                                                                                        // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                        // $labelname = mysqli_fetch_array($label);
                                                                                        ?>
                                                                                        <div class="<?php echo $row['label']; ?>"></div>
                                                                                        <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                                                                        <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                        <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                        <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                    </div>
                                                                                    <div class="card-body vendor-detail">
                                                                                        <!-- Match details -->
                                                                                        <div class="caption">
                                                                                            <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                                            echo $pieces[0]; ?></a></h2>
                                                                                            <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
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
                                                                                            </div>
                                                                                            <div>
                                                                                                <?php
                                                                                                $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                //  echo '------------------';
                                                                                                //  print_r($is_interest_shown);
                                                                                                ?>
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php endif; ?>

                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                        <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                        <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.Match details -->
                                                                                    <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                    <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog">
                                                                                            <div class="modal-content">
                                                                                                <form action="" method="post">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        Do You Really Want to Delete this Request?
                                                                                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                        <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                        echo $pieces[0]; ?></h2>?
                                                                                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                        <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
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
                                                                                                    <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-xl">
                                                                                            <!-- Modal User Profile View -->
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header card-header " style="margin: auto;">
                                                                                                    <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                </div>
                                                                                                <div class="modal-body " style="padding: 2rem;">
                                                                                                    <!-- Begin Page Content -->
                                                                                                    <!-- <div class="container-fluid"> -->
                                                                                                    <!-- Page Heading -->
                                                                                                    <div class="row card shadow mb-4">
                                                                                                        <!-- Profil card -->
                                                                                                        <!-- <div class="card shadow mb-4"> -->
                                                                                                        <div class="card-header py-3">
                                                                                                        </div>
                                                                                                        <div class="card-body col-md-12">
                                                                                                            <div class="row" style="line-height: 1.5;">
                                                                                                                <div class="col-md-12">
                                                                                                                    <div class="text-center" style="padding:1rem ;">
                                                                                                                        <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="row">
                                                                                                                <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                    $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                      // echo $row['city'];
                                                                                                                      ?>
                                                                                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                    <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                    <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                    <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                    <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                    <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                    <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                    <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                    <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                            </div>
                                                                                                            <!-- </ul> -->

                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!-- </div> -->
                                                                                                    <!-- </div> -->
                                                                                                    <div class="modal-footer">
                                                                                                        <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                        <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--end Modal User Profile View -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.match list block -->

                                                                <?php } else if ($status == 0 && $_SESSION['id'] != $row['id'] || $count <= 0 || $status == "") { ?>
                                                                                    <div class="col-md-3  col-lg-3  mt-4 ">
                                                                                        <div class="vendor-list-block mb30 shadow card">
                                                                                            <!-- match list block -->
                                                                                            <div class="card-header vendor-img" style="width: 100%;">
                                                                                                <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                                <?php
                                                                                                // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                                // $labelname = mysqli_fetch_array($label);
                                                                                                ?>
                                                                                                <div class="<?php echo $row['label']; ?>"></div>
                                                                                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                                                                                <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                                <!-- <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                                            </div>
                                                                                            <div class="card-body vendor-detail">
                                                                                                <!-- Match details -->
                                                                                                <div class="caption">
                                                                                                    <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                                                    echo $pieces[0]; ?></a></h2>
                                                                                                    <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
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
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <?php
                                                                                                        $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[id]' ";
                                                                                                        $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                                        $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                                        //  echo '------------------';
                                                                                                        //  print_r($is_interest_shown);
                                                                                                        ?>
                                                                                                <?php if ($is_interest_shown == 1): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                                                                <?php elseif ($is_interest_shown == 0): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php else: ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                                <?php endif; ?>
                                                                                                <?php if ($planType == "Free"): ?>
                                                                                                                    <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>
                                                                                                <?php else: ?>
                                                                                                            <?php if (in_array($row['id'], $visited_members) || $remaining_profile_visit > 0): ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3 view_btn" id="view_btn_<?php echo $row['id']; ?>" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                                            <?php else: ?>
                                                                                                                                <button type="button" data-toggle="modal" data-target="#not_visited" data-whatever="@not_visited" class="btn btn-sm col-3 btn-secondary mt-3" name="not_visited"><i class="fas fa-eye"></i></button>
                                                                                                            <?php endif; ?>
                                                                                                <?php endif; ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- /.Match details -->
                                                                                            <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog">
                                                                                                    <div class="modal-content">
                                                                                                        <form action="" method="post">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to Delete this Request?
                                                                                                                <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="delete_btn" type="submit" class="btn btn-warning" id="dlt_btn">Confirm</button>
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
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Do You Really Want to send this Request to <?php $pieces = explode(" ", $row['name']);
                                                                                                                echo $pieces[0]; ?></h2>?
                                                                                                                <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                                                <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                                                                <button name="send_btn" type="submit" class="btn btn-warning" id="send_btn">Confirm</button>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
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
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-xl">
                                                                                                    <!-- Modal User Profile View -->
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header card-header " style="margin: auto;">
                                                                                                            <h4 class="modal-title text-center " style="color: #f9a630 ;" id="exampleModalLabel">User Profile</h4>
                                                                                                        </div>
                                                                                                        <div class="modal-body " style="padding: 2rem;">
                                                                                                            <!-- Begin Page Content -->
                                                                                                            <!-- <div class="container-fluid"> -->
                                                                                                            <!-- Page Heading -->
                                                                                                            <div class="row card shadow mb-4">
                                                                                                                <!-- Profil card -->
                                                                                                                <!-- <div class="card shadow mb-4"> -->
                                                                                                                <div class="card-header py-3">
                                                                                                                </div>
                                                                                                                <div class="card-body col-md-12">
                                                                                                                    <div class="row" style="line-height: 1.5;">
                                                                                                                        <div class="col-md-12">
                                                                                                                            <div class="text-center" style="padding:1rem ;">
                                                                                                                                <img class="img-fluid px-3 px-sm-4" style="height: 16rem;border-radius: 11%; border: 3px solid #f9a630;padding: 0 !important;" src="user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-md-6">
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
                                                                                                                    <?php }
                                                                                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                                              // echo $row['city'];
                                                                                                                              ?>
                                                                                                                                        <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                                    <?php } ?>
                                                                                                                            <b>Address :</b> <?php echo $row['address']; ?><br>
                                                                                                                            <b>Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                                                                            <b>Collage :</b> <?php echo $row['collage']; ?><br>
                                                                                                                            <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                                                                                            <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                                                                                            <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-6">
                                                                                                                            <b>Height :</b> <?php echo $row['height']; ?><br>
                                                                                                                            <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                                                                                            <b>Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
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
                                                                                                                    </div>
                                                                                                                    <!-- </ul> -->

                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!-- </div> -->
                                                                                                            <!-- </div> -->
                                                                                                            <div class="modal-footer">
                                                                                                                <!-- <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button> -->
                                                                                                                <button name="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!--end Modal User Profile View -->
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal fade" id="not_visited" tabindex="-1" role="dialog" aria-labelledby="not_visited">
                                                                                                <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" id="myModalLabel">Unlock by membership plan</h4>
                                                                                                            <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                            <a href="pricing-plan.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.match list block -->
                                                            <?php }
                      }
                    } else {
                      ?>
                                                    <div class="no_records_found">
                                                        No records found
                                                    </div>
                                            <?php
                    }
                  }
                } else { // if not logged in
                  ?>
                            <script>
                                window.onload = function() {
                                    $("#exampleModalCenter").modal();
                                }
                            </script>
                            <!-- Button trigger modal -->
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
                                            Lookes like you want to go through the profiles But your not logged in.
                                            You have to log in or register first to watch all the profiles.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                            <?php
                                            if (session_id() == '') {
                                              session_start();
                                            }
                                            $search_filter = '';
                                            $search_all = (isset($_GET['filter_search_btn'])) ? '?gender=' . $_GET['gender'] . '&religion=' . $_GET['religion'] . '&age_min=' . $_GET['age_min'] . '&age_max=' . $_GET['age_max'] . '&filter_search_btn=filter_search_btn' : '';
                                            $profile_type = (isset($_GET['profile_type'])) ? '?profile_type=' . $_GET['profile_type'] : '';
                                            if (isset($_GET['profile_type'])) {
                                              $search_filter = $profile_type;
                                            } elseif (isset($_GET['filter_search_btn'])) {
                                              $search_filter = $search_all;
                                            }

                                            $return_page = "allProfile.php$search_filter";
                                            $_SESSION['return_page'] = $return_page;
                                            ?>
                                            <a href="login-page.php"><button type="button" class="btn btn-default">Login/Register</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (isset($_GET['filter_search_btn'])) {
                              $gender = $_GET['gender'];
                              $age_min = $_GET['age_min'];
                              $age_max = $_GET['age_max'];
                              $religion = $_GET['religion'];
                              $currentDate = date("Y-m-d");

                              $status = "";
                              if ($age_min == "" && $religion != "" || $age_max == null && $religion != null) {
                                echo 'hello';
                                die;
                                $sql = "SELECT * FROM  `user_regiter` where `gender`='$gender' AND  `religion`='$religion' AND `plan_expiry_date` >= '$currentDate' AND `status` != 0";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                  ?>
                                                                <div class="col-md-3  col-lg-3  mt-4 ">

                                                                    <div class="vendor-list-block mb30 shadow card" style="-webkit-filter: blur(4px);filter: blur(10px);">
                                                                        <!-- match list block -->
                                                                        <div class="card-header vendor-img" style="width:100%;">

                                                                            <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                            <?php
                                                                            // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                            // $labelname = mysqli_fetch_array($label);
                                                                            ?>
                                                                            <div class="<?php echo $row['label']; ?>"></div>

                                                                            <div class="favourite-bg"><button data-toggle="modal" data-target="#loginFirst<?php $row['id']; ?>" class="btn"><i class="fa fa-heart like"></i></button></div>
                                                                            <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                            <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                            <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div>
                                                                        </div>
                                                                        <div class="card-body vendor-detail">
                                                                            <!-- Match details -->
                                                                            <div class="caption">
                                                                                <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                                echo $pieces[0]; ?></a></h2>
                                                                                <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                                <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                                                                        <?php
                                                                                        $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                                        $resultid = mysqli_query($conn, $sql1);
                                                                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                          echo strtoupper($rowid['name']);
                                                                                        }
                                                                                        ?> ,<?php
                                                                                         $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                                         $resultid = mysqli_query($conn, $sql1);
                                                                                         while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                           echo strtoupper($rowid['name']);
                                                                                         }
                                                                                         ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.Match details -->
                                                                    </div>
                                                                    <!-- /.match list block -->
                                                                </div>
                                                                <!-- ----------login first -->
                                                                <form action="" method="POST">
                                                                    <div class="modal fade" id="loginFirst<?php $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myModalLabel">Add this profile to your shortlist</h4>
                                                                                    <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Please Login or Register first to Add this profile .
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                    <a href="login-page.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            <?php
                                }
                              } else if ($age_min != "" && $religion == "" || $age_max != null && $religion == null) {
                                echo 'bye';
                                die;
                                $sql = "SELECT * FROM  `user_regiter` where `gender`='$gender' AND  `age` BETWEEN '$age_min' and '$age_max' AND `plan_expiry_date` >= '$currentDate' AND `status` != 0";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                  ?>
                                                                        <div class="col-md-3  col-lg-3  mt-4 ">
                                                                            <div class="vendor-list-block mb30 shadow card" style="-webkit-filter: blur(4px);filter: blur(10px);">

                                                                                <!-- match list block -->
                                                                                <div class="card-header vendor-img" style="width:100%;">

                                                                                    <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                    <?php
                                                                                    // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                    // $labelname = mysqli_fetch_array($label);
                                                                                    ?>
                                                                                    <div class="<?php echo $row['label']; ?>"></div>

                                                                                    <div class="favourite-bg"><button data-toggle="modal" data-target="#loginFirst<?php $row['id']; ?>" class="btn"><i class="fa fa-heart like"></i></button></div>
                                                                                    <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                    <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                    <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div>
                                                                                </div>
                                                                                <div class="card-body vendor-detail">
                                                                                    <!-- Match details -->
                                                                                    <div class="caption">
                                                                                        <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                                        echo $pieces[0]; ?></a></h2>
                                                                                        <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                                        <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                                                                                <?php
                                                                                                $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                                                $resultid = mysqli_query($conn, $sql1);
                                                                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                  echo strtoupper($rowid['name']);
                                                                                                }
                                                                                                ?> ,<?php
                                                                                                 $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                                                 $resultid = mysqli_query($conn, $sql1);
                                                                                                 while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                   echo strtoupper($rowid['name']);
                                                                                                 }
                                                                                                 ?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.Match details -->
                                                                            </div>
                                                                            <!-- /.match list block -->
                                                                        </div>
                                                                        <!-- ----------login first -->
                                                                        <form action="" method="POST">
                                                                            <div class="modal fade" id="loginFirst<?php $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h4 class="modal-title" id="myModalLabel">Add this profile to your shortlist</h4>
                                                                                            <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            Please Login or Register first to Add this profile .
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                            <a href="login-page.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                            <?php
                                }
                              } else if ($gender != "" && $age_min != "" && $religion != "" && $age_max != null && $religion != null) {
                                // echo 'good bye';
                                // die;
                                $sql = "SELECT * FROM  `user_regiter` where `gender`='$gender'  AND  `religion`='$religion' AND  `age` BETWEEN '$age_min' and '$age_max' AND `plan_expiry_date` >= '$currentDate' AND `status` != 0";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                  ?>
                                                                                <div class="col-md-3  col-lg-3  mt-4 ">
                                                                                    <div class="vendor-list-block mb30 shadow card" style="-webkit-filter: blur(4px);filter: blur(10px);">
                                                                                        <!-- match list block -->
                                                                                        <div class="card-header vendor-img" style="width:100%;">

                                                                                            <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                                    <?php
                                                                                    // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                                    // $labelname = mysqli_fetch_array($label);
                                                                                    ?>
                                                                                            <div class="<?php echo $row['label']; ?>"></div>

                                                                                            <div class="favourite-bg"><button data-toggle="modal" data-target="#loginFirst<?php $row['id']; ?>" class="btn"><i class="fa fa-heart like"></i></button></div>
                                                                                            <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                                            <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                                            <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div>
                                                                                        </div>
                                                                                        <div class="card-body vendor-detail">
                                                                                            <!-- Match details -->
                                                                                            <div class="caption">
                                                                                                <h2><a href="" class="title">
                                                                                        <?php $pieces = explode(" ", $row['name']);
                                                                                        echo $pieces[0]; ?>
                                                                                                    </a>
                                                                                                </h2>
                                                                                                <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                                                <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                                                                                <?php
                                                                                                $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                                                $resultid = mysqli_query($conn, $sql1);
                                                                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                  echo strtoupper($rowid['name']);
                                                                                                }
                                                                                                ?> ,<?php
                                                                                                 $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                                                 $resultid = mysqli_query($conn, $sql1);
                                                                                                 while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                   echo strtoupper($rowid['name']);
                                                                                                 }
                                                                                                 ?>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- /.Match details -->
                                                                                    </div>
                                                                                    <!-- /.match list block -->
                                                                                </div>
                                                                                <!-- ----------login first -->
                                                                                <form action="" method="POST">
                                                                                    <div class="modal fade" id="loginFirst<?php $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h4 class="modal-title" id="myModalLabel">Add this profile to your shortlist</h4>
                                                                                                    <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    Please Login or Register first to Add this profile .
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                                                    <a href="login-page.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                                                    <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                            <?php
                                }
                              }
                            }
                            if (isset($_GET['female_prof'])) {
                              $currentDate = date("Y-m-d");
                              $sqlfml = "SELECT * FROM  `user_regiter` where `gender` = 'Female' AND `plan_expiry_date` >= '$currentDate' ";
                              $result1 = mysqli_query($conn, $sqlfml);
                              while ($row = mysqli_fetch_array($result1)) {
                                ?>
                                                    <div class="col-md-3  col-lg-3  mt-4 ">
                                                        <div class="vendor-list-block mb30 shadow card" style="-webkit-filter: blur(4px);filter: blur(10px);">
                                                            <!-- match list block -->
                                                            <div class="card-header vendor-img" style="width:100%;">
                                                                <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                <?php
                                                                // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                // $labelname = mysqli_fetch_array($label);
                                                                ?>
                                                                <div class="<?php echo $row['label']; ?>"></div>
                                                                <div class="favourite-bg"><button data-toggle="modal" data-target="#loginFirst<?php $row['id']; ?>" class="btn"><i class="fa fa-heart like"></i></button></div>
                                                                <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div>
                                                            </div>
                                                            <div class="card-body vendor-detail">
                                                                <!-- Match details -->
                                                                <div class="caption">
                                                                    <h2>
                                                                        <a href="" class="title">
                                                                            <?php
                                                                            $pieces = explode(" ", $row['name']);
                                                                            echo $pieces[0];
                                                                            ?>
                                                                        </a>
                                                                    </h2>
                                                                    <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                    <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                                                            <?php
                                                                            $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                              echo strtoupper($rowid['name']);
                                                                            }
                                                                            ?> ,
                                                                            <?php
                                                                            $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                              echo strtoupper($rowid['name']);
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.Match details -->
                                                        </div>
                                                        <!-- /.match list block -->
                                                    </div>
                                                    <!-- ----------login first -->
                                                    <form action="" method="POST">
                                                        <div class="modal fade" id="loginFirst<?php $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">Add this profile to your shortlist</h4>
                                                                        <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Please Login or Register first to Add this profile .
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                        <a href="login-page.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                        <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php
                              }
                            }
                            if (isset($_GET['male_prof'])) {
                              $currentDate = date("Y-m-d");
                              $sqlml = "SELECT * FROM  `user_regiter` where `gender` = 'Male' AND `plan_expiry_date` >= '$currentDate' AND `status` != 0";
                              $result2 = mysqli_query($conn, $sqlml);
                              while ($row = mysqli_fetch_array($result2)) {
                                ?>
                                                    <div class="col-md-3  col-lg-3  mt-4 ">
                                                        <div class="vendor-list-block mb30 shadow card" style="-webkit-filter: blur(4px);filter: blur(10px);">
                                                            <!-- match list block -->
                                                            <div class="card-header vendor-img" style="width:100%;">
                                                                <a href=""><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" ></a>
                                                                <?php
                                                                // $label = mysqli_query($conn, " SELECT * FROM `create_plans`");
                                                                // $labelname = mysqli_fetch_array($label);
                                                                ?>
                                                                <div class="<?php echo $row['label']; ?>"></div>
                                                                <div class="favourite-bg"><button data-toggle="modal" data-target="#loginFirst<?php $row['id']; ?>" class="btn"><i class="fa fa-heart like"></i></button></div>
                                                                <div class="category-badge"><a href="" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                <div class="favorite-action"> <a href="" class="fav-icon"><i class="fa fa-close"></i></a> </div>
                                                            </div>
                                                            <div class="card-body vendor-detail">
                                                                <!-- Match details -->
                                                                <div class="caption">
                                                                    <h2><a href="" class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                    echo $pieces[0]; ?></a></h2>
                                                                    <h6><a href="" class="relign"><?php echo $row['religion']; ?></a></h6>
                                                                    <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                                                            <?php
                                                                            $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                                            $resultid = mysqli_query($conn, $sql1);
                                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                              echo strtoupper($rowid['name']);
                                                                            }
                                                                            ?> ,<?php
                                                                             $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                                             $resultid = mysqli_query($conn, $sql1);
                                                                             while ($rowid = mysqli_fetch_array($resultid)) {
                                                                               echo strtoupper($rowid['name']);
                                                                             }
                                                                             ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- .Match details -->
                                                        </div>
                                                    </div>
                                                    <!-- .match list block -->
                                                    <!-- ----------login first -->
                                                    <form action="" method="POST">
                                                        <div class="modal fade" id="loginFirst<?php $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">Add this profile to your shortlist</h4>
                                                                        <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Please Login or Register first to Add this profile .
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                                                        <a href="login-page.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                                                        <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                <?php }
                            }
                }

                ?>

            </div>
        </div>
    </div>
    <style>
        .no_records_found {
            font-size: 25px;
            font-weight: bold;
            margin: 60px;
            padding: 25px;
            text-align: center;
            border: 1px solid #ddd;
        }
    </style>
    <input type="hidden" id="current_user_id" value="<?php echo $current_user_id; ?>">
    <?php
    include 'footer.php';
    ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flex Nav Script -->
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/navigation.js"></script>
    <script type="text/javascript" src="js/bootstrap-select.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script>
        AOS.init({
            duration: 1200,
        })
    </script>
    <script>
        $(".view_btn").on("click", function() {
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
        });

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
                        // alert("Added to Shortlist");
                        swal({
                            title: "Great",
                            text: "Added to Shortlist",
                            icon: "success",
                            buttons: true,
                            dangerMode: true,
                        })
                        setTimeout(function() {window.location.reload();}, 3000);
                    } else if (data['status'] == 201) {
                        // alert("Removed from Shortlist");
                        swal({
                            title: "Great",
                            text: "Removed from Shortlist",
                            icon: "success",
                            buttons: true,
                            dangerMode: true,
                        })
                        setTimeout(function() {window.location.reload();}, 3000);
                    } else if (data['status'] == 202) {
                        // alert("updated from Shortlist");
                        swal({
                            title: "Great",
                            text: "updated from Shortlist",
                            icon: "success",
                            buttons: true,
                            dangerMode: true,
                        })
                        setTimeout(function() {window.location.reload();}, 3000);
                    } else {
                        // alert("There is a problem ");
                        swal({
                            title: "Oops...",
                            text: "There was a problem, Please try again",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                            setTimeout(function() {window.location.reload();}, 3000);
                    }
                }
            });
        }
    </script>

</body>

</html>