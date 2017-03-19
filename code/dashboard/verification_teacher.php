<?PHP
$id=$_SESSION['id_user'];
$sql = "SELECT type FROM users WHERE id_user=$id";
$result = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_user = mysql_fetch_assoc($result);

//Caso o usuário não seja professor redirecionamos para a página inicial
if ($row_user['type']!='T') {
    header('location:index.php?access=denied');
}
?>
