
<?php
	
	//session, semelhante ao post ou get, a diferença é que ela fica possivel durante todo o escopo da nossa app
	//enquanto estivermos com o navegador aberto aquela variavel session está disponivel, sem necessidade
	//de ficar transportando os dados via get ou post
	session_start();
	//verificar se na sessão existe um usuário, caso não exista vamos redirecionar
	//caso o usuário não passe pela validação
	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	$id_usuario = $_SESSION['id_usuario'];
	//recuperar a qtde de tweets
	require_once 'db.class.php';
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "SELECT  COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $id_usuario";



	$resultado_id = mysqli_query($link,$sql);

	$qtde_tweets = 0;


	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_tweets =  $registro['qtde_tweets'];
	}else{
		echo "Houve um erro ao executar a query";
	}


	//recuperar a qtde de seguidores

	$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario";



	$resultado_id = mysqli_query($link,$sql);

	$qtde_seguidores = 0;


	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_seguidores =  $registro['qtde_seguidores'];
	}else{
		echo "Houve um erro ao executar a query";
	}


?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Procurar pessoas</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script type="text/javascript">
			//usando jQuery
			$(document).ready(function(){
				//associar o evento de clique ao botão
				$('#btn_procurar_pessoa').click(function(){
					//recuperando oq tem dentro do campo de texto
					
					//garantir que não tenha nome vazio
					if($('#nome_pessoa').val().length > 0){
						//requisição ajax para envio de alguma coisa, podemos usar para formulários por exemplo
						$.ajax({
							//o ajax espera parametros json
							//queremos encaminhar o que vamos escrever no tweet para a pagina inclui_tweet.php
							//para onde vamos enviar
							url:'get_pessoas.php',
							method:'post',
							//criamos um json contendo a chave e o valor contido no campo texto_tweet
							//quais serão as informções enviadas para o script
							//a função serialize com base no form retorna um json que pode ser atribuido
							//a funçâo data, facilita muito quando queremos encaminhar os dados de um form
							//que é muito grande
							data: $('#form_procurar_pessoas').serialize(),
							//caso haja sucesso, oq devemos fazer é recuperar o text
							success: function(data){
								
								$('#pessoas').html(data);

								$('.btn_seguir').click(function(){
									//capturar o atributo relativo ao botão clicado
									//passando o this o proprio elemento clicado
									//a função data espera um parametro, exatamente nosso atributo customizado
									//onde data- é o préfixo logo não é necessário passa lo
									var id_usuario = $(this).data('id_usuario');


									//varia de acordo com o id do usuário
									$('#btn_seguir_'+id_usuario).hide();
									$('#btn_deixar_seguir_'+id_usuario).show();
									//agora vamos usar o ajax para fazer a requisição de um script para nós
									$.ajax({
										url:'seguir.php',
										method: 'post',
										data:{seguir_id_usuario : id_usuario},
										success: function(data){
											alert('Registro efetuado com sucesso');
										}
									});
								}); 
								$('.btn_deixar_seguir').click(function(){
									var id_usuario = $(this).data('id_usuario');

									//varia de acordo com o id do usuário
									$('#btn_deixar_seguir_'+id_usuario).hide();
									$('#btn_seguir_'+id_usuario).show();

									$.ajax({
										url: 'deixar_seguir.php',
										method: 'post',
										data:{deixar_seguir_id_usuario : id_usuario},
										success: function(data){
											alert('Registro removido com sucesso');	
										}
									});
								});
							}
						});
					}
				});
				

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
	            <li><a href="home.php">Home</a></li>
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
	    					<p><?= $qtde_tweets ?></p>
	    				</div>		
	    				<div class="col-md-6">
	    					<p>Seguidores</p>
	    					<p><?= $qtde_seguidores ?></p>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    	<div class="col-md-6">
	    		<!--Aqui é onde ficaram os tweets -->
	    		<div class="panel panel-default">
	    			<div class="panel panel-body">
	    				<form id="form_procurar_pessoas" class="input-group">
	    				<!-- dando id's para facilitar a manipulação com o JS -->
	    				<!-- a função serialize() precisa que o elemento tenha um name pra usá-lo como chave do json -->
	    					<input type="text" id="nome_pessoa"  name="nome_pessoa" class="form-control" placeholder="Quem você está procurando?" maxlength="140">
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn_procurar_pessoa" type="button">Procurar</button>
	    					</span>
	    				</form>
	    			</div>
	    		</div>
	    		<div id="pessoas"  class="list-group">
	    			
	    		</div>
	    	</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel panel-body">
						
					</div>
				</div>
			</div>

		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>
