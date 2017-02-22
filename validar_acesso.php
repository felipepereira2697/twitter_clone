<?php
//para autenticar usuario usando session, precisamos indicar para o php que estamos
//trabalhando com sessao
//geralmente é o primeiro comando da nossa app, nunca vem depois de uma saida de dados no navegador

require_once 'db.class.php';


//receber as infos através do post
$usuario = $_POST['usuario'];
//criptografando aqui também para não ocorrer problema de comparação de hash
$senha = $_POST['senha'];

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
	var_dump($dados_usuario);
	
}else{
	echo "<p>Erro na execução da consulta, por favor, entre em contato com o admin do site</p>";
}



//my sql query pode retornar falso caso dê algum erro(podendo ser de sintaxe)
//se deu certo ela retorna um resource que é uma informação externa ao php

?>