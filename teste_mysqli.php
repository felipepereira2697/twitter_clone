<?php
require_once 'db.class.php';



//checar se ja possuimos o registro passado no bd
$sql = "SELECT * FROM usuarios ";
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
	//para relatorios queremos o retorno do indice numérico apenas, podemos passar como parâmetro
	//muito bom para relatórios
	//$dados_usuario = mysqli_fetch_array($resultado_id,MYSQLI_NUM);

	//index associativo
	$dados_usuario = array();
	//consertando o problema de retornar só uma linha 


	//Dessa forma podemos trabalhar com n registros
	while($linha = mysqli_fetch_array($resultado_id,MYSQLI_ASSOC)){
		//retorno de cada linha da nossa coluna
		//usando indice dinâmico
		$dados_usuario[] = $linha;
	}
	//percorrendo cada indice do array
	//cada indice dentro do array $dados_usuario[] é um usuario
	foreach($dados_usuario as $usuario){
		//VÁRIAS POSSIBILIDADES AQUI
		var_dump($usuario['email']);
		//podemos usar o echo tbm
		echo "<p>".$usuario['usuario'].'</p>';
		//var_dump($usuario);
		echo "<br><br>";
	}
	//var_dump($dados_usuario) retorna null caso não exista
	//checamos se dentro do retorno, existe um usuário
	//inicialmente a função mysqli_fetch_array traz somente um registro
	
	
	
}else{
	echo "<p>Erro na execução da consulta, por favor, entre em contato com o admin do site</p>";
}

?>