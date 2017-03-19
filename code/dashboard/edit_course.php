<?php require_once('../Connections/hellow.php');
include('verification.php');
include('verification_teacher.php');

$id_course = $_GET['id'];
$sql = "SELECT * FROM courses WHERE id_course=$id_course";
$result_course = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_course = mysql_fetch_assoc($result_course); // recebe os dados do result
$totalRows_course = mysql_num_rows($result_course); // numero de registros encontrados
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar <?php echo $row_course['name']; ?></title>

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
        <div class="block-header">
          <h2>Editar curso</h2>

          <ul class="actions">
            <li>
              <a href="#" class="icon-pop" id="conf-del">
                <i class="fa fa-trash"></i>
              </a>
            </li>
          </ul>

        </div>

        <div class="card">
          <form method="POST" name="update_course" id="update_course" action="updates.php">

            <div class="card-body card-padding">
              <div class="row m-b-20">
                <div class="form-group fg-float col-sm-6">
                  <div class="fg-line">
                    <input type="text" value="<?php echo $row_course['name']; ?>" name="course_name" id="course_name" class="form-control input-lg" maxlength="50" required>
                    <label class="fg-label">Nome do curso</label>
                  </div>
                </div>

                <div class="input-group form-group col-sm-6">
                  <span class="input-group-addon"><i class="zmdi zmdi-sort-amount-asc"></i></span>
                  <div class="dtp-container fg-line">
                    <select class="selectpicker input-lg" name="level" id="level">
                      <option value="1" <?php if($row_course['level']==1) echo 'selected'; ?> >Iniciante</option>
                      <option value="2" <?php if($row_course['level']==2) echo 'selected'; ?> >Básico</option>
                      <option value="3" <?php if($row_course['level']==3) echo 'selected'; ?> >Intermediário</option>
                      <option value="4" <?php if($row_course['level']==4) echo 'selected'; ?> >Avançado</option>
                      <option value="5" <?php if($row_course['level']==5) echo 'selected'; ?> >Fluente</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row m-b-20">
                <div class="form-group fg-float col-sm-6">
                  <div class="fg-line">
                    <input type="text" value="<?php echo $row_course['tags']; ?>" name="tags" id="tags" class="form-control input-lg" maxlength="140">
                    <label class="fg-label">Palavras-chave</label>
                  </div>
                </div>


                <div class="form-group col-sm-6">
                  <div class="toggle-switch">
                    <label for="published" class="ts-label">Publicar curso?</label>
                    <?php if($row_course['published']=='Y'){ ?>
                      <input id="published" name="published" type="checkbox" checked="checked" hidden="hidden" value="Y">
                      <?php }
                      else { ?>
                        <input id="published" name="published" type="checkbox" hidden="hidden" value="Y">
                        <?php } ?>
                        <label for="published" class="ts-helper"></label>
                      </div>
                    </div>

                  </div>

                  <div class="form-group fg-float">
                    <div class="fg-line">
                      <input type="text" value="<?php echo $row_course['about']; ?>" name="about" id="about" class="form-control input-lg" maxlength="300" required>
                      <label class="fg-label">Apresentação, fale um pouco sobre o curso.</label>
                    </div>
                  </div>

                  <input type="hidden" name="update" value="update_course">
                  <input type="hidden" name="id_course" value="<?php echo $row_course['id_course']; ?>">
                  <input type="hidden" name="id_teacher" value="<?php echo $row_course['users_id_user']; ?>">
                  <input type="hidden" name="creation" value="<?php echo $row_course['creation']; ?>">

                  <div class="footer m-20">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="studio.php"><button type="button" class="btn btn-default">Cancelar</button></a>
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
          location.href='deletions.php?del_course=<?php echo $row_course["id_course"]; ?>';
        });
      });

      </script>


    </body>
    </html>
