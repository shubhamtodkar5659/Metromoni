<?php
session_start();
include 'dbconn.php';

$InOutData = $_POST['InOutData'];
$sesn_id = $_SESSION['id'];
if ($InOutData == "InGetRejectedData") {
  $rid = 0;
  // echo $sesn_id;
  $requests = mysqli_query($conn, "SELECT * FROM `requests` WHERE `sent_id` = '$sesn_id' AND `status` = 0");
  while ($ro = mysqli_fetch_array($requests)) {
    // echo $ro['id'];
    $rid = $ro['id'];
    $otherid = $ro['user_id'];
    $liked = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `liked_p_id` = '$otherid' AND `user_id` = '$sesn_id' ");
    $count = mysqli_num_rows($liked); // echo $count;
    while ($r = mysqli_fetch_array($liked)) {
      $stat = $r['status'];
      if ($stat == 1 && $count > 0) {
        $currentDate = date("Y-m-d");
        $user_reg = mysqli_query($conn, " SELECT * FROM `user_regiter` WHERE `id` = '$otherid'  AND `status`= 1 ");
        while ($res = mysqli_fetch_array($user_reg)) {
          $expi = $res['plan_expiry_date'];
        }
        if ($expi > $currentDate) {
          $user_reg = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `id`  = '$otherid' AND `status` = 1");
          // $row = mysqli_fetch_array($user_reg);
          // return json_encode($row);
          while ($row = mysqli_fetch_array($user_reg)) {
            ?>
                                                <div class="col-md-3 col-lg-3 mt-4 surface ">
                                                    <div class="vendor-list-block mb30 shadow card ">
                                                        <!-- match list block -->
                                                        <div class=" vendor-img gradient-top" style="width: 100%;">
                                                            <!-- <a href="#"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                                            <a data-bs-toggle="modal" data-bs-target="#confirmsvn<?php echo $row['id']; ?>" class=" mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a>

                                                            <div class="<?php echo $row['label'] ?>"></div>
                                                            <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                                            <div class="category-badge"><a href="#" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                            <div class="price-lable"><?php echo $row['age']; ?></div>
                                                            <!-- <div class="favorite-action"> <a href="#" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                        </div>
                                                        <div class="card-body vendor-detail">
                                                            <!-- Match details -->
                                                            <div class="caption">
                                                                <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                echo $pieces[0]; ?></h2></a></h2>
                                                                <h4><a  class="relign"><?php echo $row['religion']; ?></a></h4>
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
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmsvn<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirmsvn<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_usersvn<?php echo $row['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3" name="view_user"><i class="fas fa-eye"></i></button>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.Match details -->
                                                    </div>
                                                    <!-- /.match list block -->
                                                    <div class="modal fade" id="delete_confirmsvn<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                    <div class="modal fade" id="confirmsvn<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="" method="post">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="example">Confirm To Accept ?</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Do You Really Want to Accept this Request from <?php echo $row['name']; ?>?
                                                                        <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                        <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                        <input name="r_id" type="hidden" class="form-control" id="r_id" value="<?php echo $rid; ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" name="rjct_btn" id="rjct_btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <button name="accpt_btn" type="submit" class="btn btn-danger" id="accpt_btn">Confirm</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="send_confirmsvn<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
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
                                                    <div class="modal fade" id="view_fml_usersvn<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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

                                                <?php
          }
        }
      } else {
        if ($stat != 1 || $count == 0) {
          $currentDate = date("Y-m-d");
          $usr_reg = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `id`= '$otherid' AND `status` = 1 ");
          while ($res = mysqli_fetch_array($usr_reg)) {
            $expi = $res['plan_expiry_date'];
          }
          if ($expi > $currentDate) { // echo $ro['user_id'] ;
            $usr_reg = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `id` ='$otherid' AND `status` = 1 ");
            // $row = mysqli_fetch_array($usr_reg);
            // return json_encode($row);
            while ($row = mysqli_fetch_array($usr_reg)) {
              ?>
                                                       <div class="col-md-3  col-lg-3 mt-4 surface ">
                                                            <div class="vendor-list-block mb30 shadow card ">
                                                                <!-- match list block -->
                                                                <div class=" vendor-img gradient-top" style="width: 100%;">
                                                                    <!-- <a href="#"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                                                    <a data-bs-toggle="modal" data-bs-target="#confirmet<?php echo $row['id']; ?>" class=" mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a>
                                                                    <div class="<?php echo $row['label'] ?>"></div>
                                                                    <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                                                    <div class="category-badge"><a href="#" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                    <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                    <!-- <div class="favorite-action"> <a href="#" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                </div>
                                                                <div class="card-body vendor-detail">
                                                                    <!-- Match details -->
                                                                    <div class="caption">
                                                                        <<h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                        echo $pieces[0]; ?></h2></a></h2>
                                                                        <h4><a  class="relign"><?php echo $row['religion']; ?></a></h4>
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
                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#send_confirmet<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#delete_confirmet<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#view_fml_useret<?php echo $row['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3" name="view_user"><i class="fas fa-eye"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.Match details -->
                                                            </div>
                                                            <!-- /.match list block -->
                                                            <div class="modal fade" id="delete_confirmet<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                            <div class="modal fade" id="send_confirmet<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
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
                                                            <div class="modal fade" id="confirmet<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form action="" method="post">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="example">Confirm To Accept ?</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Do You Really Want to Accept this Request from <?php echo $row['name']; ?>?
                                                                                <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                <input name="r_id" type="hidden" class="form-control" id="r_id" value="<?php echo $rid; ?>">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" name="rjct_btn" id="rjct_btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                <button name="accpt_btn" type="submit" class="btn btn-danger" id="accpt_btn">Confirm</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal fade" id="view_fml_useret<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                                                    <?php
            }
          }
        }
      }
    }
  }
} else if ($InOutData == "OutGetRejectedData") {
  $rid = 0;
  // echo $sesn_id;
  $requests = mysqli_query($conn, "SELECT * FROM `requests` WHERE `user_id` = '$sesn_id' AND `status` = 0");
  while ($ro = mysqli_fetch_array($requests)) {
    // echo $ro['id'];
    $rid = $ro['id'];
    $otherid = $ro['sent_id'];
    $liked = mysqli_query($conn, "SELECT * FROM `shortlist` WHERE `liked_p_id` = '$otherid' AND `user_id` = '$sesn_id' ");
    $count = mysqli_num_rows($liked); // echo $count;
    while ($r = mysqli_fetch_array($liked)) {
      $stat = $r['status'];
      if ($stat == 1 && $count > 0) {
        $currentDate = date("Y-m-d");
        $user_reg = mysqli_query($conn, " SELECT * FROM `user_regiter` WHERE `id` = '$otherid'  AND `status`= 1 ");
        while ($res = mysqli_fetch_array($user_reg)) {
          $expi = $res['plan_expiry_date'];
        }
        if ($expi > $currentDate) {
          $user_reg = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `id`  = '$otherid' AND `status` = 1");
          // $row = mysqli_fetch_array($user_reg);
          // return json_encode($row);
          while ($row = mysqli_fetch_array($user_reg)) {
            ?>
                                                    <div class="col-md-3  col-lg-3 mt-4 surface ">
                                                        <div class="vendor-list-block mb30 shadow card ">
                                                            <!-- match list block -->
                                                            <div class=" vendor-img gradient-top" style="width: 100%;">
                                                                <!-- <a href="#"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                                                <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>" class=" mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a>

                                                                <div class="<?php echo $row['label'] ?>"></div>
                                                                <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like' style='color:red'></i></button> "; ?></div>
                                                                <div class="category-badge"><a href="#" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                <!-- <div class="favorite-action"> <a href="#" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                            </div>
                                                            <div class="card-body vendor-detail">
                                                                <!-- Match details -->
                                                                <div class="caption">
                                                                    <h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                    echo $pieces[0]; ?></h2></a></h2>
                                                                    <h4><a  class="relign"><?php echo $row['religion']; ?></a></h4>
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
                                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#7send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#7delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#7view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3" name="view_user"><i class="fas fa-eye"></i></button>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.Match details -->
                                                        </div>
                                                        <!-- /.match list block -->
                                                        <div class="modal fade" id="7delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                        <div class="modal fade" id="7confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form action="" method="post">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="example">Confirm To Accept ?</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Do You Really Want to Accept this Request from <?php echo $row['name']; ?>?
                                                                            <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                            <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                            <input name="r_id" type="hidden" class="form-control" id="r_id" value="<?php echo $rid; ?>">
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" name="rjct_btn" id="rjct_btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button name="accpt_btn" type="submit" class="btn btn-danger" id="accpt_btn">Confirm</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="7send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
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
                                                        <div class="modal fade" id="7view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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

                                                <?php
          }
        }
      } else {
        if ($stat != 1 || $count == 0) {
          $currentDate = date("Y-m-d");
          $usr_reg = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `id`= '$otherid' AND `status` = 1 ");
          while ($res = mysqli_fetch_array($usr_reg)) {
            $expi = $res['plan_expiry_date'];
          }
          if ($expi > $currentDate) { // echo $ro['user_id'] ;
            $usr_reg = mysqli_query($conn, "SELECT * FROM `user_regiter` WHERE `id` ='$otherid' AND `status` = 1 ");
            // $row = mysqli_fetch_array($usr_reg);
            // return json_encode($row);
            while ($row = mysqli_fetch_array($usr_reg)) {
              ?>
                                                            <div class="col-md-3  col-lg-3 mt-4 surface ">
                                                                <div class="vendor-list-block mb30 shadow card ">
                                                                    <!-- match list block -->
                                                                    <div class=" vendor-img gradient-top" style="width: 100%;">
                                                                        <!-- <a href="#"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a> -->
                                                                        <a data-bs-toggle="modal" data-bs-target="#confirm<?php echo $row['id']; ?>" class=" mt-3" name="Req" id="Req"><img src="user_image/<?php echo $row['filename']; ?>" alt="wedding venue" class="match-img py-0"></a>
                                                                        <div class="<?php echo $row['label'] ?>"></div>
                                                                        <div class="favourite-bg"><?php echo "<button onclick='like(" . $row['id'] . ");' class='btn'><i class='fa fa-heart like'></i></button> "; ?></div>
                                                                        <div class="category-badge"><a href="#" class="category-link"><?php echo $row['specialization']; ?></a></div>
                                                                        <div class="price-lable"><?php echo $row['age']; ?></div>
                                                                        <!-- <div class="favorite-action"> <a href="#" class="fav-icon"><i class="fa fa-close"></i></a> </div> -->
                                                                    </div>
                                                                    <div class="card-body vendor-detail">
                                                                        <!-- Match details -->
                                                                        <div class="caption">
                                                                            <<h2 class="title"> <?php $pieces = explode(" ", $row['name']);
                                                                            echo $pieces[0]; ?></h2></a></h2>
                                                                            <h4><a  class="relign"><?php echo $row['religion']; ?></a></h4>
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
                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#8send_confirm<?php echo $row['id']; ?>" data-bs-whatever="@send" class="btn btn-sm btn-primary mt-3" name="senReq" id="senReq"> <i class="fa-solid fa-paper-plane"></i></button>
                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#8delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet" class="btn btn-sm btn-danger mt-3" name="delReq" id="delReq"> <i class="fas fa-trash-alt"></i></button>
                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#8view_fml_user<?php echo $row['id']; ?>" data-bs-whatever="@view" class="btn btn-sm col-3 btn-warning mt-3" name="view_user"><i class="fas fa-eye"></i></button>

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
                                                                <div class="modal fade" id="8send_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
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
                                                                <div class="modal fade" id="8confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <form action="" method="post">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="example">Confirm To Accept ?</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Do You Really Want to Accept this Request from <?php echo $row['name']; ?>?
                                                                                    <input name="send_id" type="hidden" class="form-control" id="send_id" value="<?php echo $row['id']; ?>">
                                                                                    <input name="usr_id" type="hidden" class="form-control" id="usr_id" value="<?php echo $sesn_id; ?>">
                                                                                    <input name="r_id" type="hidden" class="form-control" id="r_id" value="<?php echo $rid; ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" name="rjct_btn" id="rjct_btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                    <button name="accpt_btn" type="submit" class="btn btn-danger" id="accpt_btn">Confirm</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="8view_fml_user<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                            <?php
            }
          }
        }
      }
    }
  }
}