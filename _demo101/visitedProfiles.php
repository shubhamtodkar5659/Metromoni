<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
include 'vars.php';
include 'include/load.php';
connect_db();
include 'dbconn.php';
$sesn_id = $_SESSION['id'];
if (isset($_SESSION['id'])) {
  $current_user_id = $_SESSION['id'];
  $u_id = $_SESSION['id'];
  $sesn_id = $_SESSION['id'];

  $ur = "";
  $ua = "";
  $type_plan_id = 0;
  $ug = "";
  $current_user_name = "";
  $current_user_email = "";
  $current_user_plan = "";
  $visiblePro = 0;

  $sql = "SELECT *, cp.visiblePro FROM `user_regiter`
                LEFT JOIN create_plans AS cp ON cp.id = user_regiter.type_plan_id
                where user_regiter.`id` = $current_user_id ";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $visiblePro = $row['visiblePro'];
    $current_user_name = $row['name'];
    $current_user_email = $row['email'];
    $current_user_plan = $row['type_plan'];
    $type_plan_id = $row['type_plan_id'];
    $ua = $row['age'];
    $ur = $row['religion'];
    $ug = $row['gender'];
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

  if (isset($_POST['send_btn'])) {
    // $usrid = $_POST['usr_id'];
    $send_id = $_POST['send_id'];
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
  ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>Visited Profiles</title>
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
                            <div class=" vendor-list-block card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary text-center">Visited Profiles</h6>
                                </div>
                                <div class="card-body surface">

                                    <div class="row profile mb-4  ">
                                        <?php
                                        // echo ;
                                        $res = mysqli_query($conn, "SELECT * FROM `visited_profile_records` WHERE profile_viewer = '$current_user_id' ");
                                        $count = mysqli_num_rows($res);
                                        if ($count > 0) {
                                          ?>
                                                <div class=" remaining_profile_visit">
                                                    You have <?php echo $remaining_profile_visit; ?> Profile visits left.
                                                </div>
                                                <?php
                                                while ($row = mysqli_fetch_array($res)) {
                                                  // $liked = $row['liked_p_id'];
                                                  // echo  $liked ;
                                                  $sql = mysqli_query($conn, "SELECT * FROM `user_regiter` where `id`= '$row[profile_viewed]'");
                                                  while ($rows = mysqli_fetch_array($sql)) {
                                                    ?>

                                                                <div class="col-md-6 col-sm-12   col-lg-3  mt-4 surface">
                                                                    <div class="vendor-list-block mb30 shadow card gradient-top">
                                                                        <!-- match list block -->
                                                                        <div class="vendor-img " style="width: 100%;">
                                                                            <img src="user_image/<?php echo $rows['filename']; ?>" alt="wedding venue" class="match-img py-0">
                                                                            <div class="<?php echo $rows['label'] ?>"></div>
                                                                            <div class="favourite-bg">
                                                                                <?php //echo "<button onclick='like(" . $rows['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; 
                                                                                        ?>
                                                                                <button onclick="like( <?php echo $rows['id']; ?>)" class='btn'>
                                                                                    <?php
                                                                                    $liked_icon = $db->query_one("SELECT status FROM `shortlist` WHERE liked_p_id = '$rows[id]' AND user_id = '$current_user_id'");
                                                                                    $liked_icon = ($liked_icon['success'] == 1 && !empty($liked_icon['rows'])) ? $liked_icon['rows'][0][0] : 0;
                                                                                    $css_color = ($liked_icon) ? 'color:red' : '';
                                                                                    ?>
                                                                                    <i class='fa fa-heart like' style='<?php echo $css_color; ?>'> </i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="category-badge" class="category-link"><?php echo $rows['specialization']; ?></div>
                                                                            <div class="price-lable"><?php echo $rows['age']; ?></div>
                                                                        </div>
                                                                        <div class="card-body vendor-detail">
                                                                            <!-- Match details -->
                                                                            <div class="caption">
                                                                                <h2 class="title"> <?php $pieces = explode(" ", $rows['name']);
                                                                                echo $pieces[0]; ?></h2>
                                                                                <h4 class="relign"><?php echo $rows['religion']; ?></h4>
                                                                                <div class="vendor-meta"><span class="location"> <i class="fa fa-map-marker map-icon"></i>
                                                                                        <?php $sql1 = "SELECT * FROM cities where `id` = " . $rows['city'];
                                                                                        $resultid = mysqli_query($conn, $sql1);
                                                                                        while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                          echo strtoupper($rowid['name']);
                                                                                        } ?> ,<?php $sql1 = "SELECT * FROM states where `id` = " . $rows['state'];
                                                                                          $resultid = mysqli_query($conn, $sql1);
                                                                                          while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                            echo strtoupper($rowid['name']);
                                                                                          } ?></span>
                                                                                    <div>

                                                                                        <?php
                                                                                        $is_interest_shown_q = "SELECT status FROM requests WHERE user_id = '$current_user_id' AND sent_id = '$row[profile_viewed]' ";
                                                                                        $is_interest_shown_r = $db->query_one($is_interest_shown_q);
                                                                                        $is_interest_shown = !empty($is_interest_shown_r['rows'][0][0]) ? $is_interest_shown_r['rows'][0][0] : '';
                                                                                        ?>
                                                                                        <?php if ($is_interest_shown == 1): ?>
                                                                                                <!-- <button type="button" data-toggle="modal" data-target="#delete_confirm<?php echo $row['id']; ?>" data-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"> <i class="fa fa-thumbs-down"></i></button></i></button> -->
                                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['liked_p_id']; ?>" data-bs-whatever="@delet" class="btn btn-sm col-3 btn-danger mt-3" name="delReq" id="delReq"><i class="fa fa-thumbs-down"></i></button>
                                                                                        <?php elseif ($is_interest_shown == 0): ?>
                                                                                                <!-- <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button> -->
                                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['liked_p_id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                        <?php elseif ($is_interest_shown == 2 || $is_interest_shown == 3): ?>
                                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#confirmone<?php echo $in_data['id']; ?>" data-bs-whatever="@accept" class="btn btn-sm col-3 btn-primary mt-3" name="Req" id="Req"><i class="fa fa-check"></i></button>
                                                                                        <?php else: ?>
                                                                                                <!-- <button type="button" data-toggle="modal" data-target="#send_confirm<?php echo $row['id']; ?>" data-whatever="@send" class="btn btn-sm col-3 btn-info mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button> -->
                                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirm<?php echo $row['liked_p_id']; ?>" data-bs-whatever="@send" class="btn btn-sm col-3 btn-primary mt-3" name="senReq" id="senReq"> <i class="fa fa-thumbs-up"></i></button>
                                                                                        <?php endif; ?>
                                                                                        <?php if ($current_user_plan != 'Free'): ?>
                                                                                                <button id="view_profile" type="button" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $rows['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3" name="view_user"><i class="fas fa-eye"></i></button>
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.Match details -->
                                                                    </div>
                                                                    <div class="modal fade" id="view_fml_user<?php echo $rows['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                                                                                                        <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="user_image/<?php echo $rows['filename']; ?>" alt="Upload Image">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <b>Name :</b> <?php echo $rows['name']; ?><br>
                                                                                                    <b>E-mail :</b> <?php echo $rows['email']; ?><br>
                                                                                                    <b>Phone Number :</b> <?php echo $rows['phone']; ?><br>
                                                                                                    <?php
                                                                                                    $sql1 = "SELECT * FROM `countries` where `id` = " . $rows['country'];
                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                      ?>
                                                                                                            <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                        <?php
                                                                                                    }
                                                                                                    $sql1 = "SELECT * FROM `states` where `id` = " . $rows['state'];
                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                      ?>
                                                                                                            <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                    <?php }
                                                                                                    $sql1 = "SELECT * FROM `cities` where `id` = " . $rows['city'];
                                                                                                    $resultid = mysqli_query($conn, $sql1);
                                                                                                    while ($rowid = mysqli_fetch_array($resultid)) {
                                                                                                      ?>
                                                                                                            <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                                                                    <?php } ?>
                                                                                                    <b>Address :</b> <?php echo $rows['address']; ?><br>
                                                                                                    <b>Marital Status :</b> <?php echo $rows['marStat']; ?><br>
                                                                                                    <b>Mother Tongue :</b> <?php echo $rows['lang']; ?><br>
                                                                                                    <b>Diet :</b> <?php echo $rows['diet']; ?><br>
                                                                                                    <b>Height :</b> <?php echo $rows['height']; ?><br>
                                                                                                    <b>Religion :</b> <?php echo $rows['religion']; ?><br>
                                                                                                    <b>Sub-Community :</b> <?php echo $rows['sub-com']; ?><br>
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <b>Highest Education :</b> <?php echo $rows['HighEdu']; ?><br>
                                                                                                    <b>Collage :</b> <?php echo $rows['collage']; ?><br>
                                                                                                    <b>Profession :</b> <?php echo $rows['prof']; ?><br>
                                                                                                    <b>Specialization :</b> <?php echo $rows['specialization']; ?><br>
                                                                                                    <b>Age :</b> <?php echo $rows['bDate']; ?><br>
                                                                                                    <b>Blood Group :</b> <?php echo $rows['bGrp']; ?><br>
                                                                                                    <b>Birth Time :</b> <?php echo $rows['bTime']; ?><br>
                                                                                                    <b>Income :</b> <?php echo $rows['income']; ?> <br>
                                                                                                    <?php
                                                                                                    $res11 = mysqli_query($conn, "SELECT * FROM `table_plan` ");
                                                                                                    if ($res11) {
                                                                                                      ?>
                                                                                                            <b class="bold_title">Membership Plan :</b> <?php echo $rows['type_plan']; ?>
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

                                                                    <div class="modal fade" id="delete_confirm<?php echo $rows['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <form action="" method="post">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        Do You Really Want to Delete this Request?
                                                                                        <input name="delete_id" type="hidden" class="form-control" id="delete_id" value="<?php echo $rows['id']; ?>">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                        <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal fade" id="send_confirm<?php echo $rows['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <form action="" method="post">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="example">Confirm To send?</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        Do You Really Want to send this Request to <?php echo $rows['name']; ?> ?
                                                                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $rows['id']; ?>">
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
                                                                </div>
                                                                <!-- ------------------------------------------------- -->
                                                                <!-- ------------------------------------------------- -->


                                                    <?php }
                                                }
                                        } else { ?>
                                             <div class="text-center">   You have not visited anyone yet</div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <!-- Content Row -->
                                    <!-- --------------------requests profile-------------------- -->
                                </div>
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->
                    <?php
                    include 'panelFooter.php';
                    ?>
                </div>
                <!-- End of Content Wrapper -->
            </div>
            <!-- End of Page Wrapper -->
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <input type='hidden' id='current_user_name' value='<?php echo $current_user_name; ?>'>
            <input type='hidden' id='current_user_email' value='<?php echo $current_user_email; ?>'>
            <input type="hidden" id="current_user_id" value="<?php echo $current_user_id; ?>">
            <!-- Bootstrap core JavaScript-->
            <script src="./admin/vendor/jquery/jquery.min.js"></script>
            <script src="./admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="./admin/vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="./admin/js/sb-admin-2.min.js"></script>
            <!-- Page level plugins -->
            <!-- <script src="./admin/vendor/chart.js/Chart.min.js"></script> -->
            <!-- Page level custom scripts -->
            <!-- <script src="./admin/js/demo/chart-area-demo.js"></script> -->
            <!-- <script src="./admin/js/demo/chart-pie-demo.js"></script> -->
        </body>

        </html>
    <?php
} else {
  header("location:login-page.php");
}
?>
<script>
    $(document).on("click", '#view_profile', function(e) {
        var key = $(this).attr("data-bs-target");

        var user_id = (key.match(/\d+$/) || []).pop();
        var current_user_email = $('#current_user_email').val();
        var current_user_name = $('#current_user_name').val();
        var current_user_id = $("#current_user_id").val();
        console.log("user_id ---" + user_id);
        console.log("current_user_name ---" + current_user_name);
        console.log("current_user_email ---" + current_user_email);
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
                        text: "There is a problem ",
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