<?php require_once('../Connections/hellow.php');
include('verification.php');
$id_course = $_GET['id'];
$sql = "SELECT * FROM courses WHERE id_course=$id_course";
$result_course = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_course = mysql_fetch_assoc($result_course); // recebe os dados do result
$totalRows_course = mysql_num_rows($result_course); // numero de registros encontrados

$sql = "SELECT * FROM inscription WHERE courses_id_course=$id_course";
$result_subscribers = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_subscribers = mysql_fetch_assoc($result_subscribers);
$totalRows_subscribers = mysql_num_rows($result_subscribers);

$id_teacher = $row_course['users_id_user'];
$sql = "SELECT * FROM users WHERE id_user=$id_teacher";
$result_teacher = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_teacher = mysql_fetch_assoc($result_teacher);

if($_SESSION['id_user']==$row_teacher['id_user']){
	$sql = "SELECT * FROM classes WHERE courses_id_course=$id_course ORDER BY id_class ASC";
	$result_class = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_class = mysql_fetch_assoc($result_class);
	$totalRows_class = mysql_num_rows($result_class);
}
else{
	$sql = "SELECT * FROM classes WHERE courses_id_course=$id_course AND published='Y' ORDER BY id_class ASC";
	$result_class = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_class = mysql_fetch_assoc($result_class);
	$totalRows_class = mysql_num_rows($result_class);
}

//Pessoas que se increveram
$sql = "SELECT * FROM inscription WHERE courses_id_course=$id_course";
$result_subscribers = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_subscribers = mysql_fetch_assoc($result_subscribers);
$totalRows_subscribers = mysql_num_rows($result_subscribers);

