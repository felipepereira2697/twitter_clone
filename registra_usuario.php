<?php
echo '<link rel="stylesheet" type="text/css" href="customStyle.css">';
//fazer a inclusão do arquivo que realiza a conexão com o banco de dados
require_once 'db.class.php';
//recuperamos os dados aqui
//$_POST e $_GET são arrays associativos. no caso do post, esse array é populado com o NAME que vc deu para o campo no form
//GET vai tudo pela URL, pode ser perigoso em determinados casos
$usuario =  $_POST['usuario'];
$email =  $_POST['email'];
$usuario_existe = false;
$email_existe = false;

//criptografando para md5, poderiamos utilizar o SHA1 também
//retorna um hash com 32 posições
$senha =  md5($_POST['senha']);

//instância da classe db
$objDb = new db();
//retorna um link de conexão
//recebe o retorno da conexão mysql
$link = $objDb->conecta_mysql();
//verificar se o usuário existe no bd
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
if($resultado_id = mysqli_query($link,$sql)){
	$dados_usuario  = mysqli_fetch_array($resultado_id);
	if($dados_usuario['usuario']){
		$usuario_existe = true;
	}

}else{
	echo "<p>Erro ao tentar localizar o registro de usuário</p>";
}


//verificar se o email existe

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
if($resultado_id = mysqli_query($link,$sql)){
	$dados_usuario = mysqli_fetch_array($resultado_id);
	if($dados_usuario['email']){
		$email_existe = true;
	}
}else{
	echo "<p>Erro ao tentar localizar o registro de email</p>";
}

//se um dos dois ja existir forçaremos ele a voltar para inscrição
if($usuario_existe || $email_existe){
	$retorno_get = null;

	if($usuario_existe){
		$retorno_get.= "erro_usuario=1&";
	}
	if($email_existe){
		$retorno_get .= "erro_email=1&";
	}
	header('Location: inscrevase.php?'.$retorno_get);
	//nao deixando continuar a aplicação, o die mata aqui
	die()
}

//aspas duplas antes de ser atribuido o valor a variavel, ela checa se dentro da 
//string possuí alguma variavel, se sim ela converte o valor da variavel para onde a variavel faz referencia
//inserindo usuários no bd
$sql = "INSERT INTO usuarios(usuario,email,senha) VALUES('$usuario','$email','$senha') ";
//executar a query
//quando a função mysqli_query possuí algum erro de sintaxe ela retorna o valor false
//vamos testar a nossa query
if(mysqli_query($link,$sql)){
	echo "<p>Usuário registrado com sucesso</p>";
}else{
	echo "<p>Erro ao registrar o usuário</p>";
}

?>