<?php require_once('Connections/hellow.php');

//LOGIN --------------------------------------------
// testa se algo foi enviado pelo formulário de login
if ((isset($_POST["send"])) && ($_POST["send"] == "login")) {

  $login = $_POST['email'];
  $password = md5($_POST['password']);

  //Comando SQL de verificação de autenticação
  $sql = "SELECT * FROM users WHERE email = '$login' AND password = '$password'";

  $result = mysql_query($sql,$connection) or die ("Error in table selection.");
  $row = mysql_fetch_assoc($result); // recebe os dados do result

  if($row['active']!='N'){

    //Caso consiga logar cria a sessão
    if (mysql_num_rows ($result) > 0) {
      // session_start inicia a sessão
      session_start();

      $_SESSION['id_user'] = $row['id_user']; // guarda o ID do user

      if($row['level']=='A'){
        //Redireciona para control painel
        header('location:admin/');
      } else if($row['level']==0 AND $row['type']=='S') {
        //Pergunta o nível de ingles do aluno
        header('location:asks_level.php');
      }
      else if($row['type']=='T' AND $row['lessons_skype']==null) {
        //Pergunta o usuário de skype para o professor
        header('location:asks_skype.php');
      }
      else {
        //Redireciona para o dashboard/
        header('location:dashboard/');
      }
    }

    //Caso algo de errado (como senha inválida) redireciona para a página de autenticação
    else {
      //Destrói
      session_destroy();

      //Limpa
      unset ($_SESSION['login']);
      unset ($_SESSION['password']);

      //Redireciona para a página de autenticação com mensagem de erro
      header('location:login.php?login=erro');

    }


  }
  else{
    // usuário bloqueado
    header('location:login.php?user=blocked');
  }

}

//FIM DO LOGIN -------------------------------------

// CADASTRO ----------------------------------------

