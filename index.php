<?php 
//recuperar a variavel que está na url, via GET
//um problema, se tirarmos a variavel da url, obteremos um Undefined index, podemos corrigir
//checando se ele existe antes de atribui-lo a qualquer variavel
	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
	//se tal coisa for true, então após o ? é executado algo, caso seja false, após o : é executada outra função
	

 ?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>

		<!-- jquery - link cdn -->
		<!-- Não usei uma versão atual do jquery pois tinha problema de compatibilidade
				com o bootstrap, provavelmente assim que a lib e o framework estiverem 
				compativeis, atualizo aqui

		 -->
		<script
		  src="https://code.jquery.com/jquery-2.2.4.min.js"
		  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
		  crossorigin="anonymous">
		  	
		 </script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="customStyle.css">
	
		<script>
			//código javascript, validação dos campos, só vamos enviar o formulário
			//caso o preenchimento tenha ocorrido
			//quando clicar no botão de entrar, manipularemos esse jquery aqui
			$(document).ready(function(){

				//verificar se os campos de usuario e senha foram preenchidos 
				$('#btn_login').click(function(){
					//caso um dos campos esteja vazio, o formulário não pode ser preenchido
					var campo_vazio = false;
					//checando se o campo usuário não é vazio
					if($("#campo_usuario").val() == ''){
						//mudar o visual do campo vazio, facilitando pro usuário
						//passando um json
						$('#campo_usuario').css({'border-color':'#A94442'});
						campo_vazio = true;
					}else{
						//se o campo estiver preenchido, mudamos um pouco o css
						$('#campo_usuario').css({'border-color':'#ccc'});
					}
					//o mesmo vale para o campo senha
					if($('#campo_senha').val() == ''){
						$('#campo_senha').css({'border-color': '#A94442'});
						campo_vazio = true;
					}else{
						$('#campo_senha').css({'border-color':'#ccc'});
					}
					//se for verdade que tem um campo vazio, impedimos que o formulário seja submetido
					if(campo_vazio) return false;
				});
			});

		</script>
	</head>

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
	            <li><a href="inscrevase.php">Inscrever-se</a></li>
	            <!--adicionando um pouco de PHP aqui para forçar o menu a vir aberto em caso de erro -->
	            <!-- caso haja o erro, forçamos para que o php escreva open, que é o nome da classe  usada-->
	            <li class="<?= $erro ==1 ? 'open':''?>">
	            	<a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrar</a>
					<ul class="dropdown-menu" aria-labelledby="entrar">
						<div class="col-md-12">
				    		<p>Você possui uma conta?</h3>
				    		<br />
				    		<!-- enviar esse form para uma pagina php para que ele trate as infos recebidas -->
				    		<!-- outra coisa legal no formulário é que caso não seja preenchido nenhum dado
							ao clicar em entrar ele valide, antes da submissaoo pro php, se os campos estão preenchidos
							podemos fazer isso usar jquery
				    		-->
							<form method="post" action="validar_acesso.php" id="formLogin">
								<div class="form-group">
									<input type="text" class="form-control" id="campo_usuario" name="usuario" placeholder="Usuário" />
								</div>
								
								<div class="form-group">
									<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" />
								</div>
								
								<button type="buttom" class="btn btn-primary" id="btn_login">Entrar</button>

								<br /><br />
							</form>
							<?php 
								//verificando se o parametro que veio da url é igual a 1, caso
								//seja é pq ocorreu um erro de autenticação
								if($erro==1){
									echo "<p class='erroMsg1'>Usuário ou senha inválidos</p>";
								}

							 ?>
						</form>
				  	</ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	      <!--  -->
	      <div class="jumbotron">
	        <h1>Bem vindo ao twitter clone</h1>
	        <p>Veja o que está acontecendo agora...</p>
	      </div>

	      <div class="clearfix"></div>
		</div>


	    </div>
		
		<!-- sempre deixar esse link aqui, depois de tudo, evitando bugs -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>