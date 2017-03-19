<?php
//Conexão mysql
$hostname = 'localhost';
$username = 'root';
$pass = '';
$database = 'hellow';
$connection = mysql_connect($hostname, $username, $pass) or die ("Error in the database connection.");
 
//Seleciona o banco de dados
$selecionabd = mysql_select_db($database,$connection) or die ("BD does not exist.");
?>