//Verifica se algo foi enviado pelo form de cadastro
if ((isset($_POST["send"])) && ($_POST["send"] == "register")) {
  $type = $_POST['type'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = md5($_POST['password']);

  if($type=='T'){
    $level = 5;
  }
  else{
    $level = 0;
  }

  // Montamos a consulta SQL
  $query = "INSERT INTO users (name, email, password, type, level, active) VALUES ('$name', '$email', '$pass', '$type', '$level', 'Y')";
  // Executa a query
  $inserir = mysql_query($query);
  if ($inserir) {
    //Redireciona para login
    header('location:login.php?register=success');
  } else { ?>
    <!-- Alert erro -->
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      Ops! Algo de errado, tente novamente. Caso persista o erro, entre em contato com a nossa equipe
      através do e-mail fhsrocha@gmail.com. Desculpe o transtorno.
    </div>
    <?php }
  }
  //FIM DO CADASTRO -------------------------------------
  ?>

  <!DOCTYPE html>
  <!--[if IE 9 ]><html class="ie9"><![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>We Learn - Aprender, ensinar e praticar inglês!</title>

    <!-- Vendor CSS -->
    <link href="dashboard/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="dashboard/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="dashboard/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">

    <!-- CSS -->
    <link href="dashboard/css/app.min.1.css" rel="stylesheet">
    <link href="dashboard/css/app.min.2.css" rel="stylesheet">
  </head>

  <body class="login-content">

    <!-- Login -->
    <div class="lc-block toggled" id="l-login">

      <div class="m-b-20 text-center f-20 c-blue">
        We Learn
      </div>

      <?php if ((isset($_GET["register"])) && ($_GET["register"] == "success")) { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <b>Bem vindo ao We Learn!</b> Realize seu primeiro login.
        </div>
        <?php } ?>

        <?php if ((isset($_GET["login"])) && ($_GET["login"] == "erro")) { ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <b>Ops!</b> Algo deu errado, confira se digitou corretamente seu e-mail e senha.
          </div>
          <?php } ?>

          <?php if ((isset($_GET["forget_password"])) && ($_GET["forget_password"] == "erro")) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <b>E-mail não encontrado!</b> Você tem certeza que utilizou esse e-mail quando se cadastrou?
              Não encontramos nenhum usuário com o e-mail <b><?php echo $_GET['email']; ?></b> em nossos servidores.
            </div>
            <?php } ?>

            <?php if ((isset($_GET["forget_password"])) && ($_GET["forget_password"] == "success")) { ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <b>Sucesso!</b> Confira sua caixa de entrada. Enviamos uma nova senha para o e-mail <b><?php echo $_GET['email']; ?></b>.
              </div>
              <?php } ?>

          <?php if ((isset($_GET["user"])) && ($_GET["user"] == "blocked")) { ?>
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <b>Conta bloqueada!</b> Sua conta recebeu algumas reclamações e por segurança foi bloqueda.
              Caso acredite que houve uma injustiça, entre em contato com a nossa equipe através do fhsrocha@gmail.com.
            </div>
            <?php } ?>

            <form METHOD="POST" id="login" action="login.php">
              <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                  <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
              </div>

              <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <div class="fg-line">
                  <input type="password" name="password" class="form-control" placeholder="Senha" required>
                </div>
              </div>

              <input type="hidden" name="send" value="login">

              <div class="clearfix"></div>

              <button type="submit" class="btn btn-login btn-primary btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>

              <ul class="login-navigation">
                <li data-block="#l-register" class="bgm-green">Cadastre-se</li>
                <li data-block="#l-forget-password" class="bgm-orange">Esqueceu senha?</li>
              </ul>
            </form>
          </div>

          <!-- Register -->

          <div class="lc-block" id="l-register">
            <form method="POST" name="register" id="register" action="login.php">
              <div class="m-b-20">
                <label class="radio radio-inline m-r-20">
                  <input type="radio" name="type" id="student" value="S" checked>
                  <i class="input-helper"></i>
                  Aluno
                </label>

                <label class="radio radio-inline m-r-20">
                  <input type="radio" name="type" id="teacher" value="T">
                  <i class="input-helper"></i>
                  Professor
                </label>
              </div>

              <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                  <input type="text" name="name" id="email" class="form-control" placeholder="Nome" required>
                </div>
              </div>

              <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                  <input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
              </div>

              <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <div class="fg-line">
                  <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required>
                </div>

                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <div class="fg-line">
                  <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirme senha" required>
                </div>
              </div>

              <input type="hidden" name="send" value="register">

              <div class="clearfix"></div>

              <div class="small m-b-20">Clicando em cadastrar você estará aceitando nossos <a href="#">Termos de Uso.</a></div>
              <button type="submit" class="btn btn-success btn-icon-text"><i class="zmdi zmdi-check"></i> Cadastrar</button>


              <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-blue">Entrar</li>
                <li data-block="#l-forget-password" class="bgm-orange">Esqueceu senha?</li>
              </ul>
            </form>
          </div>



          <!-- Forgot Password -->
          <div class="lc-block" id="l-forget-password">
            <p class="text-left">Informe o e-mail utilizado no momento de cadastro, um link com instruções para
              redefição da senha será enviado para ele.</p>
              <form method="post" action="forget_password.php">
                <div class="input-group m-b-20">
                  <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                  <div class="fg-line">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                  </div>
                </div>

                <button class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
              </form>
              <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-blue">Entrar</li>
                <li data-block="#l-register" class="bgm-green">Cadastre-se</li>
              </ul>
            </div>

            <!-- Older IE warning message -->
            <!--[if lt IE 9]>
            <div class="ie-warning">
            <h1 class="c-white">Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
            <div class="iew-container">
            <ul class="iew-download">
            <li>
            <a href="http://www.google.com/chrome/">
            <img src="img/browsers/chrome.png" alt="">
            <div>Chrome</div>
          </a>
        </li>
        <li>
        <a href="https://www.mozilla.org/en-US/firefox/new/">
        <img src="img/browsers/firefox.png" alt="">
        <div>Firefox</div>
      </a>
    </li>
    <li>
    <a href="http://www.opera.com">
    <img src="img/browsers/opera.png" alt="">
    <div>Opera</div>
  </a>
</li>
<li>
<a href="https://www.apple.com/safari/">
<img src="img/browsers/safari.png" alt="">
<div>Safari</div>
</a>
</li>
<li>
<a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
<img src="img/browsers/ie.png" alt="">
<div>IE (New)</div>
</a>
</li>
</ul>
</div>
<p>Sorry for the inconvenience!</p>
</div>
<![endif]-->

<!-- Javascript Libraries -->
<script src="dashboard/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="dashboard/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="dashboard/vendors/bower_components/Waves/dist/waves.min.js"></script>
<script src="dashboard/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>

<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
<script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
<![endif]-->


<script src="dashboard/js/functions.js"></script>

<script src="dashboard/vendors/validation/jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready( function() {

  $("#login").validate({
    // Define as regras

    rules:{
      email:{
        required: true, email: true
      },
      password: {
        required: true
      }

    },
    // Define as mensagens de erro para cada regra
    messages:{
      email:{
        required: "Por favor, informe seu e-mail.",
        email: "Informe um e-mail válido."
      },
      password: {
        required: "Por favor, digite sua senha"
      }

    },

  });

  $("#register").validate({
    // Define as regras

    rules:{
      name:{
        required: true, minlength: 2
      },
      email:{
        required: true, email: true
      },
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
      name:{
        required: "Por favor, digite seu nome.",
        minlength: "Seu nome deve conter pelo menos 2 caracteres."
      },
      email:{
        required: "Por favor, informe seu e-mail.",
        email: "Informe um e-mail válido."
      },
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

</body>
</html>
