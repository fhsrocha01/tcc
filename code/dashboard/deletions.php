<?php require_once('../Connections/hellow.php');
include('verification.php');
// Deletar curso
if ((isset($_GET['del_course'])) && ($_GET['del_course'] != "")) {
	include('verification_teacher.php');
	$id = $_GET['del_course'];
	$sql = sprintf("DELETE FROM courses WHERE id_course='$id'");

	mysql_select_db($database, $connection);
	$result = mysql_query($sql,$connection) or die ("Error in table selection.");

	header('location:studio.php?deletion=success');
}

// Deletar aula
if ((isset($_GET['del_class'])) && ($_GET['del_class'] != "")) {
	include('verification_teacher.php');
	$id = $_GET['del_class'];
	$id_course = $_GET['id_course'];

	$sql = "SELECT pdf FROM classes WHERE id_class=$id";
	$result_class = mysql_query($sql,$connection) or die ("Error in table selection.");
	$row_class = mysql_fetch_assoc($result_class);

	if($row_class['pdf']!= null){
		unlink("uploads/pdf/" . $row_class["pdf"]); // exclui o arquivo (na pasta)
	}

	$sql = sprintf("DELETE FROM classes WHERE id_class='$id'");

	mysql_select_db($database, $connection);
	$result = mysql_query($sql,$connection) or die ("Error in table selection.");

	header('location:course.php?id='.$id_course.'&del_class=success');
}

// Desfavoritar
if ((isset($_GET['favorite']))) {
	$id_user = $_GET['user'];
	$id_favorite = $_GET['favorite'];
	$sql = sprintf("DELETE FROM favorite WHERE users_id_user='$id_user' AND id_favorite='$id_favorite'");

	mysql_select_db($database, $connection);
	$result = mysql_query($sql,$connection) or die ("Error in table selection.");

	echo "<script>location.href='profile.php?id=$id_favorite';</script>";
}

// Desinscrever
if ((isset($_GET['subscribe']))) {
	$id_user = $_GET['subscribe'];
	$id_course = $_GET['course'];
	$sql = sprintf("DELETE FROM inscription WHERE users_id_user='$id_user' AND courses_id_course='$id_course'");

	mysql_select_db($database, $connection);
	$result = mysql_query($sql,$connection) or die ("Error in table selection.");

	echo "<script>location.href='course.php?id=$id_course';</script>";
}

// Deletar avaliação
if ((isset($_GET['del_review']))) {
	$id_review = $_GET['del_review'];
	$id_teacher = $_GET['id_teacher'];
	$sql = sprintf("DELETE FROM reviews WHERE id_review='$id_review'");

	mysql_select_db($database, $connection);
	$result = mysql_query($sql,$connection) or die ("Error in table selection.");

	echo "<script>location.href='profile_reviews.php?id=$id_teacher&review=del';</script>";
}
?>
