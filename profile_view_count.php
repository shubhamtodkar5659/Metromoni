<?php
require_once 'vars.php';
require_once  'include/load.php';
connect_db();

$current_user_id = $_POST['current_user_id'];
$user_id = $_POST['user_id'];

$current_user_details = $db->query("SELECT type_plan_id FROM `user_regiter` WHERE id = '$current_user_id' ");
$current_user_plan_id = ($current_user_details['success'] && !empty($current_user_details['rows'])) ? $current_user_details['rows'][0]['type_plan_id'] : 0;

$added_details = $db->query("SELECT * FROM `visited_profile_records` WHERE `profile_viewer` = '$current_user_id' AND  `profile_viewed` = '$user_id' ");
$added_data = !empty($added_details['rows']) ? $added_details['rows'] : array();

if (empty($added_data)) {
    $CHECK = "SELECT IFNULL(COUNT(*),0) AS total FROM `visited_profile_records` 
    WHERE `profile_viewer`='$current_user_id' AND `plan_id`='$current_user_plan_id'";
    $CHECK_r = $db->query($CHECK);
    $where_cond = "";
    $check_total = ($CHECK_r['success'] == 1 && !empty($CHECK_r['rows'])) ?  $CHECK_r['rows'][0]['total'] : 0;
    if ($check_total == 0) {
        $where_cond = " cp.id = ur.type_plan_id ";
    } else {
        $where_cond = " vpr.plan_id = ur.type_plan_id ";
    }
    $remaining_q = "SELECT GROUP_CONCAT( vpr.profile_viewed) AS visited_members,
                    (ifnull(cp.visiblePro,0)  -  COUNT(vpr.id) ) AS remaining_profile_visit,
                    ur.plan_expiry_date
                    FROM
                        `visited_profile_records` AS vpr
                    LEFT JOIN user_regiter AS ur ON ur.id = vpr.profile_viewer
                    LEFT JOIN create_plans AS cp ON cp.id = vpr.plan_id
                    WHERE
                        $where_cond AND vpr.profile_viewer = $current_user_id ";
    $remaining_r = $db->query($remaining_q);
    $remaining_profile_visit = 0;
   
    if (
        isset($remaining_r['rows'][0]['plan_expiry_date'])
        && $remaining_r['rows'][0]['plan_expiry_date'] >= date('Y-m-d')
    ) {
        $remaining_profile_visit = ($remaining_r['success'] == 1 && !empty($remaining_r['rows'])) ?  $remaining_r['rows'][0]['remaining_profile_visit'] : 0;
    }
    // $remaining_profile_visit = ($remaining_r['success'] == 1 && !empty($remaining_r['rows'])) ?  $remaining_r['rows'][0]['remaining_profile_visit'] : 0;
    if ($remaining_profile_visit == 0 || $remaining_profile_visit < 0) {
        print_r(array('success' => 0, 'insert_id' => 0, 'remaining_profile_visit' => $remaining_profile_visit));
    } else {
        $user_details = $db->query("INSERT INTO `visited_profile_records`( `profile_viewer`, `profile_viewed`, plan_id) VALUES ( '$current_user_id','$user_id', '$current_user_plan_id')");
        $success = isset($user_details['success']) ? $user_details['success'] : '';
        $insert_id = isset($user_details['insert_id']) ? $user_details['insert_id'] : '';
        print_r(array('success' => $success, 'insert_id' => $insert_id, 'remaining_profile_visit' => $remaining_profile_visit));
    }
} else {
    print_r(array('success' => 0, 'insert_id' => 0, 'remaining_profile_visit' => 0));
}
