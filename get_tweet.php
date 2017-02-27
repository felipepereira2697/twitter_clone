<?php 
//por ser uma página restrita da nossa aplicação precisamos fazer algumas tratativas
session_start();

if(!isset($_SESSION['usuario'])){
	header('Location: index.php?erro=1');
}

require_once 'db.class.php';

$id_usuario = $_SESSION['id_usuario'];

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = " SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T')AS data_inclusao, t.tweet, u.usuario FROM tweet AS t JOIN usuarios AS u ON (t.id_usuario = u.id) WHERE id_usuario = $id_usuario ORDER BY data_inclusao DESC";

//resultado id contém a referencia p/ o conteúdo externo ao php
$resultado_id = mysqli_query($link,$sql);
if($resultado_id){
	//para cada iteração a variavel registro vai receber um registro do bd, vai acontecer até o ultimo registro
	while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
		//a ideia aqui é usar a classe list-group-item do bootstrap, por isso usamos o link
		//vale lembrar que a div que conterá os tweets, possuí a class list-group
		echo '<a href="#" class="list-group-item"> ';
			echo '<h4 class="list-group-item-heading">'.$registro['usuario'].' <small> - '.$registro['data_inclusao'].'</small></h4>';
			echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
		echo '</a>';
	}
}else{
	echo "<p>Erro na consulta de tweets</p>";
}








 ?>