//Verifica se o usuário logado se increveu
$id_subscriber = $_SESSION['id_user'];
$sql = "SELECT * FROM inscription WHERE users_id_user=$id_subscriber AND courses_id_course=$id_course";
$result_subscriber = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_subscriber = mysql_fetch_assoc($result_subscriber);
$totalRows_subscriber = mysql_num_rows($result_subscriber);

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $row_course['name']; ?></title>

	<!-- Vendor CSS -->
	<link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
	<link href="vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
	<link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
	<link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
	<link href="vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
	<link href="vendors/bower_components/lightgallery/light-gallery/css/lightGallery.css" rel="stylesheet">
	<link href="vendors/bower_components/mediaelement/build/mediaelementplayer.css" rel="stylesheet">


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

				<!-- Mensagens de alerta -->
				<?php if(isset($_GET['update_class']) AND $_GET['update_class']=='success'){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<b>Sucesso!</b> As alterações foram salvas.
					</div>
					<?php } ?>

					<?php if(isset($_GET['insert']) AND $_GET['insert']=='success'){ ?>
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<b>Sucesso!</b> Sua aula foi cadastrada.
						</div>
						<?php } ?>

						<?php if(isset($_GET['del_class']) AND $_GET['del_class']=='success'){ ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<b>Deletada!</b> A aula foi deletada com sucesso.
							</div>
							<?php } ?>


							<?php if(isset($_GET['update_class']) AND $_GET['update_class']=='erro'){ ?>
								<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<b>Ops!</b> Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
									e-mail <b>fhsrocha@gmail.com</b>. Desculpe o transtorno.
								</div>
								<?php } ?>

								<?php if($totalRows_class!=0 && $id_logged==$id_teacher){ ?>
									<button class="btn btn-float btn-success m-btn hidden-lg hidden-md hidden-sm" data-toggle="modal" href="#preventClick" title="Nova aula"><i class="zmdi zmdi-plus"></i></button>
									<?php } ?>

									<div class="row">
										<div class="col-sm-9">

											<div class="card">
												<div class="listview lv-bordered lv-lg">


													<div class="lv-header-alt clearfix">
														<div class="lvh-label f-18"><div class="lv-avatar bgm-blue pull-left"><i class="fa fa-graduation-cap"></i></div> <?php echo $row_course['name']; ?></div>

														<?php if($id_logged!=$id_teacher AND $id_logged!=$row_subscriber['users_id_user']){ ?>
															<a href="inserts.php?subscribe=<?php echo $id_logged; ?>&teacher=<?php echo $id_teacher; ?>&course=<?php echo $row_course['id_course']; ?>" class="btn btn-danger pull-right"><i class="fa fa-check"></i> Inscrever-se</a>
															<?php }
															else if($id_logged!=$id_teacher AND $id_logged==$row_subscriber['users_id_user']){ ?>
																<a href="deletions.php?subscribe=<?php echo $id_logged; ?>&course=<?php echo $row_course['id_course']; ?>" class="btn btn-default pull-right"><i class="fa fa-check c-red"></i> Inscrito</a>
																<?php }
																else { ?>
																	<a data-toggle="modal" href="#preventClick" class="btn btn-success btn-icon-text hidden-xs pull-right"><i class="zmdi zmdi-plus"></i> Nova aula</a>
																	<?php } ?>

																</div>

																<div class="lv-body">

																	<?php if($totalRows_class!=0){
																		do { ?>
																			<div class="lv-item media">
																				<div class="media-body">
																					<div class="lightbox">
																						<div data-src="<?php echo $row_class['link']; ?>" data-sub-html="<em><h3><?php echo $row_class['name']; ?></h3><p><?php echo $row_class['about']; ?></p></em>">

																							<div class="lvh-label f-18"><div class="lv-avatar bgm-red pull-left"><i class="fa fa-video-camera"></i></div> <?php echo $row_class['name']; ?></div>
																						</div>
																					</div>
																					<?php if($id_logged==$id_teacher){ ?>
																						<div class="lv-actions actions dropdown">
																							<a href="" data-toggle="dropdown" aria-expanded="true">
																								<i class="zmdi zmdi-more-vert"></i>
																							</a>
																							<ul class="dropdown-menu dropdown-menu-right">
																								<li>
																									<a href="edit_class.php?id=<?php echo $row_class['id_class']; ?>">Editar</a>
																								</li>
																								<li>
																									<a href="#" onclick="javascript: if (confirm('Essa ação é irreversível, tem certeza que deseja excluir essa aula?'))location.href='deletions.php?del_class=<?php echo $row_class["id_class"]; ?>&id_course=<?php echo $row_course["id_course"]; ?>'">Excluir</a>
																								</li>
																							</ul>
																						</div>
																						<?php } ?>

																						<!-- Se tiver um material em PDF disponível   -->
																						<?php if($row_class['pdf']!=NULL){ ?>
																							<span class="pull-right"><a href='uploads/pdf/<?php echo $row_class['pdf']; ?>' target='_blank'><i class="fa fa-file-pdf-o fa-2x" data-toggle="tooltip" data-placement="left" title="Material disponível em PDF!"></i></a></span>
																							<?php } ?>

																						</div>
																					</div>
																					<?php } while ($row_class = mysql_fetch_assoc($result_class)); ?>

																					<?php }
																					else{ ?>
																						<div class="jumbotron bgm-white">
																							<p>Este curso ainda não possui nenhuma aula publicada.
																								<?php if($id_logged==$row_teacher['id_user']){ ?>
																									<a data-toggle="modal" href="#preventClick" class="btn btn-success btn-lg">Criar aula</a>
																									<?php } ?>
																								</p>
																							</div>
																							<?php } ?>
																						</div>
																					</div>
																				</div>

																			</div>

																			<div class="col-sm-3">
																				<div class="card">
																					<div class="card-header">
																						<a href="profile.php?id=<?php echo $row_teacher['id_user']; ?>">
																							<div class="media">
																								<div class="pull-left">
																									<?php if($row_teacher['photo']==NULL){ ?>
																										<img class="lv-img" src="img/profile-pics/user-default.jpg" alt="Foto de perfil <?php echo $row_teacher['name']; ?>">
																										<?php }
																										else { ?>
																											<img class="lv-img" src="img/profile-pics/<?php echo $row_teacher['photo']; ?>" alt="Foto de perfil <?php echo $row_teacher['name']; ?>">
																											<?php } ?>
																										</div>

																										<div class="media-body m-t-5">
																											<h2><?php echo $row_teacher['name']; ?> <small>Teacher</small></h2>
																										</div>
																									</div>
																								</a>
																							</div>
																							<div class="card-body card-padding">
																								<p class="text-justify"><?php echo $row_course['about']; ?></p>
																							</div>
																						</div>
																					</div>
																				</div>

																			</div>

																			<div class="modal fade" id="preventClick" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
																				<div class="modal-dialog">
																					<div class="modal-content">
																						<form method="POST" name="insert_class" id="insert_class" action="inserts.php" enctype="multipart/form-data">
																							<div class="modal-header bgm-blue m-b-20">
																								<h4 class="modal-title c-white"><i class="zmdi zmdi-plus-circle"></i> Nova aula</h4>
																							</div>
																							<div class="modal-body">

																								<div class="row">
																									<div class="col-sm-6">

																										<div class="input-group form-group m-b-20">
																											<span class="input-group-addon"><i class="zmdi zmdi-videocam"></i></span>
																											<div class="dtp-container fg-line">
																												<input type='text' name="name" id="name" class="form-control" placeholder="Título da aula" maxlength="50" required>
																											</div>
																										</div>
																									</div>

																									<div class="col-sm-6">
																										<div class="input-group form-group m-b-20">
																											<span class="input-group-addon"><i class="zmdi zmdi-eye"></i></span>
																											<div class="dtp-container fg-line">
																												<select class="selectpicker" name="published" id="published">
																													<option value="Y">Publicar agora</option>
																													<option value="N">Publicar mais tarde</option>
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
																										<textarea class="form-control" name="about" id="about" rows="3" placeholder="Descrição da aula." maxlength="300" required></textarea>
																									</div>
																								</div>

																								<div class="input-group form-group m-b-20">
																									<span class="input-group-addon"><i class="zmdi zmdi-share"></i></span>
																									<div class="dtp-container fg-line">
																										<input class="form-control" name="link" id="link" placeholder="Link do vídeo no You Tube ou Vimeo." required />
																									</div>
																								</div>

																								<div class="checkbox m-b-15">
																									<label>
																										Disponibilizar material em PDF.
																										<input type="checkbox" id="show_input" name="show_input" value="Y">
																										<i class="input-helper"></i>
																									</label>
																								</div>

																								<div class="fileinput fileinput-new" data-provides="fileinput" id="select_pdf">
																									<span class="btn btn-primary btn-file m-r-10">
																										<span class="fileinput-new">Selecione um material</span>
																										<span class="fileinput-exists">Alterar</span>
																										<input type="file" name="pdf" id="pdf">
																									</span>
																									<span class="fileinput-filename"></span>
																									<a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
																								</div>


																								<input type="hidden" name="insert" value="insert_class">
																								<input type="hidden" name="id_course" value="<?php echo $row_course['id_course']?>">
																								<input type="hidden" name="id_user" value="<?php echo $row_course['users_id_user']?>">

																							</div>
																							<div class="modal-footer">
																								<button type="submit" class="btn btn-primary">Salvar</button>
																								<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																							</div>
																						</form>
																					</div>
																				</div>
																			</div>

																		</section>
																	</section>

																	<?php include('footer.php'); ?>


																	<!-- Javascript Libraries -->
																	<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
																	<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

																	<script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
																	<script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
																	<script src="vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
																	<script src="vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
																	<script src="vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
																	<script src="vendors/bower_components/lightgallery/light-gallery/js/lightGallery.min.js"></script>
																	<script src="vendors/bower_components/mediaelement/build/mediaelement-and-player.min.js"></script>
																	<script src="vendors/fileinput/fileinput.min.js"></script>


																	<!-- Placeholder for IE9 -->
																	<!--[if IE 9 ]>
																	<script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
																	<![endif]-->

																	<script src="js/functions.js"></script>

																	<!-- Mostrar div para input PDF -->
																	<script type="text/javascript">
																	$(document).ready(function(){
																		$("#select_pdf").hide();
																		$('#show_input').change(function(){
																			if(this.checked){
																				$('#select_pdf').fadeIn('slow');
																			}
																			else{
																				$('#select_pdf').fadeOut('slow');

																			}

																		});
																	});
																	</script>



																</body>
																</html>
