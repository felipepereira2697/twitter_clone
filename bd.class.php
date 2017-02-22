<?php

class bd{

	//estabelecendo a conexão com o mysql
	//precisamos de quatro variaveis
	//host: onde está instalado a instância do bd 
	//usuario de conexao
	//senha para a conexao
	//qual o bd que vamos manipular

	private $host = 'localhost';
	//conf do xamp default
	private $user ='root';
	private $password = '';
	//
	private $database = 'twitter_clone';

	public function conecta_mysql(){

		//estabelecendo a conexao
		//casoo a função dê algum erro, podemos "matar nossa aplicacao"
		//link de conexao
		$con = mysqli_connect($this->host,$this->user,$this->password,$this->database) ;
		//ajusta o charset de comunicacao entre o bd e a app
		mysqli_set_charset($con,"utf-8");
		//caso o bd naão exista
		

		if(mysqli_connect_errno()){
			echo "Erro ao conectar com o banco de dados". mysql_connect_error();
		}
		return $con;
	}
}

?>