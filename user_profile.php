<?php
include 'dbconn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DevyogVivah | Matrimony </title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fontello.css">
    <!-- jquery ui CSS -->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/Golden_WC.ico" type="image/x-icon">
    <!-- codepen links -->
    <!--/---------step wizard----------- -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>

    </style>
</head>

<body>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/navigation.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    include 'mainHeader.php';
    ?>
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container">
            <div class="row">
                <?php   $current_user_id = $_SESSION['id'];  ?>
                <?php $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';  ?>
                <?php if (!empty($user_id)) : ?>
                    <?php
                    $user_query = "SELECT ct.name AS city_name, c.name AS country_name, s.name AS state_name, u.* 
                                    FROM user_regiter AS u 
                                    LEFT JOIN countries AS c ON c.id = u.country AND c.is_active = 1 
                                    LEFT JOIN states AS s ON s.id = u.state AND s.is_active = 1 
                                    LEFT JOIN cities AS ct ON ct.id = u.city AND c.is_active = 1 
                                    WHERE u.id = '$user_id'  ";
                    $user_result = mysqli_query($conn, $user_query);
                    ?>
                    <?php if ($user_result->num_rows > 0) : ?>
                        <?php while ($user_data = mysqli_fetch_array($user_result)) : ?>
                            <div class="row card shadow mb-4">
                                <!-- Profil card -->
                                <!-- <div class="card shadow mb-4"> -->
                                <div class="card-header py-3">
                                </div>
                                <div class="card-body col-md-12">
                                    <div class="row" style="line-height: 1.5;">
                                        <div class="col-md-6">
                                            <?php
                                            $user_sql = "SELECT image_name FROM `user_profile_images` where `user_id` =  '$user_id' ";
                                            $result = mysqli_query($conn, $user_sql);
                                            while ($imagerow = mysqli_fetch_assoc($result)) :
                                                $image_name = $imagerow['image_name'];
                                            ?>
                                                <img class="mySlides" style="display: none;min-width:250px;min-height:250px;max-width:250px;max-height:250px;" src="user_image/<?php echo  $image_name; ?>" style="width:50%">
                                            <?php
                                            endwhile;
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <b>This Profile is for :</b> <?php echo $user_data['profile_for']; ?><br>
                                            <b>Name :</b> <?php echo $user_data['name']; ?><br>
                                            <b>Surname :</b> <?php echo $user_data['surname']; ?><br>
                                            <b>Gender :</b> <?php echo $user_data['gender']; ?><br>
                                            <b>Height :</b> <?php echo $user_data['height']; ?> In<br>
                                            <b>Age :</b> <?php echo $user_data['bDate']; ?><br>
                                            <b>Income (yearly) :</b> <?php echo $user_data['income']; ?><br>
                                            <b>Sub-Community :</b> <?php echo $user_data['sub-com']; ?><br>
                                            <b>About me :</b> <?php echo $user_data['bio']; ?><br><br>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Marital Status :</b> <?php echo $user_data['marStat']; ?><br>
                                            <b>Diet :</b> <?php echo $user_data['diet']; ?><br>
                                            <b>Mother Tongue :</b> <?php echo $user_data['lang']; ?><br>
                                            <b> Other Languages :</b> <?php echo $user_data['lang']; ?><br>
                                            <b> Smoking :</b> <?php echo $user_data['smoking']; ?><br>
                                            <b> Drinking :</b> <?php echo $user_data['drinking']; ?><br><br>
                                            <b>Gotra :</b> <?php echo $user_data['gotra']; ?><br>
                                            <b>Live with family :</b> <?php echo $user_data['yes/no']; ?><br>
                                            <b>Caste :</b> <?php echo $user_data['caste']; ?><br>
                                            <b>Native Place :</b> <?php echo $user_data['native_place']; ?><br><br>

                                            <b>Birth Date :</b> <?php echo $user_data['bDate']; ?><br>
                                            <b>Birth Time :</b> <?php echo $user_data['bTime']; ?><br>
                                            <b>Birth Location :</b> <?php echo $user_data['bLocation']; ?><br>

                                            <b>Height(In) :</b> <?php echo $user_data['height']; ?> <br>
                                            <b>Weight(Kg) :</b> <?php echo $user_data['weight']; ?><br>
                                            <b>Blood Group :</b> <?php echo $user_data['bGrp']; ?><br><br>

                                            <b>Paternal Side Details</b><br>
                                            <b>Father Name :</b> <?php echo $user_data['p_father']; ?><br>
                                            <b>Mother Name :</b> <?php echo $user_data['p_mother']; ?><br>
                                            <b>Father Occupation :</b> <?php echo $user_data['p_father_occ']; ?><br>
                                            <b>Mother Occupation :</b> <?php echo $user_data['p_mother_occ']; ?><br>
                                            <b>Numbers Of Sisters:</b> <?php echo $user_data['no_of_sisters']; ?><br>
                                            <b>Sisters Details:</b> <?php echo $user_data['sisters_details']; ?><br>
                                            <b>Numbers Of Brothers:</b> <?php echo $user_data['no_of_brothers']; ?><br>
                                            <b>Brothers Details:</b> <?php echo $user_data['brothers_details']; ?><br>

                                        </div>
                                        <div class="col-md-6">

                                            <b>E-mail :</b> <?php echo $user_data['email']; ?><br>
                                            <b>Phone Number :</b> <?php echo $user_data['phone']; ?><br>
                                            <b>Address :</b> <?php echo $user_data['address']; ?><br>
                                            <b>Country :</b> <?php echo strtoupper($user_data['country_name']); ?><br>
                                            <b>State :</b> <?php echo strtoupper($user_data['state_name']); ?><br>
                                            <b>City :</b> <?php echo strtoupper($user_data['city_name']); ?><br><br>

                                            <b>Highest Education :</b> <?php echo $user_data['HighEdu']; ?><br>
                                            <b>Specialization :</b> <?php echo $user_data['specialization']; ?><br>
                                            <b>Collage :</b> <?php echo $user_data['collage']; ?><br>
                                            <b>Profession :</b> <?php echo $user_data['prof']; ?><br>
                                            <b>Working Out Of India :</b>

                                            <?php echo $out_of_india = (isset($user_data['out_of_india']) && $user_data['out_of_india'] != null ? $user_data['out_of_india'] : ''); ?>
                                            <br>
                                            <?php if ($out_of_india  == 'Yes') : ?>
                                                <b>Out Of India Location :</b><?php echo $user_data['prof_country']; ?><br>
                                            <?php endif; ?>

                                            <br>


                                            <b>Maternal Side Details</b><br>
                                            <b>Father Name :</b> <?php echo $user_data['m_father']; ?><br>
                                            <b>Mother Name :</b> <?php echo $user_data['m_mother']; ?><br>
                                            <b>Father Occupation :</b> <?php echo $user_data['m_father_occ']; ?><br>
                                            <b>Mother Occupation :</b> <?php echo $user_data['m_mother_occ']; ?><br><br>


                                            <b>I am not particular about my Partners Community :</b>
                                            <?php echo (isset($user_data['community-checkbox']) && $user_data['community-checkbox'] != null ? 'Yes' : 'No'); ?>
                                            <br>
                                            <b>Membership Plan :</b> <?php echo $user_data['type_plan']; ?>

                                        </div>
                                    </div>
                                    <!-- </ul> -->

                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php else : ?>
                <?php endif; ?>
            </div>
        </div>
    </div>



</body>
 
<script>
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) {
            myIndex = 1
        }
        x[myIndex - 1].style.display = "block";
        setTimeout(carousel, 4000); // Change image every 2 seconds
    }
</script>

</html>