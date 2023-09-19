<?php
if (session_id() == '') {
    session_start();
}
include 'dbconn.php';
// require('lib/razorpay-php/Razorpay.php');

// use Razorpay\Api\Api;

// $keyId = 'rzp_test_vzyh6oEpJwBj3p';
// $keySecret = '1Z7R3QA5h13aobu273eU8CUi';
// $api = new Api($keyId, $keySecret);
// $orderData = array(
//     'receipt' => '123',
//     'amount' => 100,
//     'currency' => 'INR',
//    // 'notes' => array('key1' => 'value3', 'key2' => 'value2')
// );


$return_page = "pricing-plan.php";
$_SESSION['return_page'] = $return_page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DevyogVivah | Matrimony</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fontello.css">
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">
</head>

<body>
    <?php
    include 'mainHeader.php';
    ?>
    <!-- page header -->
    <!-- <div class="tp-page-head">     
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle">
                            <i class="icon icon-size-60 icon-budget icon-white"></i>
                        </div>
                        <h1>Membership Plan's Table</h1>
                        <p>Fusce volutpat turpis sit amet justo venenatis vestibul leo augue, molestie nec lacus utemper
                            rhoncus arcuoin auctor sodales interdum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- /.page header -->
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Pricing Table</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container bg-light">
        <div class="container">
            <div class="row pricing-container">
                <?php
                if (isset($_SESSION['id'])) {
                    $user_id = $_SESSION['id'];
                    include 'dbconn.php';
                    if (isset($_POST['purchaseplan'])) {
                        // $razorpayOrder = $api->order->create($orderData);
                        // echo '<pre>';
                        // print_r($razorpayOrder);
                        // die;
                        // $planId = $_POST['plan_id'];
                        // $planDuration = $_POST['months'];
                        // $planType = $_POST['plan_heading'];
                        // $label = $_POST['label'];
                        // $price = $_POST['plan_price'];
                        // $date = date('Y-m-d');
                        // $month = $planDuration;
                        // $days = $month * 30;
                        // $expiry = date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
                        // $sql = mysqli_query($conn, "UPDATE `user_regiter` SET `payment_status`='1',`plan_duration`='$planDuration',`type_plan`='$planType',`label`='$label',`plan_price`='$price',`type_plan_id`='$planId',`plan_purchase_date` = CURDATE(), `plan_expiry_date`='$expiry' WHERE `id` = '$user_id' ");
                        // if ($sql) {
                        //     $sql2 = mysqli_query($conn, "INSERT INTO `table_plan`( `user_id`,`label`, `payment_status`, `plan_duration`, `type_plan`, `plan_price`, `type_plan_id`, `plan_purchase_date`, `plan_expiry_date`) VALUES ('$user_id','$label','1','$planDuration','$planType','$price','$planId',CURDATE(),'$expiry')");
                        //     // echo "<a name='deactivateplan' data-toggle='modal' data-target='#deactivateplan" . $row['id'] . "' class='btn btn-default btn-danger btn-sm'>Active</a>";
                        // }
                    }
                    $plan_expiry_date = "";
                    $selected_plan = "";
                    $selected_month = 0;
                    $selected_plan_price = 0;

                    $trial = mysqli_query($conn, "SELECT * FROM `user_regiter` where `id` = '$_SESSION[id]'");
                    while ($rowid = mysqli_fetch_array($trial)) {
                        $selected_plan = $rowid['type_plan_id'];
                        $selected_month = $rowid['plan_duration'];
                        $selected_plan_price = $rowid['plan_price'];
                        $plan_expiry_date = $rowid['plan_expiry_date'];
                    }
                    $sql_plan = "SELECT * FROM `create_plans`";
                    $result = mysqli_query($conn, $sql_plan);
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
                        <div class="col-md-3 col-sm-5 ">
                            <div class="pricing-box">
                                <div class="well-box">
                                    <h3 class="price-title" style="font-size: x-large;"><?php echo $row['heading']; ?></h3>
                                    <input type="hidden" id="showprice<?php echo $row['id']; ?>">
                                    <h2 class="price-plan">
                                        <span class="dollor-sign">₹</span>
                                        <span id="getprice<?php echo $row['id']; ?>">
                                            <?php echo $plan_price; ?>
                                        </span>
                                    </h2>
                                    <select class="months" name="months" class="select-form" onchange="prcFrmMnth(this.value, <?php echo $row['id']; ?>)">
                                        <?php
                                        for ($i = 0; $i < count($month); $i++) {
                                            $selected_m = ' ';
                                            if (($row['id'] == $selected_plan) && $selected_month == $month[$i]) {
                                                $selected_m = 'selected';
                                            }
                                            echo '<option value =' . $month[$i] . '  ' . $selected_m . '>' . $month[$i] . '/ Mo</option>';
                                        }
                                        ?>
                                    </select>
                                    <p><?php echo $row['discription']; ?></p>
                                    <?php if ($row['id'] == $selected_plan) : ?>
                                        <?php if ($plan_expiry_date >= date('Y-m-d')) : ?>
                                            <a data-toggle="modal" data-target="#deactivate<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-danger btn-sm">Active</a>
                                            <?php else : ?>
                                                <a data-toggle="modal" data-target="#deactivate<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-danger btn-sm">Expired</a>
                                                <a data-toggle="modal" name="selectPlan" data-target="#myModal<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-warning btn-sm">Select Plan</a>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <a data-toggle="modal" name="selectPlan" data-target="#myModal<?php echo $row['id']; ?>" class="plan_slct_btn btn btn-warning btn-sm">Select Plan</a>
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
                            <div class="modal fade" id="myModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <form action="" method="POST">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Buy Plan</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <input name="plan_heading" type="hidden" id="plan_heading<?php echo $row['id']; ?>" value="<?php echo $row['heading']; ?>">
                                            <input name="months" type="hidden" id="Plan_prd<?php echo $row['id']; ?>" value="">
                                            <input name="plan_price" type="hidden" id="plan_price<?php echo $row['id']; ?>" value="">
                                            <input type="hidden" id="lbl<?php echo $row['id']; ?>" name="label" value="<?php echo $row['label']; ?>">
                                            <!-- <form action="" method="POST"> -->
                                            <div class="modal-body">
                                                Do you want to confirm the purchase?
                                            </div>
                                            <div class="modal-footer">
                                                <input name="get_plan_id" type="hidden" id="get_plan_id<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button name="purchaseplan" id="purchase-btn" type="submit" class="btn btn-primary buy_now" rowid="<?php echo $row['id']; ?>">Confirm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php }
                } else {
                    ?>
                    <?php
                    $sql_plan = "SELECT * FROM `create_plans`";
                    $result = mysqli_query($conn, $sql_plan);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $month = explode(",", $row['months']);
                        $price = explode(",", $row['price']);
                    ?>
                        <div class="col-md-3 col-sm-5 ">
                            <div class="pricing-box">
                                <div class="well-box">
                                    <h2 class="price-title" style="font-size: x-large;"><?php echo $row['heading']; ?></h2>
                                    <input type="hidden" id="lbl" name="lbl" value="<?php echo $row['label']; ?>">
                                    <input type="hidden" id="showprice<?php echo $row['id']; ?>">
                                    <h1 class="price-plan"><span class="dollor-sign">₹</span><span id="getprice<?php echo $row['id']; ?>"><?php echo $price[0]; ?></span></h1>
                                    <select class="months" name="months" class="select-form" onchange="prcFrmMnth(this.value, <?php echo $row['id']; ?>)">
                                        <?php
                                        for ($i = 0; $i < count($month); $i++) {
                                            echo '<option value =' . $month[$i] . '>' . $month[$i] . '/ Mo</option>';
                                        }
                                        ?>
                                    </select>
                                    <p><?php echo $row['discription']; ?></p>
                                    <?php
                                    echo "<a name='selectPlan' data-toggle='modal' data-target='#loginFirst" . $row['id'] . "' class='btn btn-default btn-sm'>Select Plan</a>";
                                    ?>
                                </div>
                                <ul class="check-circle list-group">
                                    <li class="list-group-item"><?php echo $row['rule1']; ?></li>
                                    <li class="list-group-item"><?php echo $row['rule2']; ?></li>
                                    <li class="list-group-item"><?php echo $row['rule3']; ?></li>
                                    <li class="list-group-item"><?php echo $row['rule4']; ?></li>
                                    <input name="edit_id" type="hidden" class="form-control" id="edit_id" value="<?php echo $row['id']; ?>">
                                </ul>
                            </div>
                        </div>

                        <form action="" method="POST">
                            <div class="modal fade" id="loginFirst<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Do you Want to purchase this plan?</h4>
                                            <!-- <button type="button" class="close cross" data-dismiss="modal" aria-label="Close"><span  aria-hidden="true" >&times;</span></button> -->
                                        </div>
                                        <div class="modal-body">
                                            Please Login or Register first to Purchase the plan.
                                        </div>
                                        <div class="modal-footer">
                                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                            <a href="login-page.php" name="ok" id="ok-btn" type="button" class="btn btn-primary">Ok</a>
                                            <input name="loginmodal" type="hidden" id="loginmodal" value="<?php echo $row['id']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                <?php  }
                } ?>


            </div>
        </div>
    </div>
    </div>
    <input type="hidden" id="current_user_id" value="<?php echo $user_id; ?>" />
    <?php
    include 'footer.php';
    ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flex Nav Script -->
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/navigation.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script>
        $(document).ready(function() {
            $(".months").trigger("change");
        });

        function prcFrmMnth(month, m_id) {
            // alert(month);
            $.ajax({
                url: "priceFrmMonth.php",
                type: "POST",
                data: {
                    mnth: month,
                    mID: m_id,
                },
                cache: false,
                success: function(res) {
                    console.log(res);
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
                "key": "rzp_test_Q6bSng7s2pKrDX", //rzp_test_vzyh6oEpJwBj3p
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
// }else{
// header("location:login-page.php");  }
?>