<?php require_once('../Connections/hellow.php');
include('verification.php');

$id_user = $_SESSION['id_user'];
$sql = "SELECT * FROM users WHERE id_user=$id_user";
$result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_user = mysql_fetch_assoc($result_user);
$totalRows_user = mysql_num_rows($result_user);
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Configurações de conta</title>

  <!-- Vendor CSS -->
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

  <?php include('header.php'); 	?>
  <section id="main">
    <?php include('menu-left.php'); ?>

    <section id="content">
      <div class="container">

        <!-- Mensagens de alerta -->
        <?php if(isset($_GET['extension']) AND $_GET['extension']=='erro'){ ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <b>Ops!</b> Você pode enviar apenas arquivos (.jpg, .jpeg, .png ou .gif). Selecione um arquivo válido e tente novamente.
          </div>
          <?php } ?>

          <?php if(isset($_GET['update']) AND $_GET['update']=='erro'){ ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <b>Ops!</b> Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
              e-mail <b>fhsrocha@gmail.com</b>. Desculpe o transtorno.
            </div>
            <?php } ?>

          <?php if(isset($_GET['photo']) AND $_GET['photo']=='success'){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <b>Sucesso!</b> Sua foto de perfil foi atualizada.
            </div>
            <?php } ?>

            <?php if(isset($_GET['update']) AND $_GET['update']=='success'){ ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <b>Sucesso!</b> As alterações foram salvas.
              </div>
              <?php } ?>

              <?php if(isset($_GET['update']) AND $_GET['update']=='password'){ ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <b>Sucesso!</b> Sua senha foi alterada.
                </div>
                <?php } ?>

                <div class="block-header">
                  <h2>Configurações</h2>
                </div>

                <div class="card" id="profile-main">
                  <div class="pm-overview c-overflow">

                    <div class="text-center m-20">
                      <div class="fileinput fileinput-new" id="select_photo" data-provides="fileinput">
                        <form method="post" enctype="multipart/form-data" action="updates.php">
                          <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                            <?php if($row_user['photo']==NULL){ ?>
                              <img class="img-responsive" src="img/profile-pics/user-default.jpg" alt="Alterar foto">
                              <?php }
                              else{ ?>
                                <img class="img-responsive" src="img/profile-pics/<?php echo $row_user['photo']; ?>" alt="Alterar foto">
                                <?php }?>
                              </div>
                              <div>
                                <span class="btn btn-info btn-file">
                                  <span class="fileinput-new m-5"><i class="fa fa-camera"></i> Alterar foto</span>
                                  <span class="fileinput-exists m-5">Selecionar outra</span>
                                  <input type="file" name="arquivo">
                                </span>

                                <input type="hidden" name="id_user" value="<?php echo $row_user['id_user']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row_user['name']; ?>">
                                <input type="hidden" name="email" value="<?php echo $row_user['email']; ?>">
                                <input type="hidden" name="password" value="<?php echo $row_user['password']; ?>">
                                <input type="hidden" name="type" value="<?php echo $row_user['type']; ?>">
                                <input type="hidden" name="level" value="<?php echo $row_user['level']; ?>">
                                <input type="hidden" name="skype" value="<?php echo $row_user['skype']; ?>">
                                <input type="hidden" name="lesson_price" value="<?php echo $row_user['lesson_price']; ?>">
                                <input type="hidden" name="lessons_skype" value="<?php echo $row_user['lessons_skype']; ?>">
                                <input type="hidden" name="registration_date" value="<?php echo $row_user['registration_date']; ?>">
                                <input type="hidden" name="previous_photo" value="<?php echo $row_user['photo']; ?>">

                                <a href="settings.php" class="btn btn-danger fileinput-exists m-5">Cancelar</a>
                                <button type="submit" class="btn btn-success fileinput-exists m-5"><i class="fa fa-check"></i> Salvar</button>
                              </div>
                            </form>
                          </div>
                        </div>

                      </div>

                      <div class="pm-body clearfix">

                        <div class="pmb-block">

                          <span class="pull-right"><a href=""data-pmb-action="edit" class="btn btn-primary btn-xs" href=""><i class="zmdi zmdi-key m-r-5"></i> Alterar senha</a></span>


                          <div class="pmbb-body p-l-30">

                            <div class="pmbb-edit">
                              <div class="pmbb-header">
                                <h2><i class="zmdi zmdi-key m-r-5"></i> Escolha uma nova senha</h2>
                              </div>
                              <form method="POST" name="update_pass" id="update_pass" action="updates.php">
                                <dl class="dl-horizontal">
                                  <dt class="p-t-10">Nova senha</dt>
                                  <dd>
                                    <div class="fg-line">
                                      <input type="password" name="password" id="password" class="form-control" required>
                                    </div>

                                  </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                  <dt class="p-t-10">Confirme a senha</dt>
                                  <dd>
                                    <div class="dtp-container dropdown fg-line">
                                      <input type='password' name="confirm_password" id="confirm_password" class="form-control" required>
                                    </div>
                                  </dd>
                                </dl>

                                <input type="hidden" name="update_password" value="password">
                                <input type="hidden" name="id_user" value="<?php echo $row_user['id_user']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row_user['name']; ?>">
                                <input type="hidden" name="email" value="<?php echo $row_user['email']; ?>">
                                <input type="hidden" name="photo" value="<?php echo $row_user['photo']; ?>">
                                <input type="hidden" name="type" value="<?php echo $row_user['type']; ?>">
                                <input type="hidden" name="level" value="<?php echo $row_user['level']; ?>">
                                <input type="hidden" name="skype" value="<?php echo $row_user['skype']; ?>">
                                <input type="hidden" name="lesson_price" value="<?php echo $row_user['lesson_price']; ?>">
                                <input type="hidden" name="lessons_skype" value="<?php echo $row_user['lessons_skype']; ?>">
                                <input type="hidden" name="registration_date" value="<?php echo $row_user['registration_date']; ?>">

                                <div class="m-t-30">
                                  <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                  <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancelar</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <div class="pmb-block">
                          <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-account m-r-5"></i> Informações básicas</h2>

                            <ul class="actions">
                              <li>
                                <a href=""data-pmb-action="edit" href="">
                                  <i class="zmdi zmdi-edit"></i>
                                </a>
                              </li>
                            </ul>
                          </div>
                          <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                              <dl class="dl-horizontal">
                                <dt>Tipo de conta</dt>
                                <dd><?php if($row_user['type']=='T'){
                                  echo 'Professor';
                                }
                                else{
                                  echo 'Aluno';
                                }?></dd>
                              </dl>
                              <dl class="dl-horizontal">
                                <dt>Nome</dt>
                                <dd><?php echo $row_user['name']; ?></dd>
                              </dl>
                              <dl class="dl-horizontal">
                                <dt>E-mail</dt>
                                <dd><?php echo $row_user['email']; ?></dd>
                              </dl>
                            </div>

                            <div class="pmbb-edit">
                              <form method="POST" name="update_basic_information" id="update_basic_information" action="updates.php">
                                <dl class="dl-horizontal">
                                  <dt class="p-t-10">Tipo de conta</dt>
                                  <dd>
                                    <label class="radio radio-inline m-r-20">
                                      <input type="radio" name="type" value="S" <?php if($row_user['type']=='S') echo 'checked'; ?>>
                                      <i class="input-helper"></i>
                                      Aluno
                                    </label>

                                    <label class="radio radio-inline m-r-20">
                                      <input type="radio" name="type" value="T" <?php if($row_user['type']=='T') echo 'checked'; ?>>
                                      <i class="input-helper"></i>
                                      Professor
                                    </label>
                                  </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                  <dt class="p-t-10">Nome</dt>
                                  <dd>
                                    <div class="fg-line">
                                      <input type="text" name="name" id="name" class="form-control" value="<?php echo $row_user['name']; ?>" required maxlength="50">
                                    </div>

                                  </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                  <dt class="p-t-10">E-mail</dt>
                                  <dd>
                                    <div class="dtp-container dropdown fg-line">
                                      <input type='email' name="email" id="email" class="form-control" value="<?php echo $row_user['email']; ?>" required maxlength="100">
                                    </div>
                                  </dd>
                                </dl>

                                <input type="hidden" name="update_basic" value="basic">
                                <input type="hidden" name="id_user" value="<?php echo $row_user['id_user']; ?>">
                                <input type="hidden" name="password" value="<?php echo $row_user['password']; ?>">
                                <input type="hidden" name="photo" value="<?php echo $row_user['photo']; ?>">
                                <input type="hidden" name="level" value="<?php echo $row_user['level']; ?>">
                                <input type="hidden" name="skype" value="<?php echo $row_user['skype']; ?>">
                                <input type="hidden" name="lesson_price" value="<?php echo $row_user['lesson_price']; ?>">
                                <input type="hidden" name="lessons_skype" value="<?php echo $row_user['lessons_skype']; ?>">
                                <input type="hidden" name="registration_date" value="<?php echo $row_user['registration_date']; ?>">

                                <div class="m-t-30">
                                  <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                  <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancelar</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <div class="pmb-block">
                          <div class="pmbb-header">
                            <h2><i class="fa fa-graduation-cap m-r-5"></i> Nível de inglês</h2>

                            <ul class="actions">
                              <li>
                                <a href=""data-pmb-action="edit" href="">
                                  <i class="zmdi zmdi-edit"></i>
                                </a>
                              </li>
                            </ul>
                          </div>
                          <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                              <dl class="dl-horizontal">
                                <dt>Nível</dt>
                                <dd>
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
                                </dd>
                              </dl>
                            </div>

                            <div class="pmbb-edit">
                              <form method="POST" name="update_english_level" id="update_english_level" action="updates.php">
                                <dl class="dl-horizontal">
                                  <dt class="p-t-10">Nível</dt>
                                  <dd>
                                    <div class="fg-line">
                                      <select name="level" class="form-control">
                                        <option value="1" <?php if($row_user['level']==1) echo 'selected'; ?> >Iniciante</option>
                                        <option value="2" <?php if($row_user['level']==2) echo 'selected'; ?> >Básico</option>
                                        <option value="3" <?php if($row_user['level']==3) echo 'selected'; ?> >Intermediário</option>
                                        <option value="4" <?php if($row_user['level']==4) echo 'selected'; ?> >Avançado</option>
                                        <option value="5" <?php if($row_user['level']==5) echo 'selected'; ?> >Fluente</option>
                                      </select>
                                    </div>
                                  </dd>
                                </dl>

                                <input type="hidden" name="update_level" value="level">
                                <input type="hidden" name="id_user" value="<?php echo $row_user['id_user']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row_user['name']; ?>">
                                <input type="hidden" name="email" value="<?php echo $row_user['email']; ?>">
                                <input type="hidden" name="password" value="<?php echo $row_user['password']; ?>">
                                <input type="hidden" name="photo" value="<?php echo $row_user['photo']; ?>">
                                <input type="hidden" name="type" value="<?php echo $row_user['type']; ?>">
                                <input type="hidden" name="skype" value="<?php echo $row_user['skype']; ?>">
                                <input type="hidden" name="lesson_price" value="<?php echo $row_user['lesson_price']; ?>">
                                <input type="hidden" name="lessons_skype" value="<?php echo $row_user['lessons_skype']; ?>">
                                <input type="hidden" name="registration_date" value="<?php echo $row_user['registration_date']; ?>">

                                <div class="m-t-30">
                                  <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                  <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancelar</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>


                        <div class="pmb-block">
                          <div class="pmbb-header">
                            <h2><i class="fa fa-skype m-r-5"></i> Aulas via Skype</h2>

                            <ul class="actions">
                              <li>
                                <a href=""data-pmb-action="edit" href="">
                                  <i class="zmdi zmdi-edit"></i>
                                </a>
                              </li>
                            </ul>
                          </div>
                          <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                              <dl class="dl-horizontal">
                                <dt>Nome de Skype</dt>
                                <dd><?php if($row_user['skype']==NULL){
                                  echo 'Não informado';
                                }
                                else{
                                  echo $row_user['skype'];
                                }?></dd>
                              </dl>
                              <dl class="dl-horizontal">
                                <dt>Aulas via Skype</dt>
                                <dd><?php if($row_user['lessons_skype']=='Y'){
                                  echo '<i class="fa fa-check fa-lg c-green"></i>';
                                }
                                else{
                                  echo '<i class="fa fa-ban fa-lg c-red"></i>';
                                }?></dd>
                              </dl>

                              <?php if($row_user['type']!='S'){ ?>
                                <dl class="dl-horizontal">
                                  <dt>Preço</dt>
                                  <dd><?php if($row_user['lesson_price']==NULL OR $row_user['lesson_price']=='0,00'){
                                    echo '<span class="c-green">Grátis!</span>';
                                  }
                                  else{
                                    echo $row_user['lesson_price'].' a cada 30 minutos de aula.';
                                  }?></dd>
                                </dl>
                                <?php } ?>

                              </div>

                              <div class="pmbb-edit">
                                <form method="POST" name="update_skype_lessons" id="update_skype_lessons" action="updates.php">
                                  <dl class="dl-horizontal">
                                    <dt class="p-t-10">Nome de Skype <i class="zmdi zmdi-help" data-toggle="tooltip" data-placement="top" title="Nome de usuário que você utiliza para acessar o Skype."></i></dt>
                                    <dd>
                                      <div class="fg-line">
                                        <input type="text" name="skype" class="form-control" value="<?php echo $row_user['skype']; ?>" maxlength="32">
                                      </div>
                                    </dd>
                                  </dl>
                                  <dl class="dl-horizontal">
                                    <dt class="p-t-10">Aula via Skype</dt>
                                    <dd>
                                      <label class="radio radio-inline m-r-20">
                                        <input type="radio" name="lessons_skype" value="Y" <?php if($row_user['lessons_skype']=='Y') echo 'checked'; ?>>
                                        <i class="input-helper"></i>
                                        Sim
                                      </label>

                                      <label class="radio radio-inline m-r-20">
                                        <input type="radio" name="lessons_skype" value="N" <?php if($row_user['lessons_skype']=='N') echo 'checked'; ?>>
                                        <i class="input-helper"></i>
                                        Não
                                      </label>
                                    </dd>
                                  </dl>
                                  <?php if($row_user['type']!='S'){ ?>
                                    <dl class="dl-horizontal">
                                      <dt class="p-t-10">Preço <i class="zmdi zmdi-help" data-toggle="tooltip" data-placement="top" title="Valor cobrado a cada 30 min. de aula."></i></dt>
                                      <dd>
                                        <div class="fg-line">
                                          <input type="text" name="lesson_price" id="price" class="form-control" value="<?php echo $row_user['lesson_price']; ?>" maxlength="9">
                                        </div>
                                      </dd>
                                    </dl>
                                    <?php } ?>

                                    <input type="hidden" name="update_skype" value="skype">
                                    <input type="hidden" name="id_user" value="<?php echo $row_user['id_user']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $row_user['name']; ?>">
                                    <input type="hidden" name="email" value="<?php echo $row_user['email']; ?>">
                                    <input type="hidden" name="password" value="<?php echo $row_user['password']; ?>">
                                    <input type="hidden" name="photo" value="<?php echo $row_user['photo']; ?>">
                                    <input type="hidden" name="type" value="<?php echo $row_user['type']; ?>">
                                    <input type="hidden" name="level" value="<?php echo $row_user['level']; ?>">
                                    <input type="hidden" name="registration_date" value="<?php echo $row_user['registration_date']; ?>">

                                    <div class="m-t-30">
                                      <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                      <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancelar</button>
                                    </div>
                                  </form>
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

                  <script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
                  <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
                  <script src="vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
                  <script src="vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
                  <script src="vendors/bower_components/moment/min/moment.min.js"></script>
                  <script src="vendors/fileinput/fileinput.min.js"></script>
                  <script src="vendors/validation/jquery.validate.js" type="text/javascript"></script>
                  <script src="vendors/mask-money/jquery.maskMoney.js"></script>
                  <!-- Placeholder for IE9 -->
                  <!--[if IE 9 ]>
                  <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
                  <![endif]-->

                  <script src="js/functions.js"></script>
                  <script src="js/demo.js"></script>

                  <script>
                  $(document).ready( function() {

                    $("#update_pass").validate({
                      // Define as regras

                      rules:{
                        password: {
                          required: true,
                          minlength: 4
                        },
                        confirm_password: {
                          required: true,
                          minlength: 4,
                          equalTo: "#password"
                        }

                      },
                      // Define as mensagens de erro para cada regra
                      messages:{
                        password: {
                          required: "Por favor, escolha uma senha.",
                          minlength: "Sua senha deve conter pelo menos 4 caracteres."
                        },
                        confirm_password: {
                          required: "Por favor, digite sua senha novamente.",
                          minlength: "Sua senha deve conter pelo menos 4 caracteres.",
                          equalTo: "A senha deve ser idêntica a digitada anteriormente."
                        }

                      },

                    });

                  });
                  </script>

                  <script type="text/javascript">
                  $(function(){
                    $("#price").maskMoney({symbol:'R$ ',
                    showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
                  })
                  </script>

                </body>
                </html>
