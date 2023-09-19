<?php
include 'dbconn.php';
$M = $_POST['mnth'];
$m_id = $_POST['mID'];

$prc = mysqli_query($conn, "SELECT * FROM `create_plans` where `id` = '$m_id' ");
while ($row = mysqli_fetch_array($prc)) {
$month = explode("," ,$row['months']);
$price = explode("," ,$row['price']);
for ($i=0; $i < count($month) ; $i++) { 
    if($month[$i] == $M){
        echo $price[$i];
    }else{
        continue ;
    }
}
}

?>