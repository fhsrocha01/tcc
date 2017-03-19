<?php require_once('../Connections/hellow.php');
include('verification.php');
if(isset($_GET['level'])){
	$level = $_GET['level'];
	$sql = "SELECT * FROM courses WHERE published='Y' AND level='$level' ORDER BY rand()";
	$result_courses = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_courses = mysql_fetch_assoc($result_courses); // recebe os dados do result
	$totalRows_courses = mysql_num_rows($result_courses); // numero de registros encontrados
}
else if(isset($_POST['search_course']) AND $_POST['search_course']!=NULL){
	$search = $_POST['search_course'];
	$sql = "SELECT * FROM courses WHERE published='Y' AND name LIKE '%$search%' OR tags LIKE '%$search%' OR about LIKE '%$search%' ORDER BY name ASC";
	$result_courses = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_courses = mysql_fetch_assoc($result_courses); // recebe os dados do result
	$totalRows_courses = mysql_num_rows($result_courses); // numero de registros encontrados
}
else {
	$sql = "SELECT * FROM courses WHERE published='Y' ORDER BY rand()";
	$result_courses = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_courses = mysql_fetch_assoc($result_courses); // recebe os dados do result
	$totalRows_courses = mysql_num_rows($result_courses); // numero de registros encontrados
}

