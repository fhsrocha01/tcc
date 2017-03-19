<?php require_once('../Connections/hellow.php');
include('verification.php');
$id_subscriber = $_SESSION['id_user'];
$sql = "SELECT * FROM inscription WHERE users_id_user=$id_subscriber ORDER BY registration_date DESC";
$result_inscriptions = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_inscriptions = mysql_fetch_assoc($result_inscriptions);
$totalRows_inscriptions = mysql_num_rows($result_inscriptions);

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Minhas inscrições - We Learn</title>

	<!-- Vendor CSS -->
	<link href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
	<link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
	<link href="vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
	<link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
	<link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
	<link href="vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">


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

					<div class="card">
						<div class="listview lv-bordered lv-lg">


							<div class="lv-header-alt clearfix">
								<h2 class="lvh-label">Minhas inscrições</h2>
							</div>

							<div class="lv-body">

								<?php if($totalRows_inscriptions!=0){ ?>

									<?php do {
										$course_subscriber = $row_inscriptions['courses_id_course'];
										$sql = "SELECT * FROM courses WHERE published='Y' AND id_course=$course_subscriber";
										$result_course_sub = mysql_query($sql,$connection) or die ("Error in table selection.");
										$row_course_sub = mysql_fetch_assoc($result_course_sub);
										$totalRows_course_sub = mysql_num_rows($result_course_sub);
										?>
										<div class="lv-item media">
											<div class="media-body">
												<a href="course.php?id=<?php echo $row_course_sub['id_course']; ?>">
													<div class="lv-title"><h4><div class="lv-avatar bgm-gray pull-left"><i class="fa fa-graduation-cap"></i></div> <?php echo $row_course_sub['name']; ?></h4>
													<?php if($row_course_sub['level']==1){
														echo "<span class='badge bgm-blue'>Iniciante</span>";
													}
													else if($row_course_sub['level']==2){
														echo "<span class='badge bgm-green'>Básico</span>";
													}
													else if($row_course_sub['level']==3){
														echo "<span class='badge bgm-orange'>Intermediário</span>";
													}
													else if($row_course_sub['level']==4){
														echo "<span class='badge bgm-red'>Avançado</span>";
													}
													else if($row_course_sub['level']==5){
														echo "<span class='badge bgm-purple'>Fluente</span>";
													}
													?>
												</div>
											</a>

										</div>
									</div>
									<?php } while ($row_inscriptions = mysql_fetch_assoc($result_inscriptions)); ?>

									<?php }
									else{ ?>
										<div class="jumbotron bgm-white text-center">
											<p>Você ainda não se inscreveu em nenhum curso!</p>
										</div>
										<?php }?>
									</div>
								</div>

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
		<script src="vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>


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
