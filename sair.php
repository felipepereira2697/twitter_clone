<?php 

session_start();

//recuperando as variaveis de sessão
//vamos eliminar os indices dessa sessão, ou seja, mataremos a sessão
unset($_SESSION['usuario']);
unset($_SESSION['email']);
echo "<p>Até a próxima</p>";
header('Location:index.php');
 ?>