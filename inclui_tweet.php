<?php 
	session_start();

	//garantindo que só terá acesso se passar pela validação
	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once 'db.class.php';
	//recupera o valor da chave
	$texto_tweet = $_POST['texto_tweet'];
	$id_usuario = $_SESSION['id_usuario'];

	if($texto_tweet == ''|| $id_usuario == ''){
		die();
	}
	//instância da classe db
	$objDb = new db();
	//retorna um link de conexão
	//recebe o retorno da conexão mysql
	$link = $objDb->conecta_mysql();

	$sql = " INSERT INTO tweet(id_usuario,tweet) VALUES($id_usuario, '$texto_tweet')";
	mysqli_query($link,$sql);
			

?>