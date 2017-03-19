<?php
require_once('Connections/hellow.php');

if(isset($_POST['email'])){
  $email=$_POST['email'];
  $sql = "SELECT name, email FROM users WHERE email='$email'";
  $result = mysql_query($sql,$connection) or die ("Error in table selection.");
  $row_user = mysql_fetch_assoc($result);
  $totalRows_user = mysql_num_rows($result);
  $user_name = $row_user['name'];

  if($totalRows_user > 0){
    $CaracteresAceitos = 'abcdxywz0123456789';
    $max = strlen($CaracteresAceitos)-1;
    $password = null;
    for($i=0; $i < 8; $i++) {
      $password .= $CaracteresAceitos{mt_rand(0, $max)};
      $nova_senha = md5($password);
    }
    $sql = "UPDATE users set password='$nova_senha' WHERE email='$email'";
  	$consulta = mysql_query($sql);

    /* envia email para o usuário */
    $emailsender='fhsrocha@gmail.com';

    /* Verifica qual Ã©o sistema operacional do servidor para ajustar o cabeÃ§alho de forma correta.  */
    if(PATH_SEPARATOR == ";") $quebra_linha = "\r\n"; //Se for Windows
    else $quebra_linha = "\n"; //Se "nÃƒÂ£o for Windows"

    // Passando os dados obtidos pelo formulÃ¡rio para as variÃ¡veis abaixo
    $nomeremetente     = 'Equipe We Learn';
    $emailremetente    = 'fhsrocha@gmail.com';
    $assunto           = 'Redefinir senha - We Learn';
    $emaildestinatario = $_POST['email'];
    $mensagemHTML = '<h3>Olá '.$user_name.'!</h3>
    <p>Criamos uma nova senha para você:<br/><br/>
    <b>Senha: '.$password.'</b><br/><br/>
    Para sua segurança altere ela assim que realizar seu primeiro login, na área de configurações.<br/>
    Equipe We Learn.</p>';

    /* Montando o cabeÃƒÂ§alho da mensagem */
    $headers = "MIME-Version: 1.1" .$quebra_linha;
    $headers .= "Content-type: text/html; charset=iso-8859-1" .$quebra_linha;
    // Perceba que a linha acima contÃ©m "text/html", sem essa linha, a mensagem nÃ£o chegarÃ¡ formatada.
    $headers .= "From: " . $emailsender.$quebra_linha;
    $headers .= "Reply-To: Mensagem automática, não responder." . $quebra_linha;
    // Note que o e-mail do remetente serÃ¡ usado no campo Reply-To (Responder Para)

    /* Enviando a mensagem */

    if(!mail($emaildestinatario, $assunto, $mensagemHTML, $headers ,"-r".$emailsender)){ // Se for Postfix
      $headers .= "Return-Path: " . $emailsender . $quebra_linha; // Se "nÃ£o for Postfix"
      mail($emaildestinatario, $assunto, $mensagemHTML, $headers );
    }

    /* Fim do envio de email */

    echo "<script>location.href='login.php?forget_password=success&email=$email'</script>";

  }
  else{
    echo "<script>location.href='login.php?forget_password=erro&email=$email'</script>";
  }
}
else{
  echo "<script>location.href='login.php'</script>";
}
?>
