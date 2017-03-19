<?php require_once('../Connections/hellow.php');
include('verification.php');
include('verification_teacher.php');

$id_class = $_GET['id'];
$sql = "SELECT * FROM classes WHERE id_class=$id_class";
$result_class = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_class = mysql_fetch_assoc($result_class); // recebe os dados do result
$totalRows_class = mysql_num_rows($result_class); // numero de registros encontrados
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar <?php echo $row_class['name']; ?></title>

  <!-- Vendor CSS -->
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

  <section id="main">
    <?php include('menu-left.php'); ?>


    <section id="content">
      <div class="container">

<!-- Mensagens de alerta -->
<?php if(isset($_GET['update']) AND $_GET['update']=='erro'){ ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <b>Ops!</b> Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
    e-mail <b>fhsrocha@gmail.com</b>. Desculpe o transtorno.
  </div>
  <?php } ?>

        <div class="block-header">
          <h2>Editar Aula</h2>

          <ul class="actions">
            <li>
              <a href="#" class="icon-pop" id="conf-del">
                <i class="fa fa-trash"></i>
              </a>
            </li>
          </ul>

        </div>

        <div class="card">
          <form method="POST" name="update_class" id="update_class" action="updates.php" enctype="multipart/form-data">

            <div class="card-body card-padding">
              <div class="row m-b-20">
                <div class="form-group fg-float col-sm-6">
                  <div class="fg-line">
                    <input type="text" value="<?php echo $row_class['name']; ?>" name="class_name" id="class_name" class="form-control input-lg" maxlength="50" required>
                    <label class="fg-label">Nome da aula</label>
                  </div>
                </div>

                <div class="form-group col-sm-6">
                  <div class="toggle-switch">
                    <label for="published" class="ts-label">Publicar aula?</label>
                    <?php if($row_class['published']=='Y'){ ?>
                      <input id="published" name="published" type="checkbox" checked="checked" hidden="hidden" value="Y">
                      <?php }
                      else { ?>
                        <input id="published" name="published" type="checkbox" hidden="hidden" value="Y">
                        <?php } ?>
                        <label for="published" class="ts-helper"></label>
                      </div>
                    </div>

                  </div>


                  <div class="row m-b-20">
                    <div class="form-group fg-float col-sm-12">
                      <div class="fg-line">
                        <input type="text" value="<?php echo $row_class['tags']; ?>" name="tags" id="tags" class="form-control input-lg" maxlength="140">
                        <label class="fg-label">Palavras-chave</label>
                      </div>
                    </div>
                  </div>

                  <div class="row m-b-20">
                    <div class="form-group fg-float col-sm-12">
                      <div class="fg-line">
                        <input type="text" value="<?php echo $row_class['about']; ?>" name="about" id="about" class="form-control input-lg" maxlength="300" required>
                        <label class="fg-label">Apresentação, fale um pouco sobre essa aula.</label>
                      </div>
                    </div>
                  </div>

                  <div class="row m-b-20">
                    <div class="form-group fg-float col-sm-12">
                      <div class="fg-line">
                        <input type="text" value="<?php echo $row_class['link']; ?>" name="link" id="link" class="form-control input-lg" required>
                        <label class="fg-label">Link do vídeo no You Tube ou Vimeo</label>
                      </div>
                    </div>
                  </div>

                  <?php if($row_class['pdf']==NULL){ ?>
                    <div class="fileinput fileinput-new" data-provides="fileinput" id="select_pdf">
                      Material em PDF <i class="fa fa-file-pdf-o fa-lg"></i>
                      <span class="btn btn-primary btn-file m-r-10">
                        <span class="fileinput-new">Selecione um material</span>
                        <span class="fileinput-exists">Alterar</span>
                        <input type="file" name="pdf" id="pdf">
                      </span>
                      <span class="fileinput-filename"></span>
                      <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                    </div>
                    <?php }
                    else{ ?>
                      <input type="hidden" name="pdfa" value="<?php echo $row_class['pdf']; ?>">
                      <a href="uploads/pdf/<?php echo $row_class['pdf']; ?>" class="c-gray" target="_blank"><i class="fa fa-check c-green"></i> Material em PDF <i class="fa fa-file-pdf-o fa-lg"></i></a>
                      <a href="#" id="del-pdf" class="c-red"> Excluir/Alterar</a>
                      <?php }?>



                      <input type="hidden" name="update" value="update_class">
                      <input type="hidden" name="id_class" value="<?php echo $row_class['id_class']; ?>">
                      <input type="hidden" name="id_course" value="<?php echo $row_class['courses_id_course']; ?>">
                      <input type="hidden" name="id_teacher" value="<?php echo $row_course['courses_users_id_user']; ?>">
                      <input type="hidden" name="creation" value="<?php echo $row_class['creation']; ?>">

                      <div class="row m-20">
                        <div class="footer pull-right">
                          <button type="submit" class="btn btn-primary">Salvar</button>
                          <a href="course.php?id=<?php echo $row_class['courses_id_course']; ?>"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                      </div>

                    </div>
                  </form>
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
          <script src="vendors/bower_components/autosize/dist/autosize.min.js"></script>
          <script src="vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
          <script src="vendors/fileinput/fileinput.min.js"></script>

          <!-- Placeholder for IE9 -->
          <!--[if IE 9 ]>
          <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
          <![endif]-->

          <script src="js/functions.js"></script>
          <script src="js/demo.js"></script>

          <script type="text/javascript">
          //Confirmação de deleção
          $('#conf-del').click(function(){
            swal({
              title: "Você tem certeza?",
              text: "Você realmente deseja excluir essa aula?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sim, excluir!",
              closeOnConfirm: false
            }, function(){
              location.href='deletions.php?del_class=<?php echo $row_class["id_class"]; ?>&id_course=<?php echo $row_class["courses_id_course"]; ?>';
            });
          });

          //Confirmação de deleção/alteração de PDF
          $('#del-pdf').click(function(){
            swal({
              title: "Você tem certeza?",
              text: "O atual material em PDF será excuído.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sim, excluir!",
              closeOnConfirm: false
            }, function(){
              location.href='updates.php?id_class=<?php echo $row_class["id_class"]; ?>&pdf=<?php echo $row_class["pdf"]; ?>';
            });
          });
          </script>


        </body>
        </html>
