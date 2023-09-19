<?php
session_start();
include 'admin_header.php';
if (isset($_SESSION['admin_id'])) :
  // insert query
  if (isset($_POST['save_review'])) :
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $msg = $_POST['message'];
    $filename = $_FILES["cplImg"]["name"];
    $tempname = $_FILES["cplImg"]["tmp_name"];
    $folder = "couple_img/" . $filename;
    if (!empty($name) && !empty($date) && !empty($location) && !empty($msg)) :

      $sql_insert = $db->query("INSERT INTO `review`(`name`, `date`, `location`, `message`, `filename`) VALUES ('$name','$date','$location','$msg','$filename')");
      $sql_insert_success = $sql_insert['success']; //->query(  "INSERT INTO `review`(`name`, `date`, `location`, `message`, `filename`) VALUES ('$name','$date','$location','$msg','$filename')");
      if ($sql_insert_success) :
        // header("location:../real-wedding-listing.php");   
        if (move_uploaded_file($tempname, $folder)) :
?>
          <script>
            setTimeout(function() {
              swal({
                title: "Success...",
                text: "Image uploaded successfully",
                icon: "success",
                buttons: true,
                dangerMode: true,
              })
            }, 100);
          </script>
        <?php
        else :
        ?>
          <script>
            setTimeout(function() {
              swal({
                title: "Oops...",
                text: "Image not uploaded",
                icon: "error",
                buttons: true,
                dangerMode: true,
              })
            }, 100);
          </script>
        <?php endif; ?>
        <script>
          setTimeout(function() {
            swal({
              title: "success...",
              text: "form submitted successfully",
              icon: "success",
              buttons: true,
              dangerMode: true,
            })
          }, 100);
        </script>
      <?php
      else :
      ?>
        <script>
          setTimeout(function() {
            swal({
              title: "Oops...",
              text: "There was an error",
              icon: "error",
              buttons: true,
              dangerMode: true,
            })
          }, 100);
        </script>
      <?php endif; ?>
    <?php else : ?>
      <script>
        setTimeout(function() {
          swal({
            title: "Oops...",
            text: "All fields are required",
            icon: "error",
            buttons: true,
            dangerMode: true,
          })
        }, 100);
      </script>
      <?php
    endif;
  endif;
  //  update query
  if (isset($_POST['update_review'])) :
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $msg = $_POST['message'];
    $editID = $_POST['edit_id'];
    $filename1 = $_POST['cplImg1'];
    $filename = $_FILES['cplImg']['name'];
    $tempname = $_FILES['cplImg']['tmp_name'];
    $folder = "couple_img/" . $filename;
    // echo $_FILES["cplImg"]["name"];
    $editID = $_POST['edit_id'];
      
    // ---------------
    if (!empty($name) && !empty($date) && !empty($location) && !empty($msg)) :
      if (!empty($_FILES["cplImg"]["name"])) :
        $sql_edit = "UPDATE `review` SET `name`='$name',`date`='$date',`location`='$location',`message`='$msg',`filename`='$filename' WHERE `id`='$editID' ";;
        $update_q = $db->query_update($sql_edit);
        if (move_uploaded_file($tempname, $folder)) :
          ?>
          <script>
            setTimeout(function() {
              swal({
                title: "success...",
                text: "image uploaded successfully",
                icon: "success",
                buttons: true,
                dangerMode: true,
              })
            }, 100);
          </script>
        <?php else : ?>
          <script>
            setTimeout(function() {
              swal({
                title: "Oops...",
                text: "Image not uploaded",
                icon: "error",
                buttons: true,
                dangerMode: true,
              })
            }, 100);
          </script>
        <?php
        endif;
      else :
        $sql_edit = "UPDATE `review` SET `name`='$name',`date`='$date',`location`='$location',`message`='$msg' WHERE `id`='$editID' ";;
        $update_q = $db->query_update($sql_edit);
      endif;

      if ($update_q) :
        ?>
        <script>
          setTimeout(function() {
            swal({
              title: "success...",
              text: "Updated Successfully",
              icon: "success",
              buttons: true,
              dangerMode: true,
            })
          }, 100);
        </script>
      <?php else : ?>
        <script>
          setTimeout(function() {
            swal({
              title: "Oops...",
              text: "Could not update",
              icon: "error",
              buttons: true,
              dangerMode: true,
            })
          }, 100);
        </script>
    <?php endif; ?>


  <?php else : ?>
    <script>
      setTimeout(function() {
        swal({
          title: "Opps...",
          text: "Fill required fields",
          icon: "error",
          buttons: true,
          dangerMode: true,
        })
      }, 100);
    </script>
    <?php endif;?>
    <?php endif;?>
  <?php
  //  delete query
  if (isset($_POST['delete_btn'])) :
    $dltID = $_POST['delete_id'];
    $sql_dlt = "DELETE FROM `review` WHERE `id`='$dltID'";
    $remove = $db->query_delete($sql_dlt);
    $remove_success = $remove['success']; //->query_delete($conn, $sql_dlt);
    if ($remove_success) :
    ?>
      <script>
        setTimeout(function() {
          swal({
            title: "success...",
            text: "Deleted Successfully",
            icon: "success",
            buttons: true,
            dangerMode: true,
          })
        }, 100);
      </script>
    <?php
    else :
    ?>
      <script>
        setTimeout(function() {
          swal({
            title: "Oops...",
            text: "Could not delete",
            icon: "error",
            buttons: true,
            dangerMode: true,
          })
        }, 100);
      </script>
  <?php
    endif;
  endif;
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
                <h6 class="m-0 font-weight-bold text-primary text-center">Review's</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="mb-3" style="text-align:right;">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planModal" data-bs-whatever="@create"><i class="fa fa-plus"></i> Review</button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-success">
                      <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Message</th>
                        <th>Image</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql_plan = "SELECT * FROM `review`";
                      $result = $db->query($sql_plan);
                      $result_rows = $result['rows']; //$db->query($sql_plan);
                      foreach ($result_rows as $row) {
                      ?>
                        <tr>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php echo $row['date']; ?></td>
                          <td><?php echo $row['location']; ?></td>
                          <td><?php echo $row['message']; ?></td>
                          <td><img src="couple_img/<?php echo $row['filename']; ?>" alt="" width="100px" height="100px"></td>
                          <td class="d-flex"><button type="button" name="update_review" class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#update_review<?php echo $row['id']; ?>" data-bs-whatever="@update"><i class="fa fa-edit"></i></button>
                            <button type="button" name="delete_review" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet"><i class="fas fa-trash-alt"></i></button>
                          </td>
                        </tr>
                        <div class="modal fade" id="update_review<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl">
                            <form method="POST" action="" enctype="multipart/form-data">
                              <!-- Modal update -->
                              <div class="modal-content">
                                <div class="modal-header card-header ">
                                  <h5 class="modal-title" id="exampleModalLabel">Update reveiw</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body " style="padding: 2rem;">
                                  <div class="row">
                                    <div class="mb-3 col-md-6">
                                      <label for="name" class="col-form-label">Name :<span class="required">*</span></label>
                                      <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" placeholder="<?php echo $row['name']; ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="date" class="col-form-label">Date :<span class="required">*</span></label>
                                      <input name="date" type="text" class="form-control" id="date" value="<?php echo $row['date']; ?>" placeholder="<?php echo $row['date']; ?>">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="mb-3 col-md-6">
                                      <label for="location" class="col-form-label">Location :<span class="required">*</span></label>
                                      <input name="location" type="text" class="form-control" id="location" value="<?php echo $row['location']; ?>" placeholder="<?php echo $row['location']; ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="cplImg" class="col-form-label">Image:<span class="required">*</span></label>
                                      <input type="file" class="form-control" name="cplImg" id="cplImg" accept="image/png, image/gif, image/jpeg">
                                      <input type="hidden" class="form-control" name="cplImg1" id="cplImg1" value="<?php echo $row['filename']; ?>">
                                    </div>

                                  </div>
                                  <div class="row">
                                    <div class="mb-3 col-md-6">
                                      <label for="message" class="col-form-label ">Message :<span class="required">*</span></label>
                                      <textarea name="message" type="text" class="form-control" id="message" value="<?php echo $row['message']; ?>" placeholder="<?php echo $row['message']; ?>"><?php echo $row['message']; ?></textarea>
                                      <input name="edit_id" type="hidden" class="form-control" id="edit_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button name="update_review" type="submit" class="btn btn-primary" id="updt_review">Save</button>
                                  <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                              <!--end Modal update -->
                            </form>
                          </div>
                        </div>
                        <!-- Modal delet -->
                        <div class="modal fade" id="delete_confirm<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="example">Confirm To Delete?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="" method="post">
                                <div class="modal-body">
                                  Do You Really Want to Delete this Row?
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
                        <!--end Modal delet -->
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Modal create -->
              <div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header card-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body row" style="padding: 2rem;">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="name" class="col-form-label">Name :<span class="required">*</span></label>
                            <input name="name" type="text" class="form-control" id="name">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="date" class="col-form-label">Date :<span class="required">*</span></label>
                            <input name="date" type="text" class="form-control" id="date">
                          </div>
                        </div>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="location" class="col-form-label">Location :<span class="required">*</span></label>
                            <input name="location" type="text" class="form-control" id="location">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="message" class="col-form-label ">Message :<span class="required">*</span></label>
                            <textarea name="message" type="text" class="form-control" id="message"></textarea>
                          </div>
                        </div>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="cplImg" class="col-form-label ">Image :<span class="required">*</span></label>
                            <input type="file" class="form-control" name="cplImg" id="cplImg" accept="image/png, image/gif, image/jpeg">
                          </div>
                        </div>
                        <input name="edit_id" type="hidden" class="form-control" id="edit_id" value="<?php echo $row['id']; ?>">
                      </div>
                      <div class="modal-footer">
                        <button name="save_review" type="submit" class="btn btn-primary">Save review</button>
                        <button name="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!--end Modal create -->
            </div>
          </div>
        </div>
        <?php
        include 'panelFooter.php';
        ?>
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
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
else :
  header("location:index.php");
endif;
include 'admin_footer.php';
  ?>