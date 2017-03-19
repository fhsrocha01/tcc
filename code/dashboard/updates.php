<?php require_once('../Connections/hellow.php');
include('verification.php');
// Asks level
if ((isset($_GET["level"])) && ($_GET["level"] != 0)) {

	$id_user = $_GET['user'];
	$sql = "SELECT * FROM users WHERE id_user=$id_user";
	$result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_user = mysql_fetch_assoc($result_user); // recebe os dados do result

	$type = $row_user['type'];
	$name = $row_user['name'];
	$email = $row_user['email'];
	$password = $row_user['password'];
	$photo = $row_user['photo'];
	$registration_date = $row_user['registration_date'];
	$level = $_GET['level'];

	// update
	$query = "UPDATE users SET id_user='$id_user', type='$type', name='$name', email='$email', password='$password', photo='$photo', registration_date='$registration_date', level='$level' WHERE id_user='$id_user'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='../asks_skype.php';</script>";
	} else {
		echo "<script>location.href='../asks_skype.php?level=erro';</script>";
	}
}

// Asks skype for teacher
if ((isset($_POST['update_skype'])) && ($_POST['update_skype'] == 'skype_teacher')) {

	$id_user = $_POST['id_user'];
	$sql = "SELECT * FROM users WHERE id_user=$id_user";
	$result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_user = mysql_fetch_assoc($result_user); // recebe os dados do result

	$type = $row_user['type'];
	$name = $row_user['name'];
	$email = $row_user['email'];
	$password = $row_user['password'];
	$photo = $row_user['photo'];
	$registration_date = $row_user['registration_date'];
	$level = $row_user['level'];

	//se professor não deseja dar aulas via skype
	if(isset($_POST['lessons']) AND $_POST['lessons'] == 'N'){
		$lessons = 'N';
		$skype = null;
		$price = null;
	}
	//se o professor deseja dar aulas gratuitamente
	else if(isset($_POST['free']) AND $_POST['free'] == 'Y'){
		$lessons = 'Y';
		$skype = $_POST['skype'];
		$price = null;
	}
	//se o professor deseja cobrar pelas aulas
	else{
		$lessons = 'Y';
		$skype = $_POST['skype'];
		$price = $_POST['price'];
	}

	// update
	$query = "UPDATE users SET id_user='$id_user', type='$type', name='$name', email='$email', password='$password', photo='$photo', registration_date='$registration_date', level='$level', skype='$skype', lesson_price='$price', lessons_skype='$lessons' WHERE id_user='$id_user'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='index.php';</script>";
	} else {
		echo "<script>location.href='index.php?skype=erro';</script>";
	}
}

// Asks skype for student
if ((isset($_POST['update_skype'])) && ($_POST['update_skype'] == 'skype_student')) {

	$id_user = $_POST['id_user'];
	$sql = "SELECT * FROM users WHERE id_user=$id_user";
	$result_user = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_user = mysql_fetch_assoc($result_user); // recebe os dados do result

	$type = $row_user['type'];
	$name = $row_user['name'];
	$email = $row_user['email'];
	$password = $row_user['password'];
	$photo = $row_user['photo'];
	$registration_date = $row_user['registration_date'];
	$level = $row_user['level'];

	//se o aluno não deseja ter aulas via skype
	if(isset($_POST['lessons']) AND $_POST['lessons'] == 'N'){
		$lessons = 'N';
		$skype = null;
		$price = null;
	}
	else{
		$lessons = 'Y';
		$skype = $_POST['skype'];
		$price = null;
	}

	// update
	$query = "UPDATE users SET id_user='$id_user', type='$type', name='$name', email='$email', password='$password', photo='$photo', registration_date='$registration_date', level='$level', skype='$skype', lesson_price='$price', lessons_skype='$lessons' WHERE id_user='$id_user'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='index.php';</script>";
	} else {
		echo "<script>location.href='index.php?skype=erro';</script>";
	}
}

// EDITAR CURSO
if ((isset($_POST["update"])) && ($_POST["update"] == "update_course")) {
	include('verification_teacher.php');
	$id_course = $_POST['id_course'];
	$id_user = $_POST['id_teacher'];
	$name = $_POST['course_name'];
	$about = $_POST['about'];
	$level = $_POST['level'];
	$creation = $_POST['creation'];
	$tags = $_POST['tags'];
	if(isset($_POST['published'])){
		$published = 'Y';
	}
	else{
		$published = 'N';
	}

	// update
	$query = "UPDATE courses SET id_course='$id_course', users_id_user='$id_user', name='$name', about='$about', level='$level', creation='$creation', tags='$tags', published='$published' WHERE id_course='$id_course'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='studio.php?update=success';</script>";
	} else {
		echo "<script>location.href='studio.php?update=erro';</script>";
	}
}

// EDITAR/EXCLUIR MATERIA EM PDF DE AULA
if ((isset($_GET["pdf"])) && ($_GET["pdf"] != null)) {
include('verification_teacher.php');
	$id_class = $_GET['id_class'];
	$sql = "SELECT * FROM classes WHERE id_class=$id_class";
	$result_class = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_class = mysql_fetch_assoc($result_class); // recebe os dados do result

	$id_course = $row_class['courses_id_course'];
	$id_user = $row_class['courses_users_id_user'];
	$name = $row_class['name'];
	$about = $row_class['about'];
	$link = $row_class['link'];
	$pdf = null;
	$tags = $row_class['tags'];
	$published = $row_class['published'];
	$creation = $row_class['creation'];

	// update
	$query = "UPDATE classes SET id_class='$id_class', courses_users_id_user='$id_user', courses_id_course='$id_course', name='$name', about='$about', link='$link', pdf='$pdf', creation='$creation', tags='$tags', published='$published' WHERE id_class='$id_class'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {

		unlink("uploads/pdf/" . $_GET["pdf"]); // exclui o arquivo (na pasta)
		//Redireciona
		echo "<script>location.href='edit_class.php?id=$id_class';</script>";
	} else {
		echo "<script>location.href='edit_class.php?id=$id_class'&update=erro;</script>";
	}
}


// EDITAR AULA
if ((isset($_POST["update"])) && ($_POST["update"] == "update_class")) {
include('verification_teacher.php');
	$id_class = $_POST['id_class'];
	$id_course = $_POST['id_course'];
	$id_user = $_POST['id_teacher'];
	$name = $_POST['class_name'];
	$about = $_POST['about'];
	$link = $_POST['link'];
	$tags = $_POST['tags'];
	$creation = $_POST['creation'];
	if(isset($_POST['published'])){
		$published = 'Y';
	}
	else{
		$published = 'N';
	}

	// Verifica se um novo material em PDF será disponibilizado
	if ((isset($_FILES['pdf']['name'])) && ($_FILES['pdf']['name']!="")) {
		$uniqueName = date("YmdHms");
		// Caso queira mudar o nome do arquivo basta descomentar a linha abaixo e fazer a modificação
		$_FILES['pdf']['name'] = $uniqueName.".pdf";

		// Move o arquivo para uma pasta
		move_uploaded_file($_FILES['pdf']['tmp_name'],"uploads/pdf/".$_FILES['pdf']['name']);

		// $pdf é a variável que guarda o endereço em que o PDF foi salvo (para adicionar na base de dados)
		$pdf = $_FILES['pdf']['name'];

	}
	else if(isset($_POST['pdfa'])){
		$pdf = $_POST['pdfa'];
	}
	else{
		$pdf = null;
	}

	// update
	$query = "UPDATE classes SET id_class='$id_class', courses_users_id_user='$id_user', courses_id_course='$id_course', name='$name', about='$about', link='$link', pdf='$pdf', creation='$creation', tags='$tags', published='$published' WHERE id_class='$id_class'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='course.php?id=$id_course&update_class=success';</script>";
	} else {
		echo "<script>location.href='course.php?id=$id_course&update_class=erro';</script>";
	}
}


// Editar informações basicas
if ((isset($_POST["update_basic"])) && ($_POST["update_basic"] == 'basic')) {

	$id_user = $_POST['id_user'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$type = $_POST['type'];
	$level = $_POST['level'];
	$skype = $_POST['skype'];
	$lessons_skype = $_POST['lessons_skype'];
	$lesson_price = $_POST['lesson_price'];
	$registration_date = $_POST['registration_date'];
	$photo = $_POST['photo'];

	// update
	$query = "UPDATE users SET id_user='$id_user', name='$name', email='$email', password='$password', type='$type', level='$level', skype='$skype', lessons_skype='$lessons_skype', lesson_price='$lesson_price', registration_date='$registration_date', photo='$photo' WHERE id_user='$id_user'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='settings.php?update=success';</script>";
	} else {
		echo "<script>location.href='settings.php?update=erro';</script>";
	}
}



// Editar english level
if ((isset($_POST["update_level"])) && ($_POST["update_level"] == 'level')) {

	$id_user = $_POST['id_user'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$type = $_POST['type'];
	$level = $_POST['level'];
	$skype = $_POST['skype'];
	$lessons_skype = $_POST['lessons_skype'];
	$lesson_price = $_POST['lesson_price'];
	$registration_date = $_POST['registration_date'];
	$photo = $_POST['photo'];

	// update
	$query = "UPDATE users SET id_user='$id_user', name='$name', email='$email', password='$password', type='$type', level='$level', skype='$skype', lessons_skype='$lessons_skype', lesson_price='$lesson_price', registration_date='$registration_date', photo='$photo' WHERE id_user='$id_user'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='settings.php?update=success';</script>";
	} else {
		echo "<script>location.href='settings.php?update=erro';</script>";
	}
}

// Editar SKYPE
if ((isset($_POST["update_skype"])) && ($_POST["update_skype"] == 'skype')) {

	$id_user = $_POST['id_user'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$type = $_POST['type'];
	$level = $_POST['level'];
	$registration_date = $_POST['registration_date'];
	$photo = $_POST['photo'];
	$skype = $_POST['skype'];
	$lessons_skype = $_POST['lessons_skype'];
	if(isset($_POST['lesson_price'])){
		$lesson_price = $_POST['lesson_price'];
	}
	else {
		$lesson_price = NULL;
	}

	// update
	$query = "UPDATE users SET id_user='$id_user', name='$name', email='$email', password='$password', type='$type', level='$level', skype='$skype', lessons_skype='$lessons_skype', lesson_price='$lesson_price', registration_date='$registration_date', photo='$photo' WHERE id_user='$id_user'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='settings.php?update=success';</script>";
	} else {
		echo "<script>location.href='settings.php?update=erro';</script>";
	}
}

// Editar SENHA
if ((isset($_POST["update_password"])) && ($_POST["update_password"] == 'password')) {

	$id_user = $_POST['id_user'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$type = $_POST['type'];
	$level = $_POST['level'];
	$skype = $_POST['skype'];
	$lessons_skype = $_POST['lessons_skype'];
	$lesson_price = $_POST['lesson_price'];
	$registration_date = $_POST['registration_date'];
	$photo = $_POST['photo'];

	// update
	$query = "UPDATE users SET id_user='$id_user', name='$name', email='$email', password='$password', type='$type', level='$level', skype='$skype', lessons_skype='$lessons_skype', lesson_price='$lesson_price', registration_date='$registration_date', photo='$photo' WHERE id_user='$id_user'";
	// Executa a query
	$inserir = mysql_query($query);
	if ($inserir) {
		//Redireciona
		echo "<script>location.href='settings.php?update=password';</script>";
	} else {
		echo "<script>location.href='settings.php?update=erro';</script>";
	}
}


/******
* Upload de foto de perfil
******/

// verifica se foi enviado um arquivo
if ( isset( $_FILES[ 'arquivo' ][ 'name' ] ) && $_FILES[ 'arquivo' ][ 'error' ] == 0 ) {

	$arquivo_tmp = $_FILES[ 'arquivo' ][ 'tmp_name' ];
	$nome = $_FILES[ 'arquivo' ][ 'name' ];

	// Pega a extensão
	$extensao = pathinfo ( $nome, PATHINFO_EXTENSION );

	// Converte a extensão para minúsculo
	$extensao = strtolower ( $extensao );

	// Somente imagens, .jpg;.jpeg;.gif;.png
	// Aqui eu enfileiro as extensões permitidas e separo por ';'
	// Isso serve apenas para eu poder pesquisar dentro desta String
	if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {
		// Cria um nome único para esta imagem
		// Evita que duplique as imagens no servidor.
		// Evita nomes com acentos, espaços e caracteres não alfanuméricos
		$novoNome = date("YmdHms").'.'.$extensao;

		// Concatena a pasta com o nome
		$destino = 'img/profile-pics/' . $novoNome;

		// tenta mover o arquivo para o destino e salva seu nome no banco de dados
		if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {
			$id_user = $_POST['id_user'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$type = $_POST['type'];
			$level = $_POST['level'];
			$skype = $_POST['skype'];
			$lessons_skype = $_POST['lessons_skype'];
			$lesson_price = $_POST['lesson_price'];
			$registration_date = $_POST['registration_date'];
			$previous_photo = $_POST['previous_photo'];

			// update
			$query = "UPDATE users SET id_user='$id_user', name='$name', email='$email', password='$password', type='$type', level='$level', skype='$skype', lessons_skype='$lessons_skype', lesson_price='$lesson_price', registration_date='$registration_date', photo='$novoNome' WHERE id_user='$id_user'";
			// Executa a query
			$inserir = mysql_query($query);
			if ($inserir) {

				if($previous_photo!=NULL){
					unlink("img/profile-pics/" . $previous_photo); // exclui a foto anterior (na pasta)
				}

				//Redireciona
				echo "<script>location.href='settings.php?photo=success';</script>";
			} else { ?>
				<!-- Alert erro -->

				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Ah não! Parece que algo deu errado, tente novamente. Caso persista o erro, informe a nossa equipe através do
					e-mail <b>fhsrocha@gmail.com</b>. Desculpe o transtorno.<br/>
					<?php echo mysql_error(); ?>
				</div>
				<?php }
			}
			else
			echo 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
		}
		else
		echo "<script>location.href='settings.php?extension=erro';</script>";
	}
	?>
