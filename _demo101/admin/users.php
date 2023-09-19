<?php

session_start();
include('admin_header.php');
if (isset($_SESSION['admin_id'])) {

  if (isset($_POST['user_status2'])) {
    $id = $_POST['status_id'];
    $sql = "UPDATE `user_regiter` SET `status`='0' WHERE `id`= '$id' ";
    $db->query_update($sql);
  }
  if (isset($_POST['user_status1'])) {
    $id = $_POST['status_id'];
    $sql = "UPDATE `user_regiter` SET `status`='1' WHERE `id`= '$id' ";
    $db->query_update($sql);
  }
  //  delete query
  if (isset($_POST['delete_btn'])) {
    $dltID = $_POST['delete_id'];
    $sql_dlt = "DELETE FROM `user_regiter` WHERE `id`='$dltID'";

    $remove = $db->query_update($sql_dlt);
    $removesuccess = $remove['success'];

    if ($removesuccess) {
      ?>
            <script>
              setTimeout(function() {
                swal({
                  title: "Success...",
                  text: "Deleted Successfully",
                  icon: "Success",
                  buttons: true,
                  dangerMode: true,
                })
              }, 100);
            </script>
          <?php
    } else {
      ?>
            <script>
              setTimeout(function() {
                swal({
                  title: "Oops...",
                  text: "Could not Delete",
                  icon: "error",
                  buttons: true,
                  dangerMode: true,
                })
              }, 100);
            </script>
        <?php
    }
  }
  ?>

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
            <div class="row ">
              <!-- Profil card -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-center">Users</h6>
                </div>
                <div id="admin" class="card-body">

                  <nav>
                    <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
                      <li class="nav-item userTab" role="presentation">
                        <button class="nav-link coral-green active" id="pills-allUser-tab" data-bs-toggle="pill" data-bs-target="#pills-allUser" type="button" role="tab" aria-controls="pills-allUser" aria-selected="true">All Users</button>
                      </li>
                      <li class="nav-item userTab " role="presentation">
                        <button class="nav-link coral-green" id="pills-active-tab" data-bs-toggle="pill" data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active" aria-selected="false">Active Users</button>
                      </li>
                      <li class="nav-item userTab" role="presentation">
                        <button class="nav-link coral-green" id="pills-deactive-tab" data-bs-toggle="pill" data-bs-target="#pills-deactive" type="button" role="tab" aria-controls="pills-deactive" aria-selected="false">Deactive Users</button>
                      </li>
                      <li class="nav-item userTab " role="presentation">
                        <button class="nav-link coral-green" id="pills-female-tab" data-bs-toggle="pill" data-bs-target="#pills-female" type="button" role="tab" aria-controls="pills-female" aria-selected="false">Female Users</button>
                      </li>
                      <li class="nav-item userTab" role="presentation">
                        <button class="nav-link coral-green" id="pills-male-tab" data-bs-toggle="pill" data-bs-target="#pills-male" type="button" role="tab" aria-controls="pills-Male" aria-selected="false">Male Users</button>
                      </li>

                    </ul>
                    <div class="tab-content bg-light" id="pills-tabContent">
                      <!-- -------------all users tab--------------- -->
                      <div class="tab-pane fade show active" id="pills-allUser" role="tabpanel" aria-labelledby="pills-allUser-tab">
                        <div>
                          <?php
                          $sql = "SELECT * FROM `user_regiter` ";
                          ?>
                          <div class="row ">
                            <!-- Profil card -->
                            <div class="card shadow mb-4">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-success">
                                      <tr>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Mobile</th>
                                        <th>Specification</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Marital Status</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql_plan = "SELECT * FROM `user_regiter`";
                                      $result = $db->query($sql_plan);
                                      $result_rows = $result['rows'];
                                      // print_r($result);die;
                                      foreach ($result_rows as $row) {
                                        ?>
                                          <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['specialization']; ?></td>
                                            <td><?php echo $row['gender']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo $row['marStat']; ?></td>
                                            <td class="d-flex">
                                              <?php
                                              if ($row['status'] == 1) {
                                                echo '<form action="" method="post">';
                                                echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                                echo '<button type="submit" name="user_status2" class="btn btn-success mr-3" data-bs-target="#status1' . $row['id'] . '" data-bs-whatever="@status1"><i class="fas fa-check-circle active_btn"></i></button>';
                                                echo '</form>';
                                              } else {
                                                echo '<form action="" method="post">';
                                                echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                                echo '<button type="submit" name="user_status1" class="btn btn-danger mr-3" data-bs-target="#status2' . $row['id'] . '" data-bs-whatever="@status2"><i class="fas fa-exclamation-circle deactive_btn"></i></button>';
                                                echo '</form>';
                                              }
                                              ?>
                                              <button type="button" name="view_user" class="btn btn-warning mr-3" data-bs-toggle="modal" data-bs-target="#view_user<?php echo $row['id']; ?>" data-bs-whatever="@view"><i class="fas fa-eye"></i></button>
                                              <button type="button" name="delete_user" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delet_user_modal<?php echo $row['id']; ?>" data-bs-whatever="@delet"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                          </tr>
                                          <!-- ---------view users ----------- -->

                                          <div class="modal fade" id="view_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                                                      <div class="card-body col-md-12">
                                                        <div class="row" style="line-height: 2;">
                                                          <div class="col-md-4">
                                                            <div class="text-center">
                                                              <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="../user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                            </div>
                                                          </div>
                                                          <div class="col-md-8">
                                                            <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                                            <b>Name :</b> <?php echo $row['name']; ?><br>
                                                            <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                                            <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                              <?php
                                                            }
                                                            $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php }
                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              // echo $row['city'];
                                                              ?>
                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php } ?>
                                                            <b>Address :</b> <?php echo $row['address']; ?><br>
                                                            <b>Marital Status :</b> <?php echo $row['marStat']; ?><br>
                                                            <b>Mother Tongue :</b> <?php echo $row['lang']; ?><br>
                                                            <b>Diet :</b> <?php echo $row['diet']; ?><br>
                                                            <b>Height :</b> <?php echo $row['height']; ?><br>
                                                            <b>Religion :</b> <?php echo $row['religion']; ?><br>
                                                            <div id="accordion_sm">
                                                              <div class="">
                                                                <div class="" id="headingOne">
                                                                  <h6 class="mb-0">
                                                                    <button class="btn btn-link collapsed" id="showMore" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Show More
                                                                    </button>
                                                                  </h6>
                                                                </div>
                                                                <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion_sm">
                                                                  <div class="">
                                                                    <div class="mt-0 ">
                                                                      <b class="bold_title">Sub-Community :</b> <?php echo $row['sub-com']; ?><br>
                                                                      <b class="bold_title">Highest Education :</b> <?php echo $row['HighEdu']; ?><br>
                                                                      <b class="bold_title">Collage :</b> <?php echo $row['collage']; ?><br>
                                                                      <b class="bold_title">Profession :</b> <?php echo $row['prof']; ?><br>
                                                                      <b class="bold_title">Specialization :</b> <?php echo $row['specialization']; ?><br>
                                                                      <b class="bold_title">Birth Date :</b> <?php echo $row['bDate']; ?><br>
                                                                      <b class="bold_title">Age :</b> <?php echo $row['age']; ?><br>
                                                                      <b class="bold_title">Blood Group :</b> <?php echo $row['bGrp']; ?><br>
                                                                      <b class="bold_title">Birth Time :</b> <?php echo $row['bTime']; ?><br>
                                                                      <b class="bold_title">Income :</b> <?php echo $row['income']; ?><br>
                                                                      <?php
                                                                      $user_id = $row['id'];
                                                                      $sql1 = "SELECT * FROM `table_plan` WHERE `user_id`= '$user_id'";
                                                                      $resultid = $db->query($sql1);
                                                                      $resultid_rows = $resultid['rows'];
                                                                      $resultid_success = $resultid['success'];

                                                                      if ($resultid_success) {
                                                                        ?>
                                                                          <b class="bold_title">Membership Plan :</b> <?php echo $row['type_plan']; ?>
                                                                        <?php
                                                                      } else {
                                                                        echo "<h6>Failed to Load Membership data</h6>";
                                                                      }
                                                                      ?>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <!-- </ul> -->
                                                            </div>
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
                                          <!------------ Modal delete ------------------>
                                          <div class="modal fade" id="delet_user_modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="dltUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="example">Confirm To Delete User?</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                  <div class="modal-body">
                                                    Do You Really Want to Delete this User?
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
                                          <!--end Modal delete -->
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <!-- <button class="btn btn-primary  coral-green p-2 flex-fill bd-highlight">Active</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- -------------end of all users tab--------------- -->
                      <!-- -------------active users tab--------------- -->
                      <div class="tab-pane fade" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab">
                        <div>
                          <?php
                          $sql = "SELECT * FROM `user_regiter` WHERE `status` = '1'";
                          ?>
                          <div class="row ">
                            <!-- Profil card -->
                            <div class="card shadow mb-4">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-success">
                                      <tr>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Mobile</th>
                                        <th>Specification</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Marital Status</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql_plan = "SELECT * FROM `user_regiter` WHERE `status` = '1'";
                                      $result = $db->query($sql_plan);
                                      $result_rows = $result['rows'];
                                      foreach ($result_rows as $row) {
                                        ?>
                                          <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['specialization']; ?></td>
                                            <td><?php echo $row['gender']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo $row['marStat']; ?></td>
                                            <td class="d-flex"><?php if ($row['status'] == 1) {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status2" class="btn btn-success mr-3" data-bs-target="#status1' . $row['id'] . '" data-bs-whatever="@status1"><i class="fas fa-check-circle active_btn"></i></button>';
                                              echo '</form>';
                                            } else {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status1" class="btn btn-danger mr-3" data-bs-target="#status2' . $row['id'] . '" data-bs-whatever="@status2"><i class="fas fa-exclamation-circle deactive_btn"></i></button>';
                                              echo '</form>';
                                            } ?>
                                              <button type="button" name="view_user" class="btn btn-warning mr-3" data-bs-toggle="modal" data-bs-target="#view_active_user<?php echo $row['id']; ?>" data-bs-whatever="@view"><i class="fas fa-eye"></i></button>
                                              <button type="button" name="delete_user" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delet_actuser_modal<?php echo $row['id']; ?>" data-bs-whatever="@delet"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                          </tr>
                                          <!-- ---------view users ----------- -->
                                          <div class="modal fade" id="view_active_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                                                              <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="../user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                            </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                            <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                                            <b>Name :</b> <?php echo $row['name']; ?><br>
                                                            <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                                            <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                              <?php
                                                            }
                                                            $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php }
                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php } ?>
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
                                                            $sql = "SELECT * FROM `table_plan` ";
                                                            $resultid = $db->query($sql);
                                                            $resultid_rows = $resultid['rows'];
                                                            $resultid_success1 = $resultid['success'];
                                                            if ($resultid_success1) {
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
                                          <!------------ Modal delete ------------------>
                                          <div class="modal fade" id="delet_actuser_modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="dltUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="example">Confirm To Delete User?</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                  <div class="modal-body">
                                                    Do You Really Want to Delete this User?
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
                                          <!--end Modal delete -->
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <!-- <button class="btn btn-primary  coral-green p-2 flex-fill bd-highlight">Active</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- -------------end of active users tab--------------- -->
                      <!-- -------------deactive users tab--------------- -->
                      <div class="tab-pane fade" id="pills-deactive" role="tabpanel" aria-labelledby="pills-deactive-tab">
                        <div>
                          <?php
                          $sql = "SELECT * FROM `user_regiter` WHERE `status` = '0'";
                          ?>
                          <div class="row ">
                            <!-- Profil card -->
                            <div class="card shadow mb-4">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-success">
                                      <tr>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Mobile</th>
                                        <th>Specification</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Marital Status</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql_plan = "SELECT * FROM `user_regiter` WHERE `status` = '0'";
                                      $result = $db->query($sql_plan);
                                      $result_rows = $result['rows'];
                                      foreach ($result_rows as $row) {
                                        ?>
                                          <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['specialization']; ?></td>
                                            <td><?php echo $row['gender']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo $row['marStat']; ?></td>
                                            <td class="d-flex"><?php if ($row['status'] == 1) {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status2" class="btn btn-success mr-3" data-bs-target="#status1' . $row['id'] . '" data-bs-whatever="@status1"><i class="fas fa-check-circle active_btn"></i></button>';
                                              echo '</form>';
                                            } else {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status1" class="btn btn-danger mr-3" data-bs-target="#status2' . $row['id'] . '" data-bs-whatever="@status2"><i class="fas fa-exclamation-circle deactive_btn"></i></button>';
                                              echo '</form>';
                                            } ?>
                                              <button type="button" name="view_user" class="btn btn-warning mr-3" data-bs-toggle="modal" data-bs-target="#view_deactive_user<?php echo $row['id']; ?>" data-bs-whatever="@view"><i class="fas fa-eye"></i></button>
                                              <button type="button" name="delete_user" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delet_dActuser_modal<?php echo $row['id']; ?>" data-bs-whatever="@delet"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                          </tr>
                                          <!-- ---------view users ----------- -->
                                          <div class="modal fade" id="view_deactive_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                                                              <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="../user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                            </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                            <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                                            <b>Name :</b> <?php echo $row['name']; ?><br>
                                                            <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                                            <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                              <?php
                                                            }
                                                            $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php }
                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              // echo $row['city'];
                                                              ?>
                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php } ?>
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
                                                            $resultid = $db->query($sql);
                                                            $resultid_rows = $resultid['rows'];
                                                            $resultid_success1 = $resultid['success'];
                                                            if ($resultid_success1) {
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
                                          <!------------ Modal delete ------------------>
                                          <div class="modal fade" id="delet_dActuser_modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="dltUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="example">Confirm To Delete User?</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                  <div class="modal-body">
                                                    Do You Really Want to Delete this User?
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
                                          <!--end Modal delete -->
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <!-- <button class="btn btn-primary  coral-green p-2 flex-fill bd-highlight">Active</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- -------------end of deactive users tab--------------- -->
                      <!-- -------------female users tab--------------- -->
                      <div class="tab-pane fade" id="pills-female" role="tabpanel" aria-labelledby="pills-female-tab">
                        <div>
                          <?php
                          $sql = "SELECT * FROM `user_regiter` WHERE `gender` = 'Female'";
                          ?>
                          <div class="row ">
                            <!-- Profil card -->
                            <div class="card shadow mb-4">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-success">
                                      <tr>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Mobile</th>
                                        <th>Specification</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Marital Status</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql_plan = "SELECT * FROM `user_regiter` WHERE `gender` = 'Female'";
                                      $result = $db->query($sql_plan);
                                      $result_rows = $result['rows'];
                                      foreach ($result_rows as $row) {
                                        ?>
                                          <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['specialization']; ?></td>
                                            <td><?php echo $row['gender']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo $row['marStat']; ?></td>
                                            <td class="d-flex"><?php if ($row['status'] == 1) {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status2" class="btn btn-success mr-3" data-bs-target="#status1' . $row['id'] . '" data-bs-whatever="@status1"><i class="fas fa-check-circle active_btn"></i></button>';
                                              echo '</form>';
                                            } else {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status1" class="btn btn-danger mr-3" data-bs-target="#status2' . $row['id'] . '" data-bs-whatever="@status2"><i class="fas fa-exclamation-circle deactive_btn"></i></button>';
                                              echo '</form>';
                                            } ?>
                                              <button type="button" name="view_user" class="btn btn-warning mr-3" data-bs-toggle="modal" data-bs-target="#view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view"><i class="fas fa-eye"></i></button>
                                              <button type="button" name="delete_user" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delet_fmluser_modal<?php echo $row['id']; ?>" data-bs-whatever="@delet"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                          </tr>
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
                                                              <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="../user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                            </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                            <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                                            <b>Name :</b> <?php echo $row['name']; ?><br>
                                                            <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                                            <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                              <?php
                                                            }
                                                            $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php }
                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              // echo $row['city'];
                                                              ?>
                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php } ?>
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
                                                            $sql = "SELECT * FROM `table_plan` ";
                                                            $resultid = $db->query($sql);
                                                            $resultid_rows = $resultid['rows'];
                                                            $resultid_success1 = $resultid['success'];
                                                            if ($resultid_success1) {
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
                                          <!------------ Modal delete ------------------>
                                          <div class="modal fade" id="delet_fmluser_modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="dltUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="example">Confirm To Delete User?</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                  <div class="modal-body">
                                                    Do You Really Want to Delete this User?
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
                                          <!--end Modal delete -->
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <!-- <button class="btn btn-primary  coral-green p-2 flex-fill bd-highlight">Active</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- -------------end of female users tab--------------- -->

                      <!-- -------------male users tab--------------- -->
                      <div class="tab-pane fade" id="pills-male" role="tabpanel" aria-labelledby="pills-male-tab">
                        <div>
                          <?php
                          $sql = "SELECT * FROM `user_regiter` WHERE `gender` = 'Male'";
                          ?>
                          <div class="row ">
                            <!-- Profil card -->
                            <div class="card shadow mb-4">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-success">
                                      <tr>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Mobile</th>
                                        <th>Specification</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Marital Status</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql_plan = "SELECT * FROM `user_regiter` WHERE `gender` = 'Male'";
                                      $result = $db->query($sql_plan);
                                      $result_rows = $result['rows'];
                                      foreach ($result_rows as $row) {
                                        ?>
                                          <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['specialization']; ?></td>
                                            <td><?php echo $row['gender']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo $row['marStat']; ?></td>
                                            <td class="d-flex"><?php if ($row['status'] == 1) {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status2" class="btn btn-success mr-3" data-bs-target="#status1' . $row['id'] . '" data-bs-whatever="@status1"><i class="fas fa-check-circle active_btn"></i></button>';
                                              echo '</form>';
                                            } else {
                                              echo '<form action="" method="post">';
                                              echo '<input type="hidden" name="status_id" value="' . $row['id'] . '">';
                                              echo '<button type="submit" name="user_status1" class="btn btn-danger mr-3" data-bs-target="#status2' . $row['id'] . '" data-bs-whatever="@status2"><i class="fas fa-exclamation-circle deactive_btn"></i></button>';
                                              echo '</form>';
                                            } ?>
                                              <button type="button" name="view_user" class="btn btn-warning mr-3" data-bs-toggle="modal" data-bs-target="#view_ml_user<?php echo $row['id']; ?>" data-bs-whatever="@view"><i class="fas fa-eye"></i></button>
                                              <button type="button" name="delete_user" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delet_maleuser_modal<?php echo $row['id']; ?>" data-bs-whatever="@delet"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                          </tr>
                                          <!-- ---------view users ----------- -->
                                          <div class="modal fade" id="view_ml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                                                              <img class="img-fluid px-3 px-sm-4 mt-5 mb-4" style="width: 16rem;border-radius: 11%;border: 1px solid #00aeaf;padding: 0 !important;" src="../user_image/<?php echo $row['filename']; ?>" alt="Upload Image">
                                                            </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                            <!-- <ul style="list-style-type: none" class="profile_list"> -->
                                                            <b>Name :</b> <?php echo $row['name']; ?><br>
                                                            <b>E-mail :</b> <?php echo $row['email']; ?><br>
                                                            <b>Phone Number :</b> <?php echo $row['phone']; ?><br>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `countries` where `id` = " . $row['country'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">Country :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                              <?php
                                                            }
                                                            $sql1 = "SELECT * FROM `states` where `id` = " . $row['state'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">State :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php }
                                                            $sql1 = "SELECT * FROM `cities` where `id` = " . $row['city'];
                                                            $resultid = $db->query($sql1);
                                                            $resultid_rows = $resultid['rows'];
                                                            foreach ($resultid_rows as $rowid) {
                                                              ?>
                                                                <b class="bold_title">City :</b> <?php echo strtoupper($rowid['name']); ?><br>
                                                            <?php } ?>
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
                                                            $sql = "SELECT * FROM `table_plan` ";
                                                            $resultid = $db->query($sql);
                                                            $resultid_rows = $resultid['rows'];
                                                            $resultid_success1 = $resultid['success'];
                                                            if ($resultid_success1) {
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
                                          <!------------ Modal delete ------------------>
                                          <div class="modal fade" id="delet_maleuser_modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="dltUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="example">Confirm To Delete User?</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                  <div class="modal-body">
                                                    Do You Really Want to Delete this User?
                                                    <input name="delete_id" type="text" class="form-control" id="delete_id" value="<?php echo $row['id']; ?>">
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button name="delete_btn" type="submit" class="btn btn-danger" id="dlt_btn">Confirm</button>
                                                  </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                          <!--end Modal delete -->
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <!-- <button class="btn btn-primary  coral-green p-2 flex-fill bd-highlight">Active</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- -------------end of male users tab--------------- -->


                    </div>
                  </nav>
                </div>
              </div>
            </div>

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

      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
          </div>
        </div>
      </div>
    <?php
  // include('admin_footer.php');

} else {
  header("location:index.php");
}
?>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>


  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script> <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
    $(document).ready(function() {
      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('type')) {
        var type = urlParams.get('type');
        if (type == 'active')
          $("#pills-active-tab").trigger("click");
        else if (type == 'deactive')
          $("#pills-deactive-tab").trigger("click");
        else if (type == 'female')
          $("#pills-female-tab").trigger("click");
        else if (type == 'male')
          $("#pills-male-tab").trigger("click");
      }



    });
  </script>