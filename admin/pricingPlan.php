<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
session_start();
include('admin_header.php');
if (isset($_SESSION['admin_id'])) {
  // insert query
  if (isset($_POST['create_plan'])) {
    $label = $_POST['plan_label'];
    $plan_heading = $_POST['plan_heading'];
    $price = implode(",", $_POST['price']);
    $months = implode(",", $_POST['months']);
    $plan_disc = $_POST['plan_disc'];
    $rule1 = $_POST['rule1'];
    $rule2 = $_POST['rule2'];
    $rule3 = $_POST['rule3'];
    $rule4 = $_POST['rule4'];
    $visiblePro = $_POST['visiblePro'];
    $success = 0;
    if (
      !empty($plan_heading) && !empty($price) && !empty($months)
      && !empty($rule1) && !empty($rule2) && !empty($rule3)
      && !empty($rule4) && !empty($visiblePro)
    ) :
      $sql = "INSERT INTO `create_plans`(  `label`,`heading`, `price`, `months`, `discription`, `rule1`, `rule2`, `rule3`, `rule4`, `visiblePro`) VALUES ('$label','$plan_heading','$price','$months','$plan_disc','$rule1','$rule2','$rule3','$rule4','$visiblePro')";
      $res = $db->query($sql);
      $success = $res['success'];
?>
      <?php if ($success) : ?>
        <?php header("location:pricingPlan.php"); ?>
        <script>
          setTimeout(function() {
            swal({
              title: "Great...",
              text: "From submitted successfully",
              icon: "success",
              buttons: true,
              dangerMode: true,
            })
            window.location.href = pricingPlan.php;
          }, 100);
        </script>
      <?php else : ?>
        <script>
          setTimeout(function() {
            swal({
              title: "Oops...",
              text: "Could not submit",
              icon: "error",
              buttons: true,
              dangerMode: true,
            })
            window.location.href = pricingPlan.php;
          }, 100);
        </script>
      <?php endif; ?>
    <?php else : ?>
      <script>
        setTimeout(function() {
          swal({
            title: "Oops...",
            text: "Enter required fields",
            icon: "error",
            buttons: true,
            dangerMode: true,
          })
          window.location.href = pricingPlan.php;
        }, 100);
      </script>
    <?php endif; ?>
  <?php } ?>

  <?php
  //  update query
  if (isset($_POST['update_plan'])) :
    $label = $_POST['plan_label'];
    $plan_heading = $_POST['plan_heading'];
    $price = implode(",", $_POST['price1']);
    $months = implode(",", $_POST['months1']);
    $plan_disc = $_POST['plan_disc'];
    $rule1 = $_POST['rule1'];
    $rule2 = $_POST['rule2'];
    $rule3 = $_POST['rule3'];
    $rule4 = $_POST['rule4'];
    $visiblePro = $_POST['visiblePro'];
    $editID = $_POST['edit_id'];
    if (
      !empty($plan_heading) && !empty($price) && !empty($months)
      && !empty($rule1) && !empty($rule2) && !empty($rule3)
      && !empty($rule4) && !empty($visiblePro)
    ) :
    endif;
  // $sql_edit = "UPDATE `create_plans` SET `label`='$label', `heading`='$plan_heading',`price`='$price',`months`='$months',`discription`='$plan_disc',`rule1`='$rule1',`rule2`='$rule2',`rule3`='$rule3',`rule4`='$rule4',`visiblePro`='$visiblePro' WHERE `id`='$editID' ";
  endif;
  //  delete query
  if (isset($_POST['delete_btn'])) {
    $dltID = $_POST['delete_id'];
    $sql_dlt = "DELETE FROM `create_plans` WHERE `id`='$dltID'";
    $remove = $db->query_delete($sql_dlt);
    if ($remove['success']) {
      ?>
      <script>
        setTimeout(function() {
          swal({
            title: "Great...",
            text: "Deleted successfully",
            icon: "success",
            buttons: true,
            dangerMode: true,
          })
          window.location.href = pricingPlan.php;
        }, 100);
      </script>
    <?php
    } else {
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
          window.location.href = pricingPlan.php;
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
                <h6 class="m-0 font-weight-bold text-primary text-center">Pricing plan</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="mb-3" style="text-align:right;">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planModal" data-bs-whatever="@create"><i class="fa fa-plus"></i> plan</button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-success">
                      <tr>
                        <th>Label</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Time Period</th>
                        <th>Discription</th>
                        <th>Feature 1</th>
                        <th>Feature 2</th>
                        <th>Feature 3</th>
                        <th>Feature 4</th>
                        <th>Visible Profiles</th>
                        <th class="">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql_plan = "SELECT * FROM `create_plans`";
                      $result = $db->query($sql_plan);
                      $result_rows = $result["rows"];
                      foreach ($result_rows as $row) {
                      ?>
                        <tr>
                          <td><?php echo $row['label']; ?></td>
                          <td><?php echo $row['heading']; ?></td>
                          <td><?php echo $row['price']; ?></td>
                          <td><?php echo $row['months']; ?></td>
                          <td><?php echo $row['discription']; ?></td>
                          <td><?php echo $row['rule1']; ?></td>
                          <td><?php echo $row['rule2']; ?></td>
                          <td><?php echo $row['rule3']; ?></td>
                          <td><?php echo $row['rule4']; ?></td>
                          <td><?php echo $row['visiblePro']; ?></td>
                          <td class="d-flex"><button type="button" name="update_plan" class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#update_plan<?php echo $row['id']; ?>" data-bs-whatever="@update"><i class="fa fa-edit"></i></button>
                            <button type="button" name="delete_plan" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_confirm<?php echo $row['id']; ?>" data-bs-whatever="@delet"><i class="fas fa-trash-alt"></i></button>
                          </td>
                        </tr>
                        <div class="modal fade" id="update_plan<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl">
                            <form method="POST" action="">
                              <!-- Modal update -->
                              <div class="modal-content">
                                <div class="modal-header card-header ">
                                  <h5 class="modal-title" id="exampleModalLabel">Update plan</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body " style="padding: 2rem;">
                                  <div class="row">
                                    <div class="mb-3 col-md-6">
                                      <label for="plan_label" class="col-form-label">Plan label :</label>
                                      <select name="plan_label" type="" class="form-control" id="plan_label" value="<?php echo $row['label']; ?>">
                                        <option value="<?php echo $row['label']; ?>"><?php echo $row['label']; ?></option>
                                        <!-- <option value="gold">gold</option>
                                        <option value="silver">silver</option>
                                        <option value="platinum">platinum</option> -->
                                        <option value="vip">vip</option>
                                        <option value="supreme">supreme</option>
                                        <option value="premium">premium</option>
                                        <!-- <option value="other">other</option> -->
                                      </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="plan_heading" class="col-form-label">Plan name <span class="required">*</span></label>
                                      <input name="plan_heading" type="text" class="form-control" id="plan_heading" value="<?php echo $row['heading']; ?>" placeholder="<?php echo $row['heading']; ?>">
                                    </div>


                                  </div>
                                  <div class="row ">
                                    <div class=" col-md-6 col-lg-6 col-12 mt-1">
                                      <label class="col-form-label">Price <span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-12 mt-1">
                                      <label class="col-form-label">Month(s) <span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-2 col-lg-2  col-12 mt-1 ">
                                    </div>
                                  </div>
                                  <?php
                                  $mon = explode(",", $row['months']);
                                  $prc = explode(",", $row['price']);
                                  $count = count($mon);
                                  echo "<input type='hidden' id='rowcount" . $row['id'] . "' value='$count' >";
                                  for ($i = 0; $i < $count; $i++) {
                                  ?>
                                    <div class="input_fields_wrap1">
                                      <div class="row ">
                                        <div class=" col-md-6 col-lg-6 col-12 mt-1">
                                          <input name="price1[]" class="form-control numeric" type="text" value="<?php echo $prc[$i];?>" placeholder="Price">
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12 mt-1">
                                          <input name="months1[]" class="form-control numeric" type="text" value="<?php echo $mon[$i];?>" placeholder="Months">
                                        </div>
                                        <div class="col-md-2 col-lg-2  col-12 mt-1 ">
                                          <button class="add_field_button1 move-btn btn-primary" onclick="editMon(<?php echo $row['id']; ?>)" type="button" style="border: 1px solid; width: 100%; height:35px">Add More</button>
                                        </div>
                                        <!-- <div class="col-md-2 col-lg-2  col-12 mt-1 ">
                                        <button class="col-md-2 col-lg-2 remove_field move-btn btn-primary mt-2" onclick="editMon()" style="border: 1px solid; width: 100%; height:35px">Remove</button>66
                                        </div> -->
                                      </div>
                                    </div>
                                    <div class="customer_records_dynamic1"></div>
                                  <?php
                                  }
                                  ?>
                                  <!-- </div> -->
                                  <div class="row">
                                    <div class="mb-3 col-md-6">
                                      <label for="discription" class="col-form-label">Discription </label>
                                      <textarea name="plan_disc" class="form-control" id="discription" placeholder="<?php echo $row['discription']; ?>"><?php echo $row['discription']; ?></textarea>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="rule1" class="col-form-label">Feature 1 <span class="required">*</span></label>
                                      <input name="rule1" type="text" class="form-control" id="rule1" value="<?php echo $row['rule1']; ?>" placeholder="<?php echo $row['rule1']; ?>">
                                    </div>

                                  </div>
                                  <div class="row">
                                    <div class="mb-3 col-md-6">
                                      <label for="rule2" class="col-form-label">Feature 2 <span class="required">*</span></label>
                                      <input name="rule2" type="text" class="form-control" id="rule2" value="<?php echo $row['rule2']; ?>" placeholder="<?php echo $row['rule2']; ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="rule3" class="col-form-label">Feature 3 <span class="required">*</span></label>
                                      <input name="rule3" type="text" class="form-control" id="rule3" value="<?php echo $row['rule3']; ?>" placeholder="<?php echo $row['rule3']; ?>">
                                    </div>

                                  </div>
                                  <div class="row">
                                    <div class="mb-3 col-md-6">
                                      <label for="rule4" class="col-form-label">Feature 4 <span class="required">*</span></label>
                                      <input name="rule4" type="text" class="form-control" id="rule4" value="<?php echo $row['rule4']; ?>" placeholder="<?php echo $row['rule4']; ?>">
                                      <input name="edit_id" type="hidden" class="form-control" id="edit_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="visiblePro" class="col-form-label">No of visible Profiles <span class="required">*</span></label>
                                      <input name="visiblePro" type="number" class="form-control" id="visiblePro" value="<?php echo $row['visiblePro']; ?>" placeholder="<?php echo $row['visiblePro']; ?>">
                                      <input name="edit_id" type="hidden" class="form-control" id="edit_id" value="<?php echo $row['id']; ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button name="update_plan" type="submit" class="btn btn-primary" id="updt_btn">Save</button>
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
                  <!-- <button class="btn btn-primary  coral-green p-2 flex-fill bd-highlight">Active</button> -->
                </div>
              </div>
              <!-- Modal create -->
              <div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <form method="POST" action="">
                    <div class="modal-content">
                      <div class="modal-header card-header">
                        <h5 class="modal-title" id="exampleModalLabel">New plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body row" style="padding: 2rem;">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="plan_label" class="col-form-label">Plan label </label>
                            <select name="plan_label" type="" class="form-control" id="plan_label">
                              <!-- <option value="gold">gold</option>
                              <option value="silver">silver</option>
                              <option value="platinum">platinum</option> -->
                              <option value="vip">vip</option>
                              <option value="supreme">supreme</option>
                              <option value="premium">premium</option>
                              <!-- <option value="other">other</option> -->
                            </select>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="plan_heading" class="col-form-label">
                              Plan name
                              <span class="required">*</span>
                            </label>
                            <input name="plan_heading" type="text" class="form-control" id="plan_heading">
                          </div>
                        </div>
                        <div class="row"> 
                          <div class="input_fields_wrap">
                            <div class="row ">
                              <div class=" col-md-6 col-lg-6 col-12 mt-1">
                                <label class="col-form-label">Price <span class="required">*</span></label>
                                <input name="price[]" class="form-control numeric" type="text" placeholder="Price">
                              </div>
                              <div class="col-md-4 col-lg-4 col-12 mt-1">
                                <label class="col-form-label">Month(s) <span class="required">*</span></label>
                                <input name="months[]" class="form-control numeric" type="text" value="" placeholder="Months">
                              </div>
                              <div class="col-md-2 col-lg-2  col-12 mt-1 ">
                                <label class="col-form-label">Add/Delete</label>
                                <button class=" add_field_button move-btn btn-primary" type="button" style="border: 1px solid; width: 100%; height:35px">Add More</button>
                              </div>
                            </div>
                          </div>
                          <div class="customer_records_dynamic"></div>
                        </div>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="discription" class="col-form-label">Discription </label>
                            <textarea name="plan_disc" class="form-control" id="discription"></textarea>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="rule1" class="col-form-label">Feature 1 <span class="required">*</span></label>
                            <input name="rule1" type="text" class="form-control" id="rule1">
                          </div>
                        </div>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="rule2" class="col-form-label">Feature 2 <span class="required">*</span></label>
                            <input name="rule2" type="text" class="form-control" id="rule2">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="rule3" class="col-form-label">Feature 3 <span class="required">*</span></label>
                            <input name="rule3" type="text" class="form-control" id="rule3">
                          </div>
                        </div>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="rule4" class="col-form-label">Feature 4 <span class="required">*</span></label>
                            <input name="rule4" type="text" class="form-control" id="rule4">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="visiblePro" class="col-form-label">NO. Of Visible Profiles <span class="required">*</span></label>
                            <input name="visiblePro" type="number" class="form-control" id="visiblePro">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button name="create_plan" type="submit" class="btn btn-primary">Save plan</button>
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
    </div>
    <div>
    <a class="scroll-to-top rounded pricingPlan-s-t-p"  href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    </div>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script>
      $(document).on("input", ".numeric", function() {
          this.value = this.value.replace(/\D/g, '');
      });
      $(document).ready(function() {


        var max_fields = 4; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID
        var x = 1;
        //initlal text box count
        $(add_button).click(function(e) { //on add input button click
          e.preventDefault();
          if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row mt-1 wrap"><div class=" col-md-6 col-lg-6 col-12 mt-2"> <input name="price[]" class="form-control" type="text" placeholder="Price" > </div> <div class="col-md-4 col-lg-4 col-12 mt-2"> <input name="months[]" class="form-control "  type="text" value="" placeholder="Months"> </div><button class="col-md-2 col-lg-2 remove_field move-btn btn-primary mt-2" style="border: 1px solid; width: 100%; height:35px">Remove</button></div>'); // add input boxes.
          }
        });

        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
          e.preventDefault();
          $(this).parent('div').remove();
          x--;
        })

      });
      var x = 1;
      // ------------------------------------------ 
      function editMon(id) {
        var mnth = $("#rowcount" + id).val();
        var cnt = 4 - parseInt(mnth);
        var max_fields = cnt; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap1"); //Fields wrapper
        var add_button = $(".add_field_button1"); //Add button ID
        // alert(mnth);
        // if(mnth < 4){
        // $(add_button).click(function(e) { //on add input button click
        // e.preventDefault();
        if (x <= max_fields) { //max input box allowed
          x++; //text box increment
          $(wrapper).append('<div class="row mt-1 wrap"><div class=" col-md-6 col-lg-6 col-12 mt-2"> <input name="price1[]" class="form-control" type="text" placeholder="Price" > </div> <div class="col-md-4 col-lg-4 col-12 mt-2"> <input name="months1[]" class="form-control "  type="text" value="" placeholder="Months"> </div><button class="col-md-2 col-lg-2 remove_field1 move-btn btn-primary mt-2" style="border: 1px solid; width: 100%; height:35px">Remove</button></div>'); // add input boxes.
        }
        // });

        $(wrapper).on("click", ".remove_field1", function(e) { //user click on remove text
          e.preventDefault();
          if (4 > cnt) {
            $(this).parent('div').remove();
            x--;
          }
        })
      }
      // }
    </script>

  </body>

  </html>
<?php
} else {
  header("location:index.php");
}
?>