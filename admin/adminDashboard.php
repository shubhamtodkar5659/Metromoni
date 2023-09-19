<?php
session_start();
require_once 'load.php';
connect_db();
global $db;
if (isset($_SESSION['admin_id'])):
  include('admin_header.php');
  ?>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <?php
      include 'panelHeader.php';
      ?>
      <!-- Content Wrapper -->
      <div id="content-wrapper"
           class="d-flex flex-column">
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
            <div id="admin"
                 class="card shadow mb-4">

              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">Dashboard</h6>
              </div>
              <div class="card-body">
                <div class="">
                  <div class="row admin_d_count">
                    <!-- Profil card -->
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $sql = "SELECT * FROM `user_regiter`";
                        $result = $db->query($sql);
                        $count = $result['count'];
                        $rows = $result['rows'];
                        ?>
                        <a href="users.php">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Total Users</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $count; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $date = Date("Y-m-d");
                        $user_created_today = "SELECT * FROM `user_regiter` WHERE `created_at` = '$date'";
                        $res = $db->query($user_created_today);
                        $cnt = $res['count'];
                        ?>
                        <div class="card-header text-white py-3">
                          <h6 class="m-0 font-weight-bold  text-lg text-center">Today's Registrations</h6>
                        </div>
                        <div class="card-body">
                          <div class="text-xlg text-center text-white">
                            <p>
                              <?php echo $cnt; ?>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Profil card -->
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $sql2 = "SELECT * FROM `user_regiter` WHERE `status` = 1 ";
                        $result2 = $db->query($sql2);
                        $count2 = $result2['count'];
                        ?>
                        <a href="users.php?type=active">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Active Users</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $count2; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <!-- Profil card -->
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $sql3 = "SELECT * FROM `user_regiter` WHERE `status` = 0";
                        $result3 = $db->query($sql3);
                        $count3 = $result3['count'];
                        ?>
                        <a href="users.php?type=deactive">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Deactive Users</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $count3; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $sql4 = "SELECT * FROM `user_regiter` WHERE `gender` = 'Female'";
                        $result4 = $db->query($sql4);
                        $count4 = $result4['count'];
                        ?>
                        <a href="users.php?type=female">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Female Users</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $count4; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $sql5 = "SELECT * FROM `user_regiter` WHERE `gender` = 'Male'";
                        $result5 = $db->query($sql5);
                        $count5 = $result5['count'];
                        ?>
                        <a href="users.php?type=male">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Male Users</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $count5; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php

                        $success_sql = "SELECT * FROM `success_story`";
                        $success_result = $db->query($success_sql);
                        $success_count = $success_result['count'];
                        ?>
                        <a href="AddSuccessStory.php">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Married Users</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $success_count; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $inquiry_sql = "SELECT * FROM `inquiry`";
                        $inquiry_result = $db->query($inquiry_sql);
                        $inquiry_count = $inquiry_result['count'];

                        ?>
                        <a href="inquiry.php">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Contacts</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $inquiry_count; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $free_plan_sql = "SELECT * FROM `user_regiter` WHERE `type_plan` = 'Free'";
                        $free_plan_result = $db->query($free_plan_sql);
                        $free_plan_count = $free_plan_result['count'];
                        ?>
                        <div class="card-header text-white py-3">
                          <h6 class="m-0 font-weight-bold  text-lg text-center">Free Members</h6>
                        </div>
                        <div class="card-body">
                          <div class="text-xlg text-center text-white">
                            <p>
                              <?php echo $free_plan_count; ?>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $other_plan_sql = "SELECT * FROM `user_regiter` WHERE `plan_price` != 'Free'";
                        $other_plan_result = $db->query($other_plan_sql);
                        $other_plan_count = $other_plan_result['count'];
                        ?>
                        <div class="card-header text-white py-3">
                          <h6 class="m-0 font-weight-bold  text-lg text-center">Paid Members</h6>
                        </div>
                        <div class="card-body">
                          <div class="text-xlg text-center text-white">
                            <p>
                              <?php echo $other_plan_count; ?>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class=" col-md-3 ">
                      <div class=" card shadow ">
                        <?php
                        $today = date("Y-m-d");
                        $plan_expiry_sql = "SELECT * FROM `user_regiter` WHERE `plan_expiry_date` <= '$today'";
                        $plan_expiry_result = $db->query($plan_expiry_sql);
                        $plan_expiry_count = $plan_expiry_result['count'];
                        ?>
                        <a href="expired.php">
                          <div class="card-header text-white py-3">
                            <h6 class="m-0 font-weight-bold  text-lg text-center">Expired Membership</h6>
                          </div>
                          <div class="card-body">
                            <div class="text-xlg text-center text-white">
                              <p>
                                <?php echo $plan_expiry_count; ?>
                              </p>
                              <!-- <h6>View in Detail</h6> -->
                            </div>
                          </div>
                        </a>
                      </div>
                      </div>

                      </div>
                    <!-- Content Row -->
                     </div>
                       <!-- /.container-flu
                      i d -->
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
                   <!-- Scro
                l   l 
                 t  o T
                  o p Button-->
                     <a class="scroll-to-top rounded"
                       href="#page-top">
                        <i class="fas fa-angle-up"></i>
                      </a>
                        <!-- Logout Modal-->
                      <div class="modal fade"
                       id="logoutModal"
                        tabuserDashboard="-1"
                      role="dialog"
                       aria-labelledby="exampleModalLabel"
                       aria-hidden="true">
                       <div class="modal-dialog"
                            role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title"
                           id="exampleModalLabel">Ready to Leave?</h5>
                           <button class="close"
                                  type="button"
                                   data-dismiss="modal"
                                 aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                             </div>
                               <div class="modal-body">Select "Logout" below if you are ready to end your current sessio
                            n.</div>
                             <div class="modal-footer">
                                <button class="btn btn-secondary"
                                      type="button"
                                        data-dismiss="modal">Cancel</button>
                <             a class="btn btn-primary"
                               href="logout.php">Logout</a>
                               </div>
                                 </div>
                                  </div>
                                </div>

                                 <?php
                                 include('admin_footer.php');
else:
  header("location:index.php");
endif;
?>