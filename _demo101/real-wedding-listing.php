
<?php
include 'dbconn.php';
$sql = "SELECT * FROM `success_story` ";
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DevyogVivah | Matrimony for Doctors</title>
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
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
  .real-wedding-info {
    min-height: 50rem;
    /* max-width: 100%; */
    margin-bottom: 30px;
}
@media (min-width:481px) and (max-width: 999px) {
.real-wedding-info {
    height: 49rem;
    /* max-width: 100%; */
}
}
@media (min-width:321px) and (max-width:480px){
    .real-wedding-info {
    height: 51rem;
    /* max-width: 100%; */
    /* margin-bottom: 30px; */
}
}
@media (max-width:320px) {
.real-wedding-info {
    height: 55rem;
    margin: 4%;
  }
}
    </style>
</head>

<body>
<?php
  include 'mainHeader.php';
  ?>
    </div>
      <!-- page header -->
    <!-- <div class="tp-page-head">      
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle">
                            <i class="icon icon-size-60 icon-newly-married-couple icon-white"></i>
                        </div>
                        <h1>Happily Married Couples</h1>
                        <p>Find the perfect wedding vendor for your wedding. Search wedding reception vendor reviews and vendors in your area.</p>
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
                        <li class="active">Successful Weddings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container">
            <div class="row">
            <?php   while($row = mysqli_fetch_assoc($result)){  ?>
                <div class="col-md-4 col-sm-6">
                    <div class="real-wedding-block  ">
                        <!-- real wedding block -->
                     
                        <div class="real-wedding-info well-box text-center">
                        <div class="real-wedding-img">
                            <a href="#"><img src="./admin/couple_img/<?php echo $row['filename']; ?>" alt="" class="img-circle " height="100px" width="100px"></a>
                        </div> <hr>
                            <h2 class="real-wedding-title"><a href="#" class="title"><?php echo ucwords($row['name']); ?></a></h2>
                            <!-- <p class="real-wed-meta"><span class="wed-day-meta"><i class="icon-wedding-day icon-size-18"></i> 5 sept,2022</span> -->
                                <span class="wed-location-meta"> <i class="icon-wedding-location icon-size-18"></i> <?php echo ucwords($row['location']); ?></span>
                            </p>
                            <p>"<?php echo ucwords($row['message']); ?>"</p>
                        </div>
                    </div>
                    <!-- /.real wedding block -->
                </div>
                <?php } ?>
             </div>
        </div>
    </div>
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
    <script type="text/javascript" src="js/bootstrap-select.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
</body>

</html>
