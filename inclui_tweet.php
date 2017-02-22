
<?php
//colocando autenticacao, de forma que uma pessoa q não está autenticada não consiga fazer uma requisicao
// para essa página, impedindo invasão
session_start();//iniciando a sessao
//bloquear o acesso para a home deixando somente o usuário que se autenticou acesse-a
if(!isset($_SESSION['usuario'])){
	header("Location: index.php?erro=1");
}
/*recuperando o campo de texto do tweet que está la no home, usando ajax e via POST*/
require_once('bd.class.php');

$id_usuario = $_SESSION['id_usuario'];
$tweet = $_POST['txt_tweet'];

//instância da classe bd
$objBd = new bd();
$objBd->conecta_mysql();	

//verificando se ja existe usuário com aquele email e ou username
//se essa query tiver retorno, é pq o usuário informado já está em uso
$sql =  " INSERT INTO tweet(id_usuario, tweet) VALUES($id_usuario, '$tweet') ";

mysql_query($sql);
?>