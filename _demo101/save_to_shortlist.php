<?php
include "dbconn.php";
session_start();
$like_name = "";
$status = "";
$sesn_user = $_SESSION['id'];
$like_id = $_POST['user_id'];
$sql = "SELECT * FROM `user_regiter` WHERE `id` = $like_id ";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $like_name = $row['name'];
}
    $clr = "SELECT * FROM `shortlist` where `user_id`= '$sesn_user' AND  `liked_p_id` = '$like_id'";    
    $abcdf = mysqli_query($conn, $clr);
    while ($row2 = mysqli_fetch_array($abcdf)) {
        $status = $row2['status'];
        // echo $status;
    }
    $count =  mysqli_num_rows($abcdf);
    // print_r($count);
    // echo $count;
    if ($status == 1 && $count > 0) {  
        $updt = "UPDATE `shortlist` SET `status` = '0' WHERE `user_id`= '$sesn_user' AND  `liked_p_id` = '$like_id'";
        $res = mysqli_query($conn, $updt);
        // $userUpdt = mysqli_query($conn, "UPDATE `user_regiter` SET `status` = '0' WHERE `user_id`= '$sesn_user' AND  `liked_p_id` = '$like_id'");
        if ($res > 0) {
            echo json_encode(array('status' => 201));
        } else {
            echo json_encode(array('status' => 404));
        }
    } else if ($status == 0 && $count > 0) {
        $updt = "UPDATE `shortlist` SET `status` = '1' WHERE `user_id`= '$sesn_user' AND  `liked_p_id` = '$like_id'";
        $res = mysqli_query($conn, $updt);
        if ($res > 0) {
            echo json_encode(array('status' => 202));
        } else {
            echo json_encode(array('status' => 404));
        }
    }else{        
        $sql1 = "INSERT INTO `shortlist`(`user_id`, `liked_p_id`, `liked_p_name`, `status`) VALUES ('$sesn_user','$like_id','$like_name','1')";
                //  INSERT INTO `shortlist`(`user_id`, `liked_p_id`, `liked_p_name`, `status`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
        $result1 = mysqli_query($conn, $sql1);
        if ($result1 > 0) {
            echo json_encode(array('status' => 200));
        } else {
            echo json_encode(array('status' => 404));
        }
    }

