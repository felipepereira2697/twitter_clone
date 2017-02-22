<?php
//fazer a inclusão do arquivo que realiza a conexão com o banco de dados
require_once 'db.class.php';
//recuperamos os dados aqui
//$_POST e $_GET são arrays associativos. no caso do post, esse array é populado com o NAME que vc deu para o campo no form
//GET vai tudo pela URL, pode ser perigoso em determinados casos
$usuario =  $_POST['usuario'];
$email =  $_POST['email'];

//criptografando para md5, poderiamos utilizar o SHA1 também
//retorna um hash com 32 posições
$senha =  $_POST['senha'];

//instância da classe db
$objDb = new db();
//retorna um link de conexão
//recebe o retorno da conexão mysql
$link = $objDb->conecta_mysql();
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