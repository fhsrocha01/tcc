<?php require_once('../Connections/hellow.php');
include('verification.php');

//Seleciona de acordo com o id recebido via GET
if(isset($_GET['id']) && $_GET['id']!=""){
	$id=$_GET['id'];
	$sql = "SELECT * FROM users WHERE id_user=$id";
	$result = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_user = mysql_fetch_assoc($result); // recebe os dados do result
	$totalRows_user = mysql_num_rows($result); // numero de registros encontrados

	if($row_user['type']=='T'){
		$sql = "SELECT * FROM courses WHERE published='Y' AND users_id_user=$id";
		$result_courses = mysql_query($sql,$connection) or die ("Error in table selection.");
		$row_courses = mysql_fetch_assoc($result_courses);
		$totalRows_courses = mysql_num_rows($result_courses);
	}
	else{
		//verifica os cursos que o aluno está inscrito
		$sql = "SELECT * FROM inscription WHERE users_id_user=$id";
		$result_inscriptions = mysql_query($sql,$connection) or die ("Error in table selection.");
		$row_inscriptions = mysql_fetch_assoc($result_inscriptions);
		$totalRows_inscriptions = mysql_num_rows($result_inscriptions);
	}

	//Pessoas que favoritaram
	$sql = "SELECT * FROM favorite WHERE id_favorite=$id";
	$result_favorite = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_favorite = mysql_fetch_assoc($result_favorite);
	$totalRows_favorite = mysql_num_rows($result_favorite);

	//Verifica se o usuário logado favoritou
	$id_favorited = $_SESSION['id_user'];
	$sql = "SELECT * FROM favorite WHERE users_id_user=$id_favorited AND id_favorite=$id";
	$result_favorited = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_favorited = mysql_fetch_assoc($result_favorited);
	$totalRows_favorited = mysql_num_rows($result_favorited);

	//verifica se o usuario que está logado já denunciou
	$id_user_logged = $_SESSION['id_user'];
	$sql = "SELECT * FROM complaint WHERE id_user_denounced='$id' AND users_id_user='$id_user_logged'";
	$result_denounced = mysql_query($sql,$connection) or die ("Error in table selection.");
	$totalRows_denounced = mysql_num_rows($result_denounced);

}

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $row_user['name']; ?></title>

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

		<?php include('menu-left.php'); ?>

		<section id="content">
			<div class="container">

				<!-- Mensagens de alerta -->
				<?php if ((isset($_GET["complaint"])) && ($_GET["complaint"] == "success")) { ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<b>Feito!</b> Sua denúnica foi recebida com sucesso. Obrigado por contribuir com
						a comunidade, ajudando a manter a ordem.
					</div>
					<?php } ?>


