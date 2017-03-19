<?PHP
session_start();

//Caso o usuário não esteja autenticado, limpa os dados e redireciona
if ( !isset($_SESSION['id_user'])) {
    //Destroi a sessão
    session_destroy();

    //Limpa
    unset ($_SESSION['id_user']);

    //Redireciona para a página de autenticação
    header('location:../login.php');
}
?>
