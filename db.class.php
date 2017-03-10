<?php

class db{

	//host, endereço de onde o banco de dados está instalado
	//usamos o localhost pois a instância do mysql está no mesmo local que o servidor apache
	private $host = 'localhost';
	//usuario padrão de instalação do MySQL
	private $usuario = 'root'; 
	//senha
	private $senha = '';
	//banco de dados
	private $database = 'twitter_clone';

	//criar a função que executará a comunicação entre o PHP e o Mysql

	public function conecta_mysql(){
		//criando a conexão
		$con  = mysqli_connect($this->host,$this->usuario,$this->senha,$this->database);
		//ajustar o charset de comunicação entre a aplicação e o bd
		//praticamente zerando a chance de erros com caracteres
		mysqli_set_charset($con, 'utf8');

		//verificar se houve erro na conexão com o bd
		//se não for zero é pq deu erro
		if(mysqli_connect_errno()){
			echo "<p>Houve um erro ao tentar se conectar com o banco de dados MySQL</p> ".mysqli_connect_error();
		}
		//retorna o objeto de conexão
		return $con;
	}

}

?>