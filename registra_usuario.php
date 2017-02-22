<?php
require_once('bd.class.php');
//recuperamos os dados aqui
//$_POST e $_GET são arrays associativos. no caso do post, esse array é populado com o NAME que vc deu para o campo no form
//GET vai tudo pela URL, pode ser perigoso em determinados casos
echo $_POST['usuario'];
echo "<br>";
echo $_POST['email'];
echo "<br>";
//criptografando para md5, poderiamos utilizar o SHA1 também
//retorna um hash com 32 posições
echo $_POST['senha'];

//instância da classe bd
$objBd = new bd();
$objBd->conecta_mysql();	
$usuario_existe = false;
$email_existe = false;

//verificando se ja existe usuário com aquele email e ou username
//se essa query tiver retorno, é pq o usuário informado já está em uso
$sql =  "SELECT * FROM usuarios WHERE usuario = '$usuario'";

//my sql_query retorna false ou um resource(referencia a info externa do php).
if($resultado_id = mysql_query($sql)){
	$dados = mysql_fetch_array($resultado_id);
	//Para verificar se um usuario já existe, basta checarmos no array
	//se tem um indice com o nome 'usuario'
	//usuarios novos nao tem esse indice usuário !!!
	if(isset($dados['usuario'])){
		$usuario_existe = true;
	}
	
} else{
	echo 'Erro ao tentar localizar o registro do usuario';
}

//FAZER ******melhorar essa string sql, buscar somente o email*************
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
if($resultado_id=mysql_query($sql)){
	$dados = mysql_fetch_array($resultado_id);
	if(isset($dados['email'])){
		$email_existe = true;
	}

}else{
	echo 'Erro ao tentar localizar o registro de email no banco de dados';
}

if($usuario_existe || $email_existe){
	//forçar a alteração da página
	$retorno_get = '';
	if($usuario_existe){
		$retorno_get .= "erro_usuario=1&";
	}
	//o simbolo & significa quebra de variaveis, que estamos falando de variaveis diferentes, onde o valor de atribuição acaba
	if($email_existe){
		$retorno_get .= "erro_email=1&";
	}
	//sempre que passamos parametro por GET, devemos colocar após o .php um ? que indica o inicio da cadeia de variaveis
	header("Location: inscrevase.php?".$retorno_get);
	//para não gerar inclusões indevidas nas tabelas
	//funciona como interrupção do script, simplesmente para a execução
	//o script só para toda a execução se uma dessas informações não existir
	die();

}


$sql = "INSERT INTO usuarios(usuario,email,senha) VALUES('$usuario','$email','$senha')";

//gravar no bd
if(mysql_query($sql)){
	echo 'Usuário inserido com sucesso';
}else{
	echo 'Erro ao tentar inserir o registro';
}


?>