<?php if($totalRows_denounced == 0 AND ($id_logged!=$_GET['id'])){ ?>
				<div class="block-header">

					<ul class="actions">
						<li>
							<a data-toggle="modal" href="#preventClick"><i class="zmdi zmdi-block"></i></a>
						</li>
					</ul>

					<div class="modal fade" id="preventClick" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="POST" name="insert_complaint" id="insert_complaint" action="inserts.php" enctype="multipart/form-data">
									<div class="modal-header bgm-blue m-b-20">
										<h4 class="modal-title c-white"><i class="zmdi zmdi-block"></i> Denúnciar spam</h4>
									</div>
									<div class="modal-body">
										<p class="text-justify">
											Este usuário está incomodando você ou postanto conteúdos que não se referem ao aprendizado de inglês?
											Ajude a comunidade fazendo uma denúncia, assim podemos controlar e evitar "engraçadinhos".
										</p>
										<div class="input-group form-group m-b-20">
											<span class="input-group-addon"><i class="zmdi zmdi-comment-text"></i></span>
											<div class="dtp-container fg-line">
												<textarea class="form-control" name="message" id="message" rows="3" placeholder="Descreva o que está acontecendo." maxlength="300" required></textarea>
											</div>
										</div>

										<input type="hidden" name="complaint" value="user_complaint">
										<input type="hidden" name="id_denounced" value="<?php echo $row_user['id_user']; ?>">
										<input type="hidden" name="id_user" value="<?php echo $id_logged; ?>">

									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Enviar denúncia</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
				<?php } ?>

				<?php if($row_user['active']!='N'){ ?>

					<div class="card">
						<div class="row">
							<div class="col-sm-4">
								<!-- Profile view -->
								<div class="profile-view">
									<div class="pv-header">
										<?php if($row_user['photo']==NULL){ ?>
											<img src="img/profile-pics/user-default.jpg" class="pv-main" alt="Foto de perfil <?php echo $row_user['name']; ?>">
											<?php }
											else { ?>
												<img src="img/profile-pics/<?php echo $row_user['photo']; ?>" class="pv-main" alt="Foto de perfil <?php echo $row_user['name']; ?>">
												<?php } ?>
											</div>
											<div class="pv-body">
												<h2><?php echo $row_user['name']; ?></h2>
												<?php if($row_user['type']=='T'){ ?>
													<small>Teacher</small>
													<?php }
													else { ?>
														<small>
															<?php if($row_user['level']==1){
																echo "<span class='badge bgm-blue'>Iniciante</span>";
															}
															else if($row_user['level']==2){
																echo "<span class='badge bgm-green'>Básico</span>";
															}
															else if($row_user['level']==3){
																echo "<span class='badge bgm-orange'>Intermediário</span>";
															}
															else if($row_user['level']==4){
																echo "<span class='badge bgm-red'>Avançado</span>";
															}
															else if($row_user['level']==5){
																echo "<span class='badge bgm-purple'>Fluente</span>";
															}
															?>
														</small>
														<?php } ?>

														<ul class="pv-contact">
															<?php if($totalRows_favorited==0){ ?>
																<li class="f-20"><a href="inserts.php?user=<?php echo $id_logged; ?>&favorite=<?php echo $row_user['id_user']; ?>"><i class="fa fa-heart-o fa-lg c-red" data-toggle="tooltip" data-placement="top" title="Favoritar"></i></a> <?php echo $totalRows_favorite; ?></li>
																<?php }
																else { ?>
																	<li class="f-20"><a href="deletions.php?user=<?php echo $id_logged; ?>&favorite=<?php echo $row_user['id_user']; ?>"><i class="fa fa-heart fa-lg c-red" data-toggle="tooltip" data-placement="top" title="Desfavoritar"></i></a> <?php echo $totalRows_favorite; ?></li>
																	<?php } ?>
																</ul>

																<?php if($row_user['type']=='T' AND $row_user['lessons_skype']=='Y' AND $row_user['skype']!=NULL ){ ?>
																	<button class="btn btn-primary btn-lg" data-toggle="collapse" data-target="#skype" aria-expanded="false" aria-controls="skype"><i class="fa fa-skype"></i> Aula via Skype</button>
																	<div class="collapse m-t-10" id="skype">
																		<p><span class="f-20"><i class="fa fa-skype c-blue"></i> <?php echo $row_user['skype']; ?></span>
																			<br/>
																			<span class="f-18">
																				<?php if($row_user['lesson_price']==NULL OR $row_user['lesson_price']=='0,00' ){
																					echo 'Aulas <span class="c-green">Grátis!</span>';
																				}
																				else{
																					echo $row_user['lesson_price'].'<br/>a cada 30 minutos de aula.';
																				} ?>
																			</span>
																			<br/>
																			Adicione <?php echo $row_user['name']; ?> no Skype e marque uma aula!
																		</p>
																	</div>
																	<?php } ?>
																	<?php if($row_user['type']=='S' AND $row_user['lessons_skype']=='Y' AND $row_user['skype']!=NULL ){ ?>
																		<button class="btn btn-primary btn-lg" data-toggle="collapse" data-target="#skype" aria-expanded="false" aria-controls="skype"><i class="fa fa-skype"></i> Praticar inglês</button>
																		<div class="collapse m-t-10" id="skype">
																			<p><span class="f-20"><i class="fa fa-skype c-blue"></i> <?php echo $row_user['skype']; ?></span>
																				<br/>
																				Adicione <?php echo $row_user['name']; ?> no Skype e convide ele para praticar inglês com você!
																			</p>
																		</div>
																		<?php } ?>
																	</div>
																</div>
															</div>

															<div class="col-sm-8">

																<?php if($row_user['type']=='T') { ?>
																	<ul class="tab-nav tn-justified">
																		<li class="active waves-effect"><a href="profile.php?id=<?php echo $row_user['id_user']; ?>">Cursos</a></li>
																		<li class="waves-effect"><a href="profile_reviews.php?id=<?php echo $row_user['id_user']; ?>">Avaliações</a></li>
																	</ul>
																	<?php } ?>

																	<div class="listview lv-bordered lv-lg">

																		<div class="lv-body">

																			<!-- Se for o perfil de um professor -->
																			<?php if( $row_user['type']=='T' AND $totalRows_courses!=0){ ?>

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
																								<div class="lv-title"><h4><div class="lv-avatar bgm-gray pull-left"><i class="fa fa-video-camera"></i></div> <?php echo $row_courses['name']; ?>
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
																							<?php if($id_logged==$row_courses['users_id_user']){ ?>
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

																						// se o perfil for de um aluno
																						else if( $row_user['type']=='S' AND $totalRows_inscriptions!=0){ ?>

																							<p class="f-20 m-20"><?php echo $row_user['name']; ?> está inscrito em:</p>

																							<?php do {
																								$course_subscriber = $row_inscriptions['courses_id_course'];
																								$sql = "SELECT * FROM courses WHERE published='Y' AND id_course=$course_subscriber";
																								$result_course_sub = mysql_query($sql,$connection) or die ("Error in table selection.");
																								$row_course_sub = mysql_fetch_assoc($result_course_sub); // recebe os dados do result
																								$totalRows_course_sub = mysql_num_rows($result_course_sub); // numero de registros encontrados
																								?>
																								<div class="lv-item media">
																									<div class="media-body">
																										<a href="course.php?id=<?php echo $row_course_sub['id_course']; ?>">
																											<div class="lv-title"><h4><div class="lv-avatar bgm-gray pull-left"><i class="fa fa-video-camera"></i></div> <?php echo $row_course_sub['name']; ?>
																												<br/>
																											</h4>
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
																									<?php if($id_logged==$row_inscriptions['courses_users_id_user']){ ?>
																										<div class="lv-actions actions dropdown">
																											<a href="" data-toggle="dropdown" aria-expanded="true">
																												<i class="zmdi zmdi-more-vert"></i>
																											</a>

																											<ul class="dropdown-menu dropdown-menu-right">
																												<li>
																													<a href="edit_course.php?id=<?php echo $row_course_sub['id_course']; ?>">Editar</a>
																												</li>
																												<li>
																													<a href="#" onclick="javascript: if (confirm('Essa ação é irreversível, tem certeza que deseja continuar?'))location.href='deletions.php?del_course=<?php echo $row_course_sub["id_course"]; ?>'">Excluir</a>
																												</li>
																											</ul>
																										</div>
																										<?php } ?>
																									</div>
																								</div>
																								<?php } while ($row_inscriptions = mysql_fetch_assoc($result_inscriptions)); ?>

																								<?php }

																								else if( $row_logged['type']=='T' AND $row_user['id_user']==$id_logged){ ?>
																									<div class="jumbotron bgm-white">
																										<h3>Olá <?php echo $row_logged['name']; ?>!</h3>
																										<p>Você ainda não criou nenhum curso, vamos comecar? Acesse o estúdio de criação e crie seu primeiro curso!</p>
																										<p><a href="studio.php" class="btn btn-primary btn-lg">Estúdio de criação</a></p>
																									</div>
																									<?php }
																									else if($row_user['type']=='T') { ?>
																										<div class="jumbotron bgm-white">
																											<p>Esse professor ainda não publicou nenhuma vídeo aula.</p>
																										</div>
																										<?php }
																										else if($row_logged['type']=='S' AND $row_user['id_user']==$id_logged) { ?>
																											<div class="jumbotron bgm-white">
																												<p>Você ainda não se inscreveu em nenhum curso.</p>
																											</div>
																											<?php }
																											else { ?>
																												<div class="jumbotron bgm-white">
																													<p>Esse aluno ainda não se inscreveu em nenhum curso.</p>
																												</div>
																												<?php }?>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																							<?php }
																							else{ ?>
																								<div class="card">
																									<div class="jumbotron bgm-white">
																										<p>Esse usuário foi bloqueado devido as recorrentes reclamações que recebeu.</p>
																									</div>
																								</div>
																								<?php }?>
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

																			<script src="js/functions.js"></script>


																		</body>
																		</html>
