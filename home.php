<?php
//recuperando a sessão
session_start();//iniciando a sessao
//bloquear o acesso para a home deixando somente o usuário que se autenticou acesse-a
if(!isset($_SESSION['usuario'])){
	header("Location: index.php?erro=1");
}
require_once('bd.class.php');

$objBd = new bd();
$objBd->conecta_mysql();

//quantidade de tweets
//recuperar o arquivo de conexao com o bd
$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $id_usuario";
$resultado_id = mysql_query($sql);
$qtde_tweets = mysql_fetch_array($resultado_id);

//quantidade de seguidores
$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario";
$resultado_id = mysql_query($sql);
$qtde_seguidores = mysql_fetch_array($resultado_id);


?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			$(document).ready(function(){

				//verificaar se o botão de tweet foi clicado e a partir disso dar inicio aos comandos
				$('#btn_tweet').click(function(){
					//recuperar oq está no texto
					
					//verificar se o campo de texto tem ao menos tem um caracter
					if($('#txt_tweet').val().length>0){
						//vamos usar o ajax para chamar o arquivo de incluir tweet
						$.ajax({
							url:'inclui_tweet.php',
							method: 'post',
							//a funcao serialize pega os campos do form e colocar os campos em uma estrutura json, estrutura chave valor
							data: $('#form_tweet').serialize(),
							success: function(data){
								$('#txt_tweet').val('');
								//chamamos o atualizatweets aqui tbm, para que o usuário não tenha que dar refresh
								//na página para ver seu novo post		
								atualizaTweets();
							}
						});
					}
				});

				function atualizaTweets(){
					//carregar os tweets 

					$.ajax({
						url: 'get_tweet.php',
						method: 'post',
						//data = retorno da requisição, retorno do nosso response text
						success:function(data){
							//função html do jquery nada mais é  do que o innerHTML
							$('#tweets').html(data);
						}

					});
				}

				//chamar a função
				atualizaTweets();

			});
		</script>
	
	</head>
	<!-- Aula 265 faremos a inclusao de novos usuarios, criando um arquivo php que receberá os dados do formulario
	criar uma classe de conexao com o bd, estabelecer a logica necessária para inserir os dados em uma tabela do bd
	criaremos o bd tbm e uma tabela para receber esses dados -->
	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    
	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    		<!-- exibir o usuário recuperado pela variavel session -->
	    			<div class = "panel-body">
	    				<h4><?= $_SESSION['usuario']?></h4>

	    				<!-- mostrar os seguidores e quem você segue -->
	    				<hr />

	    				<div class="col-md-6">
	    					TWEETS <br /><?= $qtde_tweets['qtde_tweets']?>
	    				</div>

	    				<div class="col-md-6">
	    					SEGUIDORES <br /><?= $qtde_seguidores['qtde_seguidores']?>
	    				</div>

	    			</div>
	    		</div>
	    	</div>
	    	<!-- div central -->
	    	<div class="col-md-6">
	    		<div class = "panel panel-default">
	    			<div class = "panel-body">
	    				<!-- campo input de texto com 140 caracteres -->
	    				<form id="form_tweet">
		    				<div class="input-group">
		    				<!-- este campo de texto será armazenado no bd  usando ajax com auxilio do jquery-->
		    					<input type="text" class="form-control" id="txt_tweet" name="txt_tweet" placeholder="O que está acontecendo agora" maxlength="140">
		    					<span class="input-group-btn">
		    						<button class="btn btn-default" id="btn_tweet" type="button">tweet</button>
		    					</span>
		    				</div>
		    			</form>
	    			</div>
	    		</div>
	    		<div id="tweets" class="list-group">
	    			<!-- retorno da nossa requisição -->

	    		</div>
	    	</div>
	    	
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><a href="procurar_pessoas.php">Procurar por pessoas</a></h4>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>
			
		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>