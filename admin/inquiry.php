<?php 
session_start();
 
if (isset($_SESSION['admin_id'])) {
  include('admin_header.php');
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
                <h6 class="m-0 font-weight-bold text-primary text-center">Inquiry</h6>
              </div>
              <div class="card-body">
                <div class="row">            
               
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-success">
                      <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Message</th>                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                     $res = $db->query("SELECT * FROM `inquiry`");
                     $res_rows = $res['rows'];
                      foreach ($res_rows as $row) {
                      ?>
                        <tr>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php echo $row['email']; ?></td>
                          <td><?php echo $row['phone']; ?></td>
                          <td><?php echo $row['message']; ?></td>                    
                        </tr>               
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>
              </div>     
              <!--end Modal create -->
            </div>
          </div>
        </div>
        </div>
        <?php
        include 'panelFooter.php';
        ?>
   
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
   
<?php  } else {
  header("location:index.php");
} 

include 'admin_footer.php';
?>