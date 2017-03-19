<?php require_once('../Connections/hellow.php');
include('verification.php');
include('verification_teacher.php');
$id_teacher = $_SESSION['id_user'];
$sql = "SELECT * FROM courses WHERE users_id_user=$id_teacher ORDER BY id_course DESC";
$result_courses = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_courses = mysql_fetch_assoc($result_courses); // recebe os dados do result
$totalRows_courses = mysql_num_rows($result_courses); // numero de registros encontrados

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Estúdio de criação - We Learn</title>

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

				<?php if(isset($_GET['deletion']) && $_GET['deletion']=='success'){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<b>Deletado!</b> O curso selecionado foi deletado com sucesso!
					</div>
					<?php } ?>

					<?php if(isset($_GET['update']) && $_GET['update']=='success'){ ?>
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<b>Sucesso!</b> As alterações foram salvas.
						</div>
						<?php } ?>

						<?php if(isset($_GET['insert']) && $_GET['insert']=='success'){ ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<b>Sucesso!</b> Seu curso foi criado, mais ainda não foi publicado. Após criar as aulas e fazer todos os ajustes, publique ele para que seus alunos tenham acesso.
							</div>
							<?php } ?>

						<?php if(isset($_GET['update']) AND $_GET['update']=='erro'){ ?>
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<b>Ops!</b> Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
								e-mail <b>fhsrocha@gmail.com</b>. Desculpe o transtorno.
							</div>
							<?php } ?>


							<?php if($totalRows_courses!=0 && $row_logged['type']=='T'){ ?>
								<button class="btn btn-float btn-success m-btn hidden-lg hidden-md hidden-sm" data-toggle="modal" href="#preventClick" title="Novo curso"><i class="zmdi zmdi-plus"></i></button>
								<?php } ?>

								<div class="card">

									<div class="card">
										<div class="listview lv-bordered lv-lg">


											<div class="lv-header-alt clearfix">
												<h2 class="lvh-label">Estúdio de criação</h2>
												<?php if($totalRows_courses!=0){ ?>
													<h2 class="lvh-label pull-right hidden-xs"><a data-toggle="modal" href="#preventClick" class="btn btn-success btn-icon-text"><i class="zmdi zmdi-plus"></i> Novo curso</a></h2>
													<?php } ?>
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
																		<div class="lv-title"><h4><?php echo $row_courses['name']; ?></h4></div>
																		<ul class="lv-attrs">
																			<li><?php if($row_courses['published']=='Y'){
																				echo "Publicado <span class='c-green'><i class='fa fa-check'></i></span>";
																			} else{
																				echo "Não publicado <span class='c-red'><i class='fa fa-ban'></i></span>";
																			}  ?></li>
																			<li><?php if($row_courses['level']==1){
																				echo "Iniciante";
																			} else if($row_courses['level']==2){
																				echo "Básico";
																			} else if($row_courses['level']==3){
																				echo "Intermediário";
																			} else if($row_courses['level']==4){
																				echo "Avançado";
																			} else if($row_courses['level']==5){
																				echo "Fluente";
																			} ?></li>
																			<li data-toggle="tooltip" data-placement="top" title="Inscritos"><i class="fa fa-users"></i> <?php echo $totalRows_subscribers; ?></li>
																		</ul>
																	</a>

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
																</div>
															</div>
															<?php } while ($row_courses = mysql_fetch_assoc($result_courses)); ?>

															<?php }
															else{ ?>
																<div class="jumbotron bgm-white">
																	<h3>Olá <?php echo $row_logged['name']; ?>!</h3>
																	<p>Você ainda não criou nenhum curso, vamos começar?</p>
																	<p><a data-toggle="modal" href="#preventClick" class="btn btn-success btn-lg">Criar curso</a></p>
																</div>
																<?php }?>
															</div>
														</div>

													</div>

												</div>

												<div class="modal fade" id="preventClick" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<form method="POST" name="insert_course" id="insert_course" action="inserts.php">
																<div class="modal-header bgm-blue m-b-20">
																	<h4 class="modal-title c-white"><i class="zmdi zmdi-plus-circle"></i> Novo curso</h4>
																</div>
																<div class="modal-body">
																	<div class="row">
																		<div class="col-sm-6">

																			<div class="input-group form-group m-b-20">
																				<span class="input-group-addon"><i class="zmdi zmdi-folder"></i></span>
																				<div class="dtp-container fg-line">
																					<input type='text' name="course_name" id="course_name" class="form-control" placeholder="Nome do curso" maxlength="50" required>
																				</div>
																			</div>
																		</div>

																		<div class="col-sm-6">
																			<div class="input-group form-group m-b-20">
																				<span class="input-group-addon"><i class="zmdi zmdi-sort-amount-asc"></i></span>
																				<div class="dtp-container fg-line">
																					<select class="selectpicker" name="level" id="level">
																						<option value="1">Iniciante</option>
																						<option value="2">Básico</option>
																						<option value="3">Intermediário</option>
																						<option value="4">Avançado</option>
																						<option value="5">Fluente</option>
																					</select>
																				</div>
																			</div>
																		</div>
																	</div>

																	<div class="input-group form-group m-b-20">
																		<span class="input-group-addon"><i class="zmdi zmdi-tag"></i></span>
																		<div class="dtp-container fg-line">
																			<input type="text" name="tags" id="tags" class="form-control" placeholder="Palavras-chave" maxlength="140"/>
																		</div>
																	</div>

																	<div class="input-group form-group m-b-20">
																		<span class="input-group-addon"><i class="zmdi zmdi-comment-text"></i></span>
																		<div class="dtp-container fg-line">
																			<textarea class="form-control" name="about" id="about" rows="3" placeholder="Faça uma apresentação do curso. Seja criativo! Você tem 300 caractéres." maxlength="300" required></textarea>
																		</div>
																	</div>

																</div>
																<div class="modal-footer">
																	<button type="submit" class="btn btn-primary">Salvar</button>
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																</div>
															</form>
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
