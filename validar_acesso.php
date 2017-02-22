<?php
//para autenticar usuario usando session, precisamos indicar para o php que estamos
//trabalhando com sessao
//geralmente é o primeiro comando da nossa app, nunca vem depois de uma saida de dados no navegador

session_start();

//recuperar a classe do bd
require_once('bd.class.php');
//receber as infos através do post
$usuario = $_POST['usuario'];
//criptografando aqui também para não ocorrer problema de comparação de hash
$senha = md5($_POST['senha']);

//checar se ja possuimos o registro passado no bd
$sql = "SELECT id, usuario, email FROM usuarios WHERE usuario = '$usuario' AND senha='$senha' ";
//posso selecionar também somente algumas linhas da tabela, logo fazemos;
//$sql = "SELECT usuario, email WHERE usuario='usuario'AND senha = '$senha'";
$objBd = new bd();
$objBd->conecta_mysql();

//executando a consulta
$resultado_id = mysql_query($sql);
//a variavel $resultado_id contém o resource da consulta, ou seja, a informação externa ao PHP

if($resultado_id){
	//pode ter resultados  ou nao
	$dados_usuario = mysql_fetch_array($resultado_id);
	//echo $dados_usuario['usuario'].'<br><br>';
	//echo $dados_usuario['senha'];
	//verificar se houve retorno de informação
	//isset, verifica se dentro da variavel foi retornado oq vc quis
	if(isset($dados_usuario['usuario'])){
		$_SESSION["id_usuario"] = $dados_usuario['id'];
		$_SESSION["usuario"] = $dados_usuario['usuario'];
		$_SESSION["email"] = $dados_usuario['email'];
		header("Location: home.php");
	}else{
		//usuario nao existe, encaminha para a pagina de home novamente
		//nesse caso passamos um erro via get
		header("Location: index.php?erro=1");
	}
}else{
	//entra aqui caso dê erro
	echo 'Erro na execução da consulta, entre em contato com o adm do site';
}

//my sql query pode retornar falso caso dê algum erro(podendo ser de sintaxe)
//se deu certo ela retorna um resource que é uma informação externa ao php

?>