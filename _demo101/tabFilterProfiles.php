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
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php
    include 'mainHeader.php';
    ?>
    <!-- <div class="tp-page-head"> -->
    <!-- page header -->
    <!-- <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle">
                            <i class="icon icon-size-60 icon-newly-married-couple icon-white"></i>
                        </div>
                        <h1>Scroll through all Profiles</h1>
                        <p>Find your perfect Partner with us. Search For matches from worldwide suiters.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- /.page header -->
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Profiles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        $current_user_id = $_SESSION['id'];
        $current_user_email = "";
        $current_user_name = "";
        $ur = "";
        $ua = "";
        $ug = "";
        $planType = "";
        $sql = "SELECT * FROM `user_regiter` where `id` = " . $_SESSION['id'];
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $ua = $row['age'];
            $ur = $row['religion'];
            $ug = $row['gender'];
            $planType =  $row['type_plan'];
            $current_user_email =  $row['email'];
            $current_user_name =  $row['name'];
        }
        if (isset($_POST['send_btn'])) {
            $send_id = $_POST['send_id'];
            $user_details = $db->query("SELECT * FROM `user_regiter` WHERE `id` =  $send_id");
            $user_data = !empty($user_details['rows']) ? $user_details['rows'][0] : array();
            $user_name = $user_data['name'];
            $user_email = $user_data['email'];

            $existing_data = $db->query("SELECT `id`, `user_id`, `sent_id`, `status`, `created_at`, `updated_at` FROM `requests` WHERE sent_id='$send_id' AND user_id='$current_user_id' ");
            $old_data = $existing_data["rows"];
            if (empty($old_data)) {
                $sql2 = mysqli_query($conn, "INSERT INTO `requests`(`user_id`, `sent_id`, status ) VALUES ('$_SESSION[id]','$send_id', 1)");
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
        ?>
        <div class="main-container">
            <div class="container">
                <div class="row ">
                    <?php
                    $status = "";
                    $g = $_GET['gender'];
                    $countryId = $_GET['coldata'];
                    $result = mysqli_query($conn, "SELECT * FROM `user_regiter` where `country` = '$countryId' AND `gender` = '$g' OR `state` = '$countryId' AND `gender` = '$g' OR `city` = '$countryId' AND `gender` = '$g' OR `religion` = '$countryId' AND `gender` = '$g' OR `sub-com` = '$countryId' AND `gender` = '$g' OR `HighEdu` = '$countryId' AND `gender` = '$g' OR `prof` = '$countryId' AND `gender` = '$g' OR `specialization` = '$countryId' AND `gender` = '$g' OR `lang` = '$countryId' AND `gender` = '$g' OR `marStat` = '$countryId' AND `gender` = '$g' ");
                    // print_r($result);
                    while ($row = mysqli_fetch_array($result)) {
                        // print_r($_SESSION['id']);
                        // print_r($row['id']);
                        $clr = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `user_id` = '$_SESSION[id]' AND `liked_p_id` = '$row[id]' ");
                        while ($num1 = mysqli_fetch_array($clr)) {
                            $status = $num1['status'];
                        }
                        $count = mysqli_num_rows($clr);
                        if (($status == 1) && ($_SESSION['id'] != $row['id'])) {
                    ?>
                            <div class="col-md-2 mt-4">
                                <div class="vendor-list-block mb30 shadow card">
                                    <!-- match list block -->
                                    <div class="card-header vendor-img" style="width: 100%;">
                                        <a><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" style="width: 100%;height: 19rem;"></a>
                                        <div class="<?php echo $row['label']; ?>"></div>
                                        <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                        <div class="category-badge"><a class="category-link"><?php echo $row['specialization']; ?></a></div>
                                        <div class="price-lable"><?php echo $row['age']; ?></div>
                                        <!-- <div class="favorite-action"> <a  class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                    </div>
                                    <div class="card-body vendor-detail">
                                        <!-- Match details -->
                                        <div class="caption">
                                            <h2><a class="title"><?php $pieces = explode(" ", $row['name']);
                                                                    echo $pieces[0]; ?></a></h2>
                                            <h4><a href="" class="relign"><?php echo $row['religion']; ?></a></h4>
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
                                                <?php if ($is_interest_shown == 1) : ?>
                                                    <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                <?php elseif ($is_interest_shown == 0) : ?>
                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                <?php else : ?>
                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                <?php endif; ?>
                                                <?php
                                                if ($planType == "Free") {
                                                    echo '<button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>';
                                                } else {
                                                ?>
                                                    <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3" name="view_user"><i class="fas fa-eye"></i></button>
                                                <?php } ?>
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
                                                                <?php  }
                                                                $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                $resultid = mysqli_query($conn, $sql1);
                                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                                    // echo $row['city'];
                                                                ?>
                                                                    <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                <?php  } ?>
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
                        <?php } else  if (($status == 0 || $status == "") && ($_SESSION['id'] != $row['id'])) {  ?>
                            <div class="col-md-2   mt-4 ">
                                <div class="vendor-list-block mb30 shadow card">
                                    <!-- match list block -->
                                    <div class="card-header vendor-img" style="width: 100%;">
                                        <a><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" style="width: 100%;height: 19rem;"></a>
                                        <div class="<?php echo $row['label']; ?>"></div>
                                        <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                        <div class="category-badge"><a class="category-link"><?php echo $row['specialization']; ?></a></div>
                                        <div class="price-lable"><?php echo $row['age']; ?></div>
                                        <!-- <div class="favorite-action"> <a  class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                    </div>
                                    <div class="card-body vendor-detail">
                                        <!-- Match details -->
                                        <div class="caption">
                                            <h2><a class="title"><?php $pieces = explode(" ", $row['name']);
                                                                    echo $pieces[0]; ?></a></h2>
                                            <h4><a href="" class="relign"><?php echo $row['religion']; ?></a></h4>
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
                                                <?php if ($is_interest_shown == 1) : ?>
                                                    <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button>
                                                <?php elseif ($is_interest_shown == 0) : ?>
                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                <?php else : ?>
                                                    <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                <?php endif; ?>
                                                <?php
                                                if ($planType == "Free") {
                                                    echo '<button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>';
                                                } else {
                                                ?>
                                                    <button type="button" data-toggle="modal" data-target="#view_fml_user<?php echo $row['id']; ?>" data-whatever="@view" class="btn btn-sm col-3 btn-secondary mt-3" name="view_user"><i class="fas fa-eye"></i></button>
                                                <?php } ?>
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
                                                                <?php  }
                                                                $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                                $resultid = mysqli_query($conn, $sql1);
                                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                                    // echo $row['city'];
                                                                ?>
                                                                    <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                <?php  } ?>
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
                        <?php } else {
                        ?>
                            <div class="no_records_found">
                                No records found
                            </div>
                        <?php
                        }
                        ?>

                    <?php
                    }       ?>
                </div>
            </div>
        </div>
    <?php  } else { ?>
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
                        $coldata = isset($_REQUEST['coldata']) ? $_REQUEST['coldata'] : '';
                        $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                        $return_page = "tabFilterProfiles.php?coldata=$coldata&gender=$gender";

                        if (session_id() == '') {
                            session_start();
                        }
                        $_SESSION['return_page'] = $return_page;
                        // print_r($_SESSION['return_page']);
                        // die;
                        ?>
                        <a href="login-page.php"><button type="button" class="btn btn-default">Login/Register</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-container">
            <div class="container">

                <div class="row ">
                    <?php
                    $g = $_GET['gender'];
                    $countryId = $_GET['coldata'];
                    $result = mysqli_query($conn, "SELECT * FROM `user_regiter` where `country` = '$countryId' AND `gender` = '$g' OR `state` = '$countryId' AND `gender` = '$g' OR `city` = '$countryId' AND `gender` = '$g' OR `religion` = '$countryId' AND `gender` = '$g' OR `sub-com` = '$countryId' AND `gender` = '$g' OR `HighEdu` = '$countryId' AND `gender` = '$g' OR `prof` = '$countryId' AND `gender` = '$g' OR `specialization` = '$countryId' AND `gender` = '$g' OR `lang` = '$countryId' AND `gender` = '$g' OR `marStat` = '$countryId' AND `gender` = '$g' ");
                    // print_r($result);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="col-md-2   mt-4 ">
                            <div class="vendor-list-block mb30 shadow card" style="-webkit-filter: blur(3px);filter: blur(10px);">
                                <!-- match list block -->
                                <div class="card-header vendor-img" style="width: 100%;">
                                    <a><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-3" style="width: 100%;height: 19rem;"></a>
                                    <div class="<?php echo $row['label']; ?>"></div>
                                    <div class="favourite-bg"><button data-toggle="modal" data-target="#loginFirst<?php $row['id']; ?>" class="btn"><i class="fa fa-heart like"></i></button></div>
                                    <div class="category-badge"><a class="category-link"><?php echo $row['specialization']; ?></a></div>
                                    <div class="price-lable"><?php echo $row['age']; ?></div>
                                    <!-- <div class="favorite-action"> <a  class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                </div>
                                <div class="card-body vendor-detail">
                                    <!-- Match details -->
                                    <div class="caption">
                                        <h2><a class="title"><?php $pieces = explode(" ", $row['name']);
                                                                echo $pieces[0]; ?></a></h2>
                                        <h4><a href="" class="relign"><?php echo $row['religion']; ?></a></h4>
                                        <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                                <?php $sql1 = "SELECT * FROM cities where `id` = " . $row['city'];
                                                $resultid = mysqli_query($conn, $sql1);
                                                while ($rowid = mysqli_fetch_array($resultid)) {
                                                    echo strtoupper($rowid['name']);
                                                } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $row['state'];
                                                        $resultid = mysqli_query($conn, $sql1);
                                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                                            echo strtoupper($rowid['name']);
                                                        }
                                                        ?></span>
                                        </div>
                                        <div> 
                                            <!-- <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                            <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                            <button type="button" data-toggle="modal" data-target="#purchase" data-whatever="@prchs" class="btn btn-sm col-3 btn-secondary mt-3" name="prchase"><i class="fas fa-eye"></i></button>  -->
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
                                                            <?php  }
                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                            $resultid = mysqli_query($conn, $sql1);
                                                            while ($rowid = mysqli_fetch_array($resultid)) {
                                                                // echo $row['city'];
                                                            ?>
                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php  } ?>
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
                        <!-- ----------login first -->
                        <form action="" method="POST">
                            <div class="modal fade" id="loginFirst<?php $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Add this profile to your shortlist</h4>
                                            <!-- <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span  aria-hidden="true" >&times;</span></button> -->
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
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php  }  ?>
    
    <div class="tabFilterProfilesfooter">  
    <?php
    include 'footer.php';
    ?>
    
    </div>
        
        
    <script>
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
                        alert("Added to Shortlist");
                        document.location.reload();
                    } else if (data['status'] == 202) {
                        alert("Removed from Shortlist");
                        document.location.reload();
                    } else {
                        alert("There is a problem ");
                        document.location.reload();
                    }
                }
            });
        }
    </script>
   
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
</body>
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
</html>