$id_subscriber = $_SESSION['id_user'];
$sql = "SELECT * FROM inscription WHERE users_id_user=$id_subscriber";
$result_inscriptions = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_inscriptions = mysql_fetch_assoc($result_inscriptions); // recebe os dados do result
$totalRows_inscriptions = mysql_num_rows($result_inscriptions); // numero de registros encontrados

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard - We Learn</title>

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

	<?php include('header.php'); 	?>
	<section id="main" data-layout="layout-1">

		<?php include('menu-left.php'); ?>

		<section id="content">
			<div class="container">

				<!-- Mensagens de alerta -->
				<?php if(isset($_GET['skype']) AND $_GET['skype']=='erro'){ ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<b>Ops!</b> Parece que algo deu errado ao tentar atualizar os seus dados de Skype, tente novamente em <a href='settings.php'>Configurações</a>. Caso persista o erro, informe a nossa equipe através do
						e-mail <b>fhsrocha@gmail.com</b>. Desculpe o transtorno.
					</div>
					<?php } ?>

					<?php if(isset($_GET['access']) AND $_GET['access']=='denied'){ ?>
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<b>Acesso negado!</b> Apenas professores podem acessar o Estúdio de Criação.
						</div>
						<?php } ?>


						<div class="card">

							<ul class="tab-nav tn-justified">
								<li class="active waves-effect"><a href="index.php">Cursos</a></li>
								<li class="waves-effect"><a href="teachers.php">Professores</a></li>
								<li class="waves-effect"><a href="students.php">Alunos</a></li>
							</ul>


							<div class="card m-b-0" id="messages-main">

								<div class="ms-menu">
									<div class="ms-block">
										<div class="ms-user">
											<div class="f-18">Minhas inscrições</div>
										</div>
									</div>


									<div class="listview lv-user m-t-20">
										<?php if($totalRows_inscriptions!=0){ ?>

											<?php do {
												$course_subscriber = $row_inscriptions['courses_id_course'];
												$sql = "SELECT * FROM courses WHERE published='Y' AND id_course=$course_subscriber";
												$result_course_sub = mysql_query($sql,$connection) or die ("Error in table selection.");
										$row_course_sub = mysql_fetch_assoc($result_course_sub); // recebe os dados do result
										$totalRows_course_sub = mysql_num_rows($result_course_sub); // numero de registros encontrados
										?>
										<div class="lv-item media">
											<a href="course.php?id=<?php echo $row_course_sub['id_course']; ?>">
												<div class="lv-avatar bgm-red pull-left"><i class="fa fa-check"></i></div>
												<div class="media-body">
													<div class="lv-title"><?php echo $row_course_sub['name']; ?></div>
													<div class="lv-small">
														<?php if($row_course_sub['level']==1){
															echo "Iniciante";
														}
														else if($row_course_sub['level']==2){
															echo "Básico";
														}
														else if($row_course_sub['level']==3){
															echo "Intermediário";
														}
														else if($row_course_sub['level']==4){
															echo "Avançado";
														}
														else if($row_course_sub['level']==5){
															echo "Fluente";
														}
														?>
													</div>
												</div>
											</a>
										</div>
										<?php } while ($row_inscriptions = mysql_fetch_assoc($result_inscriptions)); ?>
										<?php }
										else { ?>
											<div class="text-center m-20">
												Você ainda não se inscreveu em nenhum curso.
											</div>
											<?php } ?>
										</div>


									</div>

									<div class="ms-body">


										<div class="listview lv-bordered lv-lg">


											<div class="lv-header-alt clearfix">
												<div class="lvh-label hidden-xs">
													<?php if(isset($_GET['level'])){

														if($totalRows_courses==1){
															echo '<b>'.$totalRows_courses.'</b> curso encontrado para o filtro ';
														}
														else{
															echo '<b>'.$totalRows_courses.'</b> cursos encontrados para o filtro ';
														}

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
														}
													}
													else if(isset($_POST['search_course']) AND $_POST['search_course']!=NULL ){
														if($totalRows_courses==1){
															echo '<b>'.$totalRows_courses.'</b> curso encontrado para a pesquisa [ <b>'.$search.'</b> ]. ';
														}
														else{
															echo '<b>'.$totalRows_courses.'</b> cursos encontrados para a pesquisa [ <b>'.$search.'</b> ]. ';
														}
														echo '<a href="index.php"><i class="zmdi zmdi-close-circle"></i></a>';
													}
													else{
														echo '<span class="f-18">Cursos</span>';
													}
													?>
												</div>

												<span class="dropdown pull-right">
													<a href="" class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="true">
														<i class="zmdi zmdi-filter-list"></i> Filtrar por nível
													</a>

													<ul class="dropdown-menu dropdown-menu-right">
														<li>
															<a href="index.php">Todos</a>
														</li>
														<li>
															<a href="index.php?level=1">Iniciantes</a>
														</li>
														<li>
															<a href="index.php?level=2">Básico</a>
														</li>
														<li>
															<a href="index.php?level=3">Intermediário</a>
														</li>
														<li>
															<a href="index.php?level=4">Avançado</a>
														</li>
														<li>
															<a href="index.php?level=5">Fluente</a>
														</li>
													</ul>
												</span>

											</div>

											<div class="lv-body">

												<?php if($totalRows_courses!=0){ ?>

													<?php do {

														$id_course = $row_courses['id_course'];
														//Pessoas que se increveram
														$sql = "SELECT * FROM inscription WHERE courses_id_course=$id_course";
														$result_subscribers = mysql_query($sql,$connection) or die ("Error in table selection.");
														$row_subscribers = mysql_fetch_assoc($result_subscribers);
														$totalRows_subscribers = mysql_num_rows($result_subscribers);

														?>
														<div class="lv-item media">
															<div class="media-body">
																<a href="course.php?id=<?php echo $row_courses['id_course']; ?>">
																	<div class="lv-title"><h4><div class="lv-avatar bgm-gray pull-left"><i class="fa fa-graduation-cap"></i></div> <?php echo $row_courses['name']; ?>
																	<br/>
																</h4>
																<?php if($row_courses['level']==1){
																	echo "<span class='badge bgm-blue'>Iniciante</span>";
																}
																else if($row_courses['level']==2){
																	echo "<span class='badge bgm-green'>Básico</span>";
																}
																else if($row_courses['level']==3){
																	echo "<span class='badge bgm-orange'>Intermediário</span>";
																}
																else if($row_courses['level']==4){
																	echo "<span class='badge bgm-red'>Avançado</span>";
																}
																else if($row_courses['level']==5){
																	echo "<span class='badge bgm-purple'>Fluente</span>";
																}
																?>
																<span class='badge bgm-gray'>
																	<?php echo $totalRows_subscribers;
																	if($totalRows_subscribers==1){
																		echo ' inscrito';
																	}
																	else{
																		echo ' inscritos';
																	}
																	?></span>
																</div>
															</a>
															<?php if($row_courses['users_id_user']==$id_logged AND $row_logged['type']=='T'){ ?>
																<div class="lv-actions actions dropdown">
																	<a href="" data-toggle="dropdown" aria-expanded="true">
																		<i class="zmdi zmdi-more-vert"></i>
																	</a>

																	<ul class="dropdown-menu dropdown-menu-right">
																		<li>
																			<a href="edit_course.php?id=<?php echo $row_courses['id_course']; ?>">Editar</a>
																		</li>
																		<li>
																			<a href="#" onclick="javascript: if (confirm('Essa ação é irreversível, tem certeza que deseja continuar?'))location.href='deletions.php?del_course=<?php echo $row_courses["id_course"]; ?>'">Excluir</a>
																		</li>
																	</ul>
																</div>
																<?php } ?>
															</div>
														</div>
														<?php } while ($row_courses = mysql_fetch_assoc($result_courses)); ?>

														<?php }
														else{ ?>
															<div class="jumbotron bgm-white">
																<p>Não encontramos nenhum curso :/</p>
															</div>
															<?php }?>
														</div>
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
