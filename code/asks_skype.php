<?php require_once('Connections/hellow.php');
include('verification.php');
$id = $_SESSION['id_user'];
$sql = "SELECT id_user, type FROM users WHERE id_user=$id";
$result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_user = mysql_fetch_assoc($result_user); // recebe os dados do result

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
  <link href="dashboard/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body class="login-content">

  <!-- pergunta o nível de ingles no promeiro acesso -->
  <div class="lc-block toggled" id="l-login">

    <!-- Mensagens de alerta -->
    <?php if(isset($_GET['level']) AND $_GET['level']=='erro'){ ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <b>Ops!</b> Parece que algo deu errado ao tentar atualizar o seu nível de inglês, após definir suas informações de Skype, tente novamente na área de configurações. Caso persista o erro, informe a nossa equipe através do
        e-mail <b>fhsrocha@gmail.com</b>. Desculpe o transtorno.
      </div>
      <?php } ?>

      <?php if($row_user['type']=='S'){ ?>
        <form method="POST" name="asks_skype_student" id="asks_skype_student" action="dashboard/updates.php">
          <span class="badge bgm-gray m-b-15">Passo 2 de 2</span>
          <br/>

          Com sua conta do Skype você consegue praticar inglês com outros alunos, ou assistir a aulas ao vivo com os melhores professores!

          <div class="input-group m-20" id="skype_student">
            <span class="input-group-addon"><i class="fa fa-skype"></i></span>
            <div class="fg-line">
              <input type="text" name="skype" id="skype" class="form-control input-lg" placeholder="Nome de Skype" maxlength="32">
            </div>
          </div>

          <div class="checkbox m-b-15">
            <label>
              <input type="checkbox" name="lessons" id="not_skype" value="N">
              <i class="input-helper"></i>
              Não quero praticar nem assistir a aulas via Skype, quero apenas assistir as vídeo aulas da plataforma.
            </label>
          </div>

          <input type="hidden" name="update_skype" value="skype_student">
          <input type="hidden" name="id_user" value="<?php echo $row_user['id_user']; ?>">

          <div class="clearfix"></div>
          <button type="submit" class="btn btn-login btn-primary btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
        </form>
        <?php }
        else{ ?>
          <form method="POST" name="asks_skype" id="asks_skype" action="dashboard/updates.php">
            <span class="badge bgm-gray m-b-15">Passo 1 de 1</span>
            <h3>Aulas via Skype</h3>

            <div id="lessons">
              <div class="input-group m-20">
                <span class="input-group-addon"><i class="fa fa-skype c-blue"></i></span>
                <div class="fg-line">
                  <input type="text" name="skype" id="skype" class="form-control input-lg" placeholder="Nome de Skype" maxlength="32">
                </div>
              </div>

              <div class="input-group m-20" id="lessons_price">
                <span class="input-group-addon"><i class="fa fa-money c-green"></i> Preço da aula (A cada 30 min.) </span>
                <div class="fg-line">
                  <input type="text" name="price" id="price" class="form-control input-lg" placeholder="R$ 0,00" maxlength="9">
                </div>
              </div>

            </div>

            <div class="checkbox m-b-15" id="check_free">
              <label>
                <input type="checkbox" name="free" id="free" value="Y">
                <i class="input-helper"></i>
                <b>Grátis!</b> Quero ensinar por paixão <i class="fa fa-heart c-red"></i>
              </label>
            </div>


            <div class="checkbox m-b-15">
              <label>
                <input type="checkbox" name="lessons" id="not" value="N">
                <i class="input-helper"></i>
                Não quero dar aulas via Skype, quero apenas produzir cursos online.
              </label>
            </div>

            <input type="hidden" name="update_skype" value="skype_teacher">
            <input type="hidden" name="id_user" value="<?php echo $row_user['id_user']; ?>">

            <div class="clearfix"></div>
            <button type="submit" class="btn btn-login btn-primary btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
          </form>
          <?php } ?>

          <div class="text-left">
            <a data-toggle="collapse" href="#what" aria-expanded="false" aria-controls="what">
              O que é nome de Skype?
            </a>
            <div class="collapse m-t-10" id="what">
              <p>Seu nome de Skype é o seu user name, o nome que você informa quando vai realizar login no Skype.</p>
            </div>
            <br/>
            <a data-toggle="collapse" href="#how" aria-expanded="false" aria-controls="how">
              Não tenho Skype, como crio um?
            </a>
            <div class="collapse m-t-10" id="how">
              <p>É muito simples, basta criar uma conta clicando <a href="https://login.skype.com/registration" class="btn btn-primary btn-xs" target="_blank">aqui</a></p>
            </div>
          </div>

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
<script src="dashboard/vendors/input-mask/input-mask.min.js"></script>
<script src="dashboard/vendors/validation/jquery.validate.js" type="text/javascript"></script>
<script src="dashboard/vendors/mask-money/jquery.maskMoney.js"></script>

<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
<script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
<![endif]-->


<script src="dashboard/js/functions.js"></script>

<!-- Não quero dar aulas via Skype -->
<script type="text/javascript">
$(document).ready(function(){

  //campo skype é obrigatório para alunos
  $("#asks_skype_student").validate({
    // Define as regras
    rules:{
      skype: {
        required: true
      }
    },
    // Define as mensagens de erro para cada regra
    messages:{
      skype: {
        required: "Por favor, informe seu nome de Skype"
      }
    },
  });

  //campo skype é obrigatório para alunos
  $("#asks_skype").validate({
    // Define as regras
    rules:{
      skype: {
        required: true
      },
      price: {
        required: true
      }
    },
    // Define as mensagens de erro para cada regra
    messages:{
      skype: {
        required: "Por favor, informe seu nome de Skype"
      },
      price: {
        required: "Por favor, defina um valor para a aula."
      }
    },
  });

  $('#not_skype').change(function(){
    if(this.checked){
      $('#skype_student').fadeOut('slow');
    }
    else{
      $('#skype_student').fadeIn('slow');

      //se o aluno não deseja usar o skype, então o campo deixa de ser obrigatório
      $("#asks_skype_student").validate({
        // Define as regras
        rules:{
          skype: {
            required: false
          }
        }

      });
    }

  });

  $('#free').change(function(){
    if(this.checked){
      $('#lessons_price').fadeOut('slow');
    }
    else{
      $('#lessons_price').fadeIn('slow');
      //se o professor deseja dar aulas gratis, então o campo price deixa de ser obrigatório
      $("#asks_skype").validate({
        // Define as regras
        rules:{
          price: {
            required: false
          }
        }
      });
    }

  });

  $('#not').change(function(){
    if(this.checked){
      $('#lessons').fadeOut('slow');
      $('#check_free').fadeOut('slow');
    }
    else{
      $('#lessons').fadeIn('slow');
      $('#check_free').fadeIn('slow');
      // se o professor não deseja dar aulas via skype, então os campos skype e price deixam de ser obrigatórios
      $("#asks_skype").validate({
        // Define as regras
        rules:{
          skype: {
            required: false
          },
          price: {
            required: false
          }
        }
      });

    }

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
