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

$sql = "SELECT * FROM tweet WHERE id_usuario = $id_usuario ORDER BY data_inclusao DESC";

//resultado id contém a referencia p/ o conteúdo externo ao php
$resultado_id = mysqli_query($link,$sql);
if($resultado_id){
	//para cada iteração a variavel registro vai receber um registro do bd, vai acontecer até o ultimo registro
	while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
		print_r($registro);
		echo "<br>";
	}
}else{
	echo "<p>Erro na consulta de tweets</p>";
}








 ?>