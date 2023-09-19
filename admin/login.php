<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
// echo  '/../include/load.php';
require_once 'load.php';
connect_db();
global $db;
session_start();
if (isset($_POST['admin_Login'])) :
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql_ad = "SELECT id, name FROM `admin` WHERE  `email`='$username' AND `password`='$password' OR `mobile`='$username'  AND `password`='$password'";
    $result = $db->query($sql_ad);
    $rowCount =  $result['count'];
    $rows =  $result['rows'];

    if ($rowCount > 0) :
        $_SESSION['admin_id'] = $rows[0]['id'];
        $_SESSION['admin_name'] = $rows[0]['name'];
        header("location:adminDashboard.php");
    else :
?>
        <script>
            setTimeout(function() {
                swal({
                    title: "Oops...",
                    text: "Admin is not registered",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
            }, 200);
            setTimeout(function() {
                window.location.href = "admin_register.php";
            }, 3000);
        </script>
    <?php endif; ?>
<?php
else :
    echo "One of you input is incorrect";
    header("location:index.php");
endif;
?>