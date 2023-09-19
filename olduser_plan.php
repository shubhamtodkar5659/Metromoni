<?php
session_start();
include 'dbconn.php';
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    if (isset($_POST['purchase'])) {
        $planId = $_POST['plan_id'];
        $planDuration = $_POST['months'];
        $planType = $_POST['plan_heading'];
        $label = $_POST['label'];
        $price = $_POST['plan_price'];
        $date = date('Y-m-d');
        $month = $planDuration;
        $days = $month * 30;
        $expiry = date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
        $sql = mysqli_query($conn, "UPDATE `user_regiter` SET `payment_status`='1',`plan_duration`='$planDuration',`type_plan`='$planType',`label`='$label',`plan_price`='$price',`type_plan_id`='$planId',`plan_purchase_date`= CURDATE(), `plan_expiry_date`='$expiry' WHERE `id` = '$user_id' ");
        if ($sql) {
            $sql2 = mysqli_query($conn, "INSERT INTO `table_plan`( `user_id`,`label`, `payment_status`, `plan_duration`, `type_plan`, `plan_price`, `type_plan_id`, `plan_purchase_date`, `plan_expiry_date`) VALUES ('$user_id','$label','1','$planDuration','$planType','$price','$planId',CURDATE(),'$expiry')");
        }
    }
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
                    <!-- End of Topbar -->
                    <!-- Begin Page Content -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-center">Membership Plan</h6>
                        </div>
                        <div class="card-body surface">
                            <!-- Page Heading -->
                            <div class="row pricing-container mb-4 py-1">
                                <?php
                                $selected_plan = "";
                                $selected_month = 0;
                                $selected_plan_price = 0;
                                $month = "";
                                $sql_plan = "SELECT * FROM `create_plans`";
                                $result = mysqli_query($conn, $sql_plan);
                                $trial = mysqli_query($conn, "SELECT * FROM `user_regiter` where `id` = '$_SESSION[id]'");
                                while ($rowid = mysqli_fetch_array($trial)) {
                                    $selected_plan = $rowid['type_plan_id'];
                                    $selected_month = $rowid['plan_duration'];
                                    $selected_plan_price = $rowid['plan_price'];
                                }
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $month = explode(",", $row['months']);
                                    $price = explode(",", $row['price']);
                                    $plan_price = 0;
                                    if ($row['id'] == $selected_plan) :
                                        $plan_price =  $selected_plan_price;
                                    else :
                                        $plan_price = $price[0];
                                    endif;

                                ?>


                                    <div class="col-lg-3  col-sm-4 pricing-box pricing-box-regualr card   ">
                                        <div class="shadow">
                                            <div class="card-header gradient-top pt-3 text-center">
                                                <h3 class="price-title"><?php echo $row['heading']; ?></h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <input type="hidden" id="showprice<?php echo $row['id']; ?>">
                                                <h2 class="price-plan">
                                                    <span class="dollor-sign">₹</span>
                                                    <span id="getprice<?php echo $row['id']; ?>">
                                                        <?php echo $plan_price; ?>
                                                    </span>
                                                </h2>
                                                <select class="select-form months" onchange="prcFrmMnth(this.value, <?php echo $row['id']; ?>)">
                                                    <?php
                                                    // for ($i = 0; $i < count($month); $i++) {
                                                    //     echo '<option value=' . $month[$i] . '>' . $month[$i] . '/ Mo</option>';
                                                    // }
                                                    for ($i = 0; $i < count($month); $i++) {
                                                        $selected_m = ' ';
                                                        if (($row['id'] == $selected_plan) && $selected_month == $month[$i]) {
                                                            $selected_m = 'selected';
                                                        }
                                                        echo '<option value =' . $month[$i] . '  ' . $selected_m . '>' . $month[$i] . '/ Mo</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <!-- <span class="permonth"><small><?php echo $row['months']; ?> /months</small></span> -->
                                                <p><?php echo $row['discription']; ?></p>
                                                <?php if ($row['id'] == $selected_plan) : ?>
                                                    <!-- <a data-toggle="modal" data-target="#deactivate<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-danger btn-sm">Active</a> -->
                                                    <a data-toggle="modal" data-target="#deactivate<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-danger btn-sm">Active</a>
                                                <?php else : ?>
                                                    <!-- <a data-toggle="modal" name="selectPlan" data-target="#myModal<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-warning btn-sm">Select Plan</a> -->
                                                    <a data-toggle="modal" data-target="#myModal<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-warning btn-sm">Select Plan</a>
                                                <?php endif; ?>
                                            </div>
                                            <ul class="check-circle list-group">
                                                <li class="list-group-item"><?php echo $row['rule1']; ?></li>
                                                <li class="list-group-item"><?php echo $row['rule2']; ?></li>
                                                <li class="list-group-item"><?php echo $row['rule3']; ?></li>
                                                <li class="list-group-item"><?php echo $row['rule4']; ?></li>
                                                <input name="plan_id" type="hidden" id="plan_id" value="<?php echo $row['id']; ?>">
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- --------modal form confirm----------------- -->
                                    <form action="" method="POST">
                                        <div class="modal fade" id="myModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Buy Plan</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <input name="plan_heading" type="hidden" id="plan_heading<?php echo $row['id']; ?>" value="<?php echo $row['heading']; ?>">
                                                    <!-- <input name="months" type="hidden" id="Plan_prd" value="<?php echo $row['months']; ?>"> -->
                                                    <input name="months" type="hidden" id="Plan_prd<?php echo $row['id']; ?>" value="">

                                                    <input name="plan_price" type="hidden" id="plan_price<?php echo $row['id']; ?>" value="">
                                                    <div class="modal-body">
                                                        Do you want to confirm the purchase?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" id="lbl<?php echo $row['id']; ?>" name="label" value="<?php echo $row['label']; ?>">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button name="purchase" id="purchase-btn" type="submit" rowid="<?php echo $row['id']; ?>" class="btn btn-primary buy_now">Confirm</button>
                                                        <input name="plan_id" type="hidden" id="get_plan_id<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                <?php  } ?>
                            </div>

                            <!-- </form> -->
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->
                    <?php
                    include 'panelFooter.php';
                    ?>
                </div>
                <!-- End of Content Wrapper -->
                <input type="hidden" id="current_user_id" value="<?php echo $user_id; ?>" />
            </div>
            <!-- End of Page Wrapper -->
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <script src="./admin/vendor/jquery/jquery.min.js"></script>
            <script src="./admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="./admin/vendor/jquery-easing/jquery.easing.min.js"></script>
            <script src="./admin/js/sb-admin-2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $(".months").trigger("change");
                });

                function prcFrmMnth(month, m_id) {
                    $.ajax({
                        url: "priceFrmMonth.php",
                        type: "POST",
                        data: {
                            mnth: month,
                            mID: m_id,
                        },
                        cache: false,
                        success: function(res) {
                            // console.log(res);
                            $('#showprice' + m_id).val(res);
                            $('#getprice' + m_id).text(res);
                            $('#Plan_prd' + m_id).val(month);
                            $('#plan_price' + m_id).val(res);
                        }
                    })
                }
            </script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
                $('body').on('click', '.buy_now', function(e) {

                    var row = $(this).attr("rowid");
                    var totalAmount = $("#plan_price" + row).val();
                    var plan_id = $("#get_plan_id" + row).val();
                    var plan_heading = $("#plan_heading" + row).val();
                    var months = $("#Plan_prd" + row).val();
                    var label = $("#lbl" + row).val();
                    var current_user_id = $("#current_user_id").val();

                    var options = {
                        "key": "rzp_test_Q6bSng7s2pKrDX",//"rzp_test_vzyh6oEpJwBj3p",
                        "amount": (totalAmount * 100), // 2000 paise = INR 20
                        "currency": "INR",
                        "name": "Devyog Vivah",
                        "description": "Payment",
                        "handler": function(response) {
                            console.log('success', response);
                            // console.log(response.razorpay_payment_id);
                            $.ajax({
                                url: 'payment-proccess.php',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    payment_flag: 'success',
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    totalAmount: totalAmount,
                                    plan_id: plan_id,
                                    current_user_id: current_user_id,
                                    label: label,
                                    months: months,
                                    plan_heading: plan_heading,
                                    metadata: '',
                                },
                                beforeSend: function() {
                                    console.log('beforeSend')
                                },
                                success: function(msg) {
                                    // console.log('success')
                                    setTimeout(function() {
                                        if (msg.code == 201) {
                                            swal({
                                                title: "Great...",
                                                text: "Payment Success.",
                                                icon: "success",
                                                buttons: true,
                                                dangerMode: false,
                                            });
                                            setTimeout(function() {
                                                window.location.reload();
                                            }, 600);
                                        }
                                    }, 600);
                                },
                                error: function(xhr) { // if error occured
                                    // console.log('error', xhr.statusText + ' ' + xhr.responseText)
                                },
                                complete: function() {
                                    console.log('complete')
                                },
                            });
                        },
                        "theme": {
                            "color": "#528FF0"
                        }
                    };
                    var rzp1 = new Razorpay(options);

                    rzp1.open();
                    rzp1.on('payment.failed', function(response) {
                        console.log('order fail', response.error);
                        var description = response.error.description.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');

                        var metadata = {
                            'code': response.error.code,
                            'description': description,
                            'source': response.error.source,
                            'step': response.error.step,
                            'reason': response.error.reason,
                        };
                        $.ajax({
                            url: 'payment-proccess.php',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                payment_flag: 'fail',
                                razorpay_payment_id: response.error.metadata.payment_id,
                                totalAmount: totalAmount,
                                plan_id: plan_id,
                                current_user_id: current_user_id,
                                label: label,
                                months: months,
                                plan_heading: plan_heading,
                                metadata: JSON.stringify(metadata),
                            },
                            beforeSend: function() {
                                // console.log('beforeSend')
                            },
                            success: function(msg) {
                                // console.log('success')
                                setTimeout(function() {
                                    if (msg.code == 202) {
                                        swal({
                                            title: "Oops...",
                                            text: "Payment Failed. Try Again",
                                            icon: "error",
                                            buttons: true,
                                            dangerMode: true,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 3000);
                                    }
                                }, 3000);
                            },
                            error: function(xhr) { // if error occured
                                // console.log('error', xhr.statusText + ' ' + xhr.responseText)
                            },
                            complete: function() {
                                // console.log('complete')
                            },
                        });

                    });
                    e.preventDefault();
                });
            </script>
    </body>

    </html>
<?php
} else {
    header("location:login-page.php");
}
?>