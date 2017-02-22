
<?php
//colocando autenticacao, de forma que uma pessoa q não está autenticada não consiga fazer uma requisicao
// para essa página, impedindo invasão
session_start();//iniciando a sessao
//bloquear o acesso para a home deixando somente o usuário que se autenticou acesse-a
if(!isset($_SESSION['usuario'])){
	header("Location: index.php?erro=1");
}
/*recuperando o campo de texto do tweet que está la no home, usando ajax e via POST*/
require_once('bd.class.php');

$id_usuario = $_SESSION['id_usuario'];
$nome = $_POST['txt_nome'];
//instância da classe bd
$objBd = new bd();
$objBd->conecta_mysql();	

//vamos criar uma consulta que permita recuperar os tweets do banco de dados
//com base no id do usuário é que saberemos qual tweet mostrar
//date format função do sql 
$sql =  " SELECT u.*, us.id_usuario_seguidor FROM usuarios AS u";
$sql .= " LEFT JOIN usuarios_seguidores AS us ON (u.id=us.seguindo_id_usuario AND us.id_usuario = $id_usuario) ";
$sql .= " WHERE u.usuario like '%$nome%' AND u.id <> $id_usuario";

$resultado_id = mysql_query($sql);

if($resultado_id){
	//precisamos de uma estrutura de repetição para percorrer isto

	while($pessoa = mysql_fetch_array($resultado_id)){
		
		$esta_seguindo_usuario_sn = isset($pessoa['id_usuario_seguidor']) && !empty($pessoa['id_usuario_seguidor']) ? 'S' : 'N';

		echo'<a href="#" class="list-group-item">';
			echo '<strong>'.$pessoa['usuario'].'</strong> <small> - '.$pessoa['email'].'</small>';
			echo'<p class="list-group-item-text pull-right">';

				$btn_seguir_display = 'block';
				$btn_deixar_seguir_display = 'block';
				//verificar qual botão vc vai desabilitar

				if($esta_seguindo_usuario_sn == 'N'){
					$btn_deixar_seguir_display = 'none';
				}

				if($esta_seguindo_usuario_sn=='S'){
					$btn_deixar_seguir_display = 'none';
				}

				//utilizar um atributo no html 5 customizável para pegar determinada informação
				//colocando o id do usuário através de um atributo html 5 customizável
				echo '<button type="button" class="btn btn-default btn_seguir" id="seguir_'.$pessoa['id'].'" style="display:'.$btn_seguir_display.'" data-id_usuario="'.$pessoa['id'].'">Seguir</button>';

				echo '<button type="button" class="btn btn-primary btn_deixar_seguir" id="deixar_seguir_'.$pessoa['id'].'" data-id_usuario="'.$pessoa['id'].'" style="display:'.$btn_deixar_seguir_display.'">Deixar de seguir</button>';
			echo '</p>';
			//para consertar o problema de quebra, que fica desajustando o botão seguir
			echo '<div class="clearfix"></div>';
		echo '</a>';
	}
	


}else{

	echo 'deu ruim na consulta';
}

?>