<?php 
//por ser uma página restrita da nossa aplicação precisamos fazer algumas tratativas
session_start();

if(!isset($_SESSION['usuario'])){
	header('Location: index.php?erro=1');
}

require_once 'db.class.php';

$id_usuario = $_SESSION['id_usuario'];
$nome_pessoa = $_POST['nome_pessoa'];

$objDb = new db();
$link = $objDb->conecta_mysql();

//a clausula AND id<> $id_usuario é para evitar que traga vc como resultado de alguém que pode seguir, 
//não tem lógica vc seguir vc mesmo
$sql = " SELECT * FROM usuarios WHERE usuario LIKE '%$nome_pessoa%' AND id <> $id_usuario";

//resultado id contém a referencia p/ o conteúdo externo ao php
$resultado_id = mysqli_query($link,$sql);
if($resultado_id){
	//para cada iteração a variavel registro vai receber um registro do bd, vai acontecer até o ultimo registro
	while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
		//a ideia aqui é usar a classe list-group-item do bootstrap, por isso usamos o link
		//vale lembrar que a div que conterá os tweets, possuí a class list-group
		echo '<a href="#" class="list-group-item"> ';
			echo '<strong>'.$registro['usuario'].'</strong> <small>'.$registro['email'].'</small>';
		echo '</a>';
	}
}else{
	echo "<p>Erro na consulta de usuários</p>";
}








 ?>