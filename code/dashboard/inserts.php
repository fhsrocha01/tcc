<?php require_once('../Connections/hellow.php');
include('verification.php');

//CADASTRO DE CURSO
if ((isset($_POST["course_name"]))) {
  $name = $_POST['course_name'];
  $about = $_POST['about'];
  $level = $_POST['level'];
  $tags = $_POST['tags'];
  $id_user = $_SESSION['id_user'];

  $query = "INSERT INTO courses (users_id_user, name, about, level, tags, published) VALUES ('$id_user', '$name', '$about', '$level', '$tags', 'N')";
  // Executa a query
  $inserir = mysql_query($query);
  if ($inserir) {
    //Redireciona
    echo "<script>location.href='studio.php?insert=success';</script>";
  } else { ?>
    <!-- Alert erro -->
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Ah não! Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
      e-mail <b>equipe@hellow.com.br</b>. Desculpe o transtorno.<br/>
      <?php echo mysql_error(); ?>
    </div>
    <?php }
  }

  //CADASTRO DE AULA
  if ((isset($_POST["insert"])) && ($_POST["insert"] == "insert_class")) {
    $id_user = $_POST['id_user'];
    $id_course = $_POST['id_course'];
    $name = $_POST['name'];
    $about = $_POST['about'];
    $link = $_POST['link'];
    $tags = $_POST['tags'];
    $published = $_POST['published'];

    // Verifica se um material em PDF será disponibilizado
    if ((isset($_FILES['pdf']['name'])) && ($_FILES['pdf']['name']!="") && isset($_POST["show_input"])) {

      $uniqueName = date("YmdHms");
      // Caso queira mudar o nome do arquivo basta descomentar a linha abaixo e fazer a modificação
      $_FILES['pdf']['name'] = $uniqueName.".pdf";

      // Move o arquivo para uma pasta
      move_uploaded_file($_FILES['pdf']['tmp_name'],"uploads/pdf/".$_FILES['pdf']['name']);

      // $pdf_path é a variável que guarda o endereço em que o PDF foi salvo (para adicionar na base de dados)
      $pdf_path = $_FILES['pdf']['name'];

    }
    else{
      $pdf_path = NULL;
    }

    $query = "INSERT INTO classes (courses_users_id_user, courses_id_course, name, about, link, pdf, tags, published) VALUES ('$id_user', '$id_course', '$name', '$about', '$link', '$pdf_path', '$tags', '$published')";
    // Executa a query
    $inserir = mysql_query($query);
    if ($inserir) {
      //Redireciona
      echo "<script>location.href='course.php?id=$id_course&&insert=success';</script>";
    } else { ?>
      <!-- Alert erro -->
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Ah não! Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
        e-mail <b>equipe@hellow.com.br</b>. Desculpe o transtorno.<br/>
        <?php echo mysql_error(); ?>
      </div>
      <?php }
    }

    //favorito
    if ((isset($_GET["favorite"]))) {
      $id_user = $_GET['user'];
      $id_favorite = $_GET['favorite'];

      $query = "INSERT INTO favorite (users_id_user, id_favorite) VALUES ('$id_user', '$id_favorite')";
      // Executa a query
      $inserir = mysql_query($query);
      if ($inserir) {
        //Redireciona
        echo "<script>location.href='profile.php?id=$id_favorite';</script>";
      } else { ?>
        <!-- Alert erro -->
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Ah não! Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
          e-mail <b>equipe@hellow.com.br</b>. Desculpe o transtorno.<br/>
          <?php echo mysql_error(); ?>
        </div>
        <?php }
      }


      //Inscrever em curso
      if ((isset($_GET["subscribe"]))) {
        $id_user = $_GET['subscribe'];
        $id_teacher = $_GET['teacher'];
        $id_course = $_GET['course'];

        $query = "INSERT INTO inscription (users_id_user, courses_users_id_user, courses_id_course) VALUES ('$id_user', '$id_teacher', '$id_course')";
        // Executa a query
        $inserir = mysql_query($query);
        if ($inserir) {
          //Redireciona
          echo "<script>location.href='course.php?id=$id_course';</script>";
        } else { ?>
          <!-- Alert erro -->
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Ah não! Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
            e-mail <b>equipe@hellow.com.br</b>. Desculpe o transtorno.<br/>
            <?php echo mysql_error(); ?>
          </div>
          <?php }
        }

        //Review
        if ((isset($_POST["insert_review"])) AND ($_POST["insert_review"]=='review')) {
          $id_user = $_POST['id_user'];
          $id_teacher = $_POST['id_teacher'];
          $message = $_POST['message'];

          $query = "INSERT INTO reviews (id_teacher, id_user, message) VALUES ('$id_teacher', '$id_user', '$message')";
          // Executa a query
          $inserir = mysql_query($query);
          if ($inserir) {
            //Redireciona
            echo "<script>location.href='profile_reviews.php?id=$id_teacher&message=success';</script>";
          } else { ?>
            <!-- Alert erro -->
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Ah não! Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
              e-mail <b>equipe@hellow.com.br</b>. Desculpe o transtorno.<br/>
              <?php echo mysql_error(); ?>
            </div>
            <?php }
          }

          //Denuncia
          if (isset($_POST["complaint"]) AND $_POST["complaint"]=='user_complaint' ) {
            $id_user = $_POST['id_user'];
            $id_denounced = $_POST['id_denounced'];
            $message = $_POST['message'];

            $query = "INSERT INTO complaint (users_id_user, id_user_denounced, message) VALUES ('$id_user', '$id_denounced', '$message')";
            // Executa a query
            $inserir = mysql_query($query);

            $sql = "SELECT * FROM complaint WHERE id_user_denounced='$id_denounced'";
            $result_complaint = mysql_query($sql,$connection) or die ("Error in table selection.");
            $row_complaint = mysql_fetch_assoc($result_complaint);
            $totalRows_complaint = mysql_num_rows($result_complaint);

            if($totalRows_complaint > 4){
              // update
              $query_update = "UPDATE users SET active='N' WHERE id_user='$id_denounced'";
              // Executa a query
              mysql_query($query_update);
            }

            if ($inserir) {
              //Redireciona
              echo "<script>location.href='profile.php?id=$id_denounced&complaint=success';</script>";
            } else {
              echo "<script>location.href='profile.php?id=$id_denounced&complaint=erro';</script>";
            }
          }

          ?>
