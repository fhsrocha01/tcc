<?php require_once('../Connections/hellow.php');
include('verification.php');

//Pessoas que favoritaram
$id = $_SESSION['id_user'];
$sql = "SELECT * FROM favorite WHERE users_id_user=$id ORDER BY id DESC";
$result_favorite = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_favorite = mysql_fetch_assoc($result_favorite);
$totalRows_favorite = mysql_num_rows($result_favorite);


?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Favoritos - We Learn</title>

  <!-- Vendor CSS -->
  <link href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
  <link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
  <link href="vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
  <link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
  <link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">

  <!-- CSS -->
  <link href="css/app.min.1.css" rel="stylesheet">
  <link href="css/app.min.2.css" rel="stylesheet">
  <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>

  <?php include('header.php'); ?>
  <section id="main" data-layout="layout-1">

    <?php
    include('menu-left.php');
    ?>

    <section id="content">
      <div class="container">
        <div class="card">
          <ul class="tab-nav tn-justified">
            <li class="active waves-effect"><a href="favorites.php">Meus favoritos <span class="badge"><?php echo $totalRows_favorite; ?></span></a></li>
            <li class="waves-effect"><a href="me_favorite.php">Me favoritaram</a></li>
          </ul>

          <div class="card-body card-padding">

            <div class="contacts clearfix row">
              <?php if($totalRows_favorite!=0){
                do {
                  $my_favorites = $row_favorite['id_favorite'];
                  $sql = "SELECT id_user, name, photo FROM users WHERE id_user='$my_favorites'";
                  $result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
                  $row_user = mysql_fetch_assoc($result_user);
                  $totalRows_user = mysql_num_rows($result_user);
                  ?>
                  <div class="col-md-2 col-sm-4 col-xs-6">
                    <div class="c-item">
                      <a href="profile.php?id=<?php echo $row_user['id_user']; ?>" class="ci-avatar">
                        <?php if($row_user['photo']==NULL){
                          echo '<img src="img/profile-pics/user-default.jpg" alt="'.$row_user['name'].'">';
                        }
                        else {
                          echo '<img src="img/profile-pics/'.$row_user['photo'].'" alt="'.$row_user['name'].'">';
                        }?>

                      </a>

                      <div class="c-info">
                        <strong><?php echo $row_user['name']; ?></strong>
                      </div>


                    </div>
                  </div>
                  <?php } while ($row_favorite = mysql_fetch_assoc($result_favorite)); ?>
                  <?php }
                  else{ ?>
                    <div class="jumbotron bgm-white text-center">
                      <p>Você ainda não favoritou ninguém.</p>
                    </div>
                    <?php }?>

                  </div>
                </div>
              </div>
            </div>

          </section>
        </section>

        <?php include('footer.php'); ?>


        <!-- Javascript Libraries -->
        <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script src="vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
        <script src="vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

        <script src="vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="vendors/bower_components/fullcalendar/dist/fullcalendar.min.js "></script>
        <script src="vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
        <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
        <script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="js/flot-charts/curved-line-chart.js"></script>
        <script src="js/flot-charts/line-chart.js"></script>
        <script src="js/charts.js"></script>

        <script src="js/charts.js"></script>
        <script src="js/functions.js"></script>



      </body>
      </html>
