<?php
//para autenticar usuario usando session, precisamos indicar para o php que estamos
//trabalhando com sessao
//session_start() algo do genero
//geralmente é o primeiro comando da nossa app, nunca vem depois de uma saida de dados no navegador

//esse comando indica ao script que ele terá acesso as variaveis de sessão, sempre colocamos no inicio do script
//deve vir antes de qualquer echo/print var_dump, ou qualquer estrutura de output
session_start();

require_once 'db.class.php';


//receber as infos através do post
$usuario = $_POST['usuario'];
//criptografando aqui também para não ocorrer problema de comparação de hash
$senha = md5($_POST['senha']);

//checar se ja possuimos o registro passado no bd
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha' ";
$objDb =  new db();
$link = $objDb->conecta_mysql();

//executando a consulta, no caso do select, caso dê certo, é retornado um resource
//onde podemos recuperar com um array
//resultado id, referencia para o resource, referencia para uma info externa do php
$resultado_id = mysqli_query($link,$sql);

if($resultado_id){
	//esse teste não tem nada a ver com o fato de ter registro no bd ou não
	//ele apenas checa se foi tudo passado corretamente na consulta
	//se for true
	//retornando em forma de array
	$dados_usuario = mysqli_fetch_array($resultado_id);
	//var_dump($dados_usuario) retorna null caso não exista
	//checamos se dentro do retorno, existe um usuário
	if(isset($dados_usuario['usuario'])){

		//realizando trativas, evitando acesso direto à essa página com o recurso de session
		//essa variavel session passa a receber a variavel do retorno dos dados do usuário.
		//aqui nesse array dados usuário temos os valores retornados conforme o sql que passamos
		//a partir do momento que atribuimos variaveis de sessão, ela passa a valer para toda
		//a aplicação, vamos até a página home.php recuperar esses dados.
		$_SESSION['usuario'] = $dados_usuario['usuario'];
		$_SESSION['email'] = $dados_usuario['email'];

		//ja que a validação ocorreu corretamente aqui, podemos redirecionar para uma pag restrita
		header('Location: home.php');
	}else{
		//logo não há nada no banco de dados para ser retornado
		//vamos forçar um redirecionamento para a página index
		//quando queremos forçar o redirecionamento, podemos inclusive colocar parâmetros na url
		//parametros que portanto podem ser recuperados via GET
		header('Location: index.php?erro=1');
	}
	
}else{
	echo "<p>Erro na execução da consulta, por favor, entre em contato com o admin do site</p>";
}



//my sql query pode retornar falso caso dê algum erro(podendo ser de sintaxe)
//se deu certo ela retorna um resource que é uma informação externa ao php

?>