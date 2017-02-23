<?php 
//recuperar a variavel que está na url, via GET
//um problema, se tirarmos a variavel da url, obteremos um Undefined index, podemos corrigir
//checando se ele existe antes de atribui-lo a qualquer variavel
	$erro = isset($_GET['erro']?$_GET['erro'] : 0);
	//se tal coisa for true, então após o ? é executado algo, caso seja false, após o : é executada outra função
	echo $erro;

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
	
		<script>
			// verificando se os campos do form de entrada estão preenchidos
			$(document).ready(function(){
				//verificar após o carregamento do documento se o botão de entrar foi clicado
				//caso sim, então fazemos a verificação dos campos.
				//o nosso clicar = entrar tem id = btn_login
				$('#btn_login').click(function(){

					var campo_vazio = false; //caso exista, marcamos true
					if($('#campo_usuario').val()==''){
						//se o campo estiver vazio, a borda ficará vermelha
						$('#campo_usuario').css({'border-color': '#FF0000'});
						campo_vazio = true;

					}else{
						//caso  o campo esteja preenchido, marca com o cinza
						$('#campo_usuario').css({'border-color': '#ccc'});
					}


					if($('#campo_senha').val()==''){
						$('#campo_senha').css({'border-color': '#FF0000'});
						campo_vazio = true;
					}else{
						$('#campo_senha').css({'border-color': '#ccc'});
					}

					//ele não fará o envio do formulário aqui, pois o retorno é falso
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
	            <li class="<?= $erro ==1 ? 'open': '' ?>">
	            	<a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrar</a>
					<ul class="dropdown-menu" aria-labelledby="entrar">
						<div class="col-md-12">
				    		<p>Você possui uma conta?</h3>
				    		<br />
				    		<!-- enviar esse form ppara uma pagina php para que ele trate as infos recebidas -->
				    		<!-- outra coisa legal no formulário é que caso não seja preenchido nenhum dados 
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
								<?php
									if($erro==1){
										echo '<span style="color:#FF0000;">Usuário e/ou senha inválido(s)</span>';
									}
								?>
							</form>
						</form>
				  	</ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	      <!-- Main component for a primary marketing message or call to action -->
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