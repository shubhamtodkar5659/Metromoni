
<?php
include 'vars.php';
include 'include/load.php';
connect_db();
// echo json_encode($_POST);die;
$arr = array('code' => 200, 'msg' => 'Post data not found', 'status' => false);
if (isset($_POST['payment_flag'])) {
    $insert = "INSERT INTO `payment_history`(`user_id`, `payment_id`, 
                `plan_id`, `amount`, `payment_flag`,
                `metadata`, `created_at`) VALUES ('" . $_POST['current_user_id'] . "',
                '" . $_POST['razorpay_payment_id'] . "', '" . $_POST['plan_id'] . "',
                '" . $_POST['totalAmount'] . "', '" . $_POST['payment_flag'] . "',
                '" . $_POST['metadata'] . "', concat(CURDATE(),' ',CURTIME())
                )";
    $sql_insert = $db->query($insert);
    $sql_insert_success = $sql_insert['success'];
    if ($sql_insert_success) :
        // echo 'inserted';
    endif;
    if ($_POST['payment_flag'] == 'success') {
        $planId = $_POST['plan_id'];
        $price = $_POST['totalAmount'];
        $user_id = $_POST['current_user_id'];
        $planDuration = $_POST['months'];
        $planType = $_POST['plan_heading'];
        $label = $_POST['label'];
        $date = date('Y-m-d');
        $month = $planDuration;
        $days = $month * 30;
        $expiry = date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
        $query = "UPDATE `user_regiter` SET `payment_status`='1',`plan_duration`='$planDuration',
        `type_plan`='$planType',`label`='$label',`plan_price`='$price',`type_plan_id`='$planId',
        `plan_purchase_date` = CURDATE(), `plan_expiry_date`='$expiry' WHERE `id` = '$user_id' ";
        // $sql = mysqli_query($conn, $query);
        $sql =  $db->query_update($query);
        if ($sql) {
            $insert_tbl_plan = "INSERT INTO `table_plan`( `user_id`,`label`, `payment_status`, `plan_duration`, `type_plan`, `plan_price`, `type_plan_id`, `plan_purchase_date`, `plan_expiry_date`) VALUES ('$user_id','$label','1','$planDuration','$planType','$price','$planId',CURDATE(),'$expiry')";
            $db->query($insert_tbl_plan);
            // $sql2 = mysqli_query($conn,$insert_tbl_plan);
        }
        $arr = array('code' => 201, 'msg' => 'Payment successfully credited', 'status' => true);
    } else if ($_POST['payment_flag'] == 'fail') {
        $arr = array('code' => 202, 'msg' => 'Payment failed', 'status' => false);
    }
}
// echo json_encode($_POST);
echo json_encode($arr);
?>