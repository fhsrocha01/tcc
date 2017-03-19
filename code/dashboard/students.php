<?php require_once('../Connections/hellow.php');
include('verification.php');

if(isset($_POST['search_student'])){
  $search = $_POST['search_student'];
  $sql = "SELECT * FROM users WHERE type='S' AND active='Y' AND name LIKE '%$search%' ORDER BY name ASC";
  $result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
  $row_user = mysql_fetch_assoc($result_user);
  $totalRows_user = mysql_num_rows($result_user);
}
else if(isset($_GET['level'])){
  $level = $_GET['level'];
  $sql = "SELECT * FROM users WHERE type='S' AND active='Y' AND level=$level ORDER BY name ASC";
  $result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
  $row_user = mysql_fetch_assoc($result_user);
  $totalRows_user = mysql_num_rows($result_user);
}
else{
  $sql = "SELECT * FROM users WHERE type='S' AND active='Y'";
  $result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
  $row_user = mysql_fetch_assoc($result_user);
  $totalRows_user = mysql_num_rows($result_user);
}

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Students - We Learn</title>

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

    <?php include('menu-left.php'); ?>

    <section id="content">
      <div class="container">
        <div class="card">
          <ul class="tab-nav tn-justified">
            <li class="waves-effect"><a href="index.php">Cursos</a></li>
            <li class="waves-effect"><a href="teachers.php">Professores</a></li>
            <li class="active waves-effect"><a href="students.php">Alunos</a></li>
          </ul>
          <div class="lv-header-alt clearfix m-b-5">
            <?php if(isset($_POST['search_student'])){ ?>
              <h2 class="lvh-label hidden-xs"><b><?php echo $totalRows_user; ?></b>
                <?php if($totalRows_user==1){
                  echo 'resultado encontrado';
                }
                else{
                  echo 'resultados encontrados';
                } ?>
                para a pesquisa por <b>"<?php echo $_POST['search_student']; ?>"</b>. <a href="students.php" class="btn btn-primary btn-xs">Voltar</a> <a class="lvh-search-trigger btn btn-default btn-xs"><i class="fa fa-search"></i> Nova pesquisa</a></h2>
                <?php }
                else if(isset($_GET['level'])){ ?>
                  <h2 class="lvh-label hidden-xs"><?php if($totalRows_user==1){
                    echo '<b>'.$totalRows_user.'</b> aluno encontrado';
                  }
                  else {
                    echo '<b>'.$totalRows_user.'</b> alunos encontrados';
                  }?> com nível de inglês
                  <?php
                  if($_GET['level']==1){
                    echo '<span class="badge bgm-blue">Iniciante</span>';
                  }
                  else if($_GET['level']==2){
                    echo '<span class="badge bgm-green">Básico</span>';
                  }
                  else if($_GET['level']==3){
                    echo '<span class="badge bgm-orange">Intermediário</span>';
                  }
                  else if($_GET['level']==4){
                    echo '<span class="badge bgm-red">Avançado</span>';
                  }
                  else if($_GET['level']==5){
                    echo '<span class="badge bgm-purple">Fluente</span>';
                  } ?>
                </h2>
                <?php }
                else { ?>
                  <h2 class="lvh-label hidden-xs">Encontre pessoas para praticar seu inglês!</h2>
                  <?php } ?>
                  <form method="POST" name="search" id="search" action="students.php">
                    <div class="lvh-search">
                      <input type="text" name="search_student" id="search_student" placeholder="Nome do aluno..." class="lvhs-input">

                      <i class="lvh-search-close">&times;</i>
                    </div>
                  </form>

                  <ul class="lv-actions actions">
                    <?php if(!isset($_POST['search_student'])){ ?>
                      <li>
                        <a href="" class="lvh-search-trigger">
                          <i class="zmdi zmdi-search"></i>
                        </a>
                      </li>
                      <?php } ?>
                      <li class="dropdown">
                        <a href="" data-toggle="dropdown"="" aria-expanded="false" aria-haspopup="true">
                          <i class="zmdi zmdi-filter-list"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                          <li>
                            <a href="students.php">Todos</a>
                          </li>
                          <li>
                            <a href="students.php?level=1">Iniciante</a>
                          </li>
                          <li>
                            <a href="students.php?level=2">Básico</a>
                          </li>
                          <li>
                            <a href="students.php?level=3">Intermediário</a>
                          </li>
                          <li>
                            <a href="students.php?level=4">Avançado</a>
                          </li>
                          <li>
                            <a href="students.php?level=5">Fluente</a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>


                  <div class="card-body card-padding">

                    <div class="contacts clearfix row">

                      <?php if($totalRows_user!=0){ ?>
                        <?php do { ?>
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
                                <?php
                                if($row_user['level']==1){
                                  echo '<span class="badge bgm-blue">Iniciante</span>';
                                }
                                else if($row_user['level']==2){
                                  echo '<span class="badge bgm-green">Básico</span>';
                                }
                                else if($row_user['level']==3){
                                  echo '<span class="badge bgm-orange">Intermediário</span>';
                                }
                                else if($row_user['level']==4){
                                  echo '<span class="badge bgm-red">Avançado</span>';
                                }
                                else if($row_user['level']==5){
                                  echo '<span class="badge bgm-purple">Fluente</span>';
                                } ?>
                              </div>

                            </div>
                          </div>
                          <?php } while ($row_user = mysql_fetch_assoc($result_user)); ?>
                          <?php }
                          else{ ?>
                            <div class="jumbotron">
                              <p>Não encontramos nenhum aluno :/</p>
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
