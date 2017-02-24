
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

//instância da classe bd
$objBd = new bd();
$objBd->conecta_mysql();	

//vamos criar uma consulta que permita recuperar os tweets do banco de dados
//com base no id do usuário é que saberemos qual tweet mostrar
//date format função do sql 
$sql =  " SELECT t.id_tweet, t.id_usuario, t.tweet, DATE_FORMAT(t.data_inclusao,'%d %b %Y %T') AS data_inclusao_formatada, u.usuario ";
$sql .=" FROM tweet AS t JOIN usuarios AS u ON(t.id_usuario = u.id) ";
$sql .= "WHERE id_usuario = '$id_usuario' "; 
$sql.= "OR id_usuario IN (SELECT seguindo_id_usuario FROM usuarios_seguidores WHERE id_usuario = $id_usuario)";
$sql .=" ORDER BY data_inclusao DESC ";


$resultado_id = mysql_query($sql);

if($resultado_id){
	//precisamos de uma estrutura de repetição para percorrer isto

	while($tweet = mysql_fetch_array($resultado_id)){
		
		echo'<a href="#" class="list-group-item">';
		echo '<h4 class="list-group-item-heading">'.$tweet['usuario'].' <small> - '.$tweet['data_inclusao_formatada'].'</small></h4>';
		echo '<p class="list-group-item-text">'.$tweet['tweet'].'</p>';
		echo '</a>';
	}
	


}else{

	echo 'deu ruim';
}
?>