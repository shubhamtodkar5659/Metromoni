<?php
session_start();
include 'dbconn.php';
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>My Profile</title>
        <!-- Custom fonts for this template-->
        <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="./admin/css/styleAdmin.css" rel="stylesheet">
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
        <link rel="stylesheet" type="text/css" href="css/fontello.css">
        <!--font awesome icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <div class="container-fluid">
                    <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">Plan Purchase History</h6>
              </div>
              <div class="card-body"> 
                        <div class="row   mb-4 py-3">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>Plan Name</th>
                                        <th>Purchase Date</th>
                                        <th>Expiry Date</th>
                                        <th>Plan Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                            
                                    $result = mysqli_query($conn, "SELECT * FROM `table_plan` WHERE `user_id` = '$user_id'");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['type_plan']; ?></td>
                                            <td><?php echo $row['plan_purchase_date']; ?></td>
                                            <td><?php echo $row['plan_expiry_date']; ?></td>
                                            <td><?php echo $row['plan_price']; ?></td>                                      
                                        </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                </div>
            <?php
                include 'panelFooter.php';
                ?>
            </div>        </div>

    <!-- Bootstrap core JavaScript-->
    <script src="./admin/vendor/jquery/jquery.min.js"></script>
        <script src="./admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="./admin/vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="./admin/js/sb-admin-2.min.js"></script>
    </body>
    </html>
<?php
} else {
    header("location:login-page.php");
}
?>