<?php
if (session_id() == '') {
  session_start();
}
include 'dbconn.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>

  <body>
    <div class="collapse"
         id="searcharea">
      <!-- top search -->
      <div class="input-group">
        <input type="text"
               class="form-control"
               placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-primary"
                  type="button">Search</button>
        </span>
      </div>
    </div>
    <!-- /.top search -->
    <div class="top-bar">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-6 top-message">
            <p>Warmest Greetings</p>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-6 top-links">
            <ul class="listnone">
              <?php
              if (isset($_SESSION['id'])) {
                $sql = mysqli_query($conn, "SELECT * FROM `user_regiter` where `id`= '$_SESSION[id]'");
                while ($row = mysqli_fetch_array($sql)) {
                  ?>
                  <li class="text-white">
                    <?php echo $row['email'];
                } ?>
                </li>
                <li><a href="userDashboard.php">My Dashboard</a></li>
                <li><a href="logout.php">Log out</a></li>
              <?php } else { ?>
                <li><a href="signup-couple.php">Register</a></li>
                <li><a href="login-page.php">Log in</a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="header">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-xs-12 logo">
            <div>
              <a href="index.php">
                <img class="navbar-brand "
                     src="images/logo.png"
                     alt="DevyogVivah"></a>
            </div>
          </div>
          <div class="col-md-9 col-xs-12">
            <div class="navigation"
                 id="navigation">
              <ul>
                <li><a href="index.php"
                     title="Home"
                     class="animsition-link">Home</a></li>
                <li><a href="about-us.php">About us</a></li>
                <li><a href="real-wedding-listing.php">successful stories</a></li>
                <li><a href="pricing-plan.php">Membership plans</a></li>
                <li><a href="faq.php">FAQ's</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="contact-us.php">Contact us</a></li>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

</html>