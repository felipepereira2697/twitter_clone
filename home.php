<?php
	
	//session, semelhante ao post ou get, a diferença é que ela fica possivel durante todo o escopo da nossa app
	//enquanto estivermos com o navegador aberto aquela variavel session está disponivel, sem necessidade
	//de ficar transportando os dados via get ou post
	session_start();
	//verificar se na sessão existe um usuário, caso não exista vamos redirecionar
	//caso o usuário não passe pela validação
	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
		alert("Deu ruim");
	}

?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Home</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script type="text/javascript">
			//usando jQuery
			$(document).ready(function(){
				//associar o evento de clique ao botão
				$('#btn_tweet').click(function(){
					//recuperando oq tem dentro do campo de texto
					
					//garantir que não tenha tweet vazio
					if($('#texto_tweet').val().length > 0){
						//requisição ajax para envio de alguma coisa, podemos usar para formulários por exemplo
						$.ajax({
							//o ajax espera parametros json
							//queremos encaminhar o que vamos escrever no tweet para a pagina inclui_tweet.php
							//para onde vamos enviar
							url:'inclui_tweet.php',
							method:'post',
							//criamos um json contendo a chave e o valor contido no campo texto_tweet
							//quais serão as informções enviadas para o script
							//a função serialize com base no form retorna um json que pode ser atribuido
							//a funçâo data, facilita muito quando queremos encaminhar os dados de um form
							//que é muito grande
							data: $('#form_tweet').serialize(),
							//caso haja sucesso, oq devemos fazer é recuperar o text
							success: function(data){
								//limpar o campo de tweet
								$('#texto_tweet').val('');
								//no sucesso da inclusão do tweet, de forma assincrona ele realiza a inserção
								//do tweet na timeline
								atualizaTweet();
							}
						});
					}
				});
				function atualizaTweet(){
					//carregar os tweets
					$.ajax({
						url: 'get_tweet.php',
						success: function(data){
							$('#tweets').html(data);
						}
					});
				}
				//para ue a requisição seja feita, precisamos executar a função
				atualizaTweet();

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
	    		<!-- Coluna esquerda, onde ficará nome e seguidos e seguidores -->
	    		<div class="panel panel-default">
	    			<div class="panel panel-body">
	    				<h4><?= $_SESSION['usuario']?></h4>
	    				<hr>
	    				<!--dentro do panel body, vamos dividir em duas colunas -->
	    				<div class="col-md-6">
	    					<p>Tweets</p>
	    					<p>1</p>
	    				</div>		
	    				<div class="col-md-6">
	    					<p>Seguidores</p>
	    					<p>1</p>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    	<div class="col-md-6">
	    		<!--Aqui é onde ficaram os tweets -->
	    		<div class="panel panel-default">
	    			<div class="panel panel-body">
	    				<form id="form_tweet" class="input-group">
	    				<!-- dando id's para facilitar a manipulação com o JS -->
	    				<!-- a função serialize() precisa que o elemento tenha um name pra usá-lo como chave do json -->
	    					<input type="text" id="texto_tweet"  name="texto_tweet" class="form-control" placeholder="What is going on?" maxlength="140">
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn_tweet" type="button">Tweet</button>
	    					</span>
	    				</form>
	    			</div>
	    		</div>
	    		<div id="tweets"  class="list-group">
	    			
	    		</div>
	    	</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel panel-body">
						<h4><a href="procurar_pessoas.php">Procurar pessoas</a></h4>
					</div>
				</div>
			</div>

		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>