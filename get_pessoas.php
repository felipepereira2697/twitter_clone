<?php 
//por ser uma página restrita da nossa aplicação precisamos fazer algumas tratativas
session_start();

if(!isset($_SESSION['usuario'])){
	header('Location: index.php?erro=1');
}

require_once 'db.class.php';

$id_usuario = $_SESSION['id_usuario'];
$nome_pessoa = $_POST['nome_pessoa'];

$objDb = new db();
$link = $objDb->conecta_mysql();

//a clausula AND id<> $id_usuario é para evitar que traga vc como resultado de alguém que pode seguir, 
//não tem lógica vc seguir vc mesmo
$sql = 	" SELECT u.*, us.* ";
$sql .= " FROM usuarios AS u ";
$sql .= " LEFT JOIN usuarios_seguidores AS us ";
$sql .= " ON (us.id_usuario = $id_usuario AND u.id = us.seguindo_id_usuario) ";
$sql .= " WHERE u.usuario LIKE '%$nome_pessoa%' AND u.id <> $id_usuario ";

//resultado id contém a referencia p/ o conteúdo externo ao php
$resultado_id = mysqli_query($link,$sql);
if($resultado_id){
	//para cada iteração a variavel registro vai receber um registro do bd, vai acontecer até o ultimo registro
	while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
		//a ideia aqui é usar a classe list-group-item do bootstrap, por isso usamos o link
		//vale lembrar que a div que conterá os tweets, possuí a class list-group
		echo '<a href="#" class="list-group-item"> ';
			echo '<strong>'.$registro['usuario'].'</strong> <small>'.$registro['email'].'</small>';
			echo '<p class="list-group-item-text pull-right">';
				//para pegar o id de quem queremos seguir, vamos utilizar umm atributo customizável
				//para manipular com JS
				//para que cada um dos botões tenha esse atributo data-id_usuario com o id_usuario do banco de dados

				//criar uma variavel para verificar se o registro possui uma variavel id_usuario_seguidor
				$esta_seguindo_usuario_sn = isset($registro['id_usuario_seguidor']) && !empty($registro['id_usuario_seguidor']) ? 'S' : 'N'; 

				$btn_seguir_display = 'block';
				$btn_deixar_seguir_display = 'block';
				//com base nesse teste saberemos quem devemos ocultar
				if($esta_seguindo_usuario_sn == 'S'){
					$btn_seguir_display = 'none';

				}else{
					$btn_deixar_seguir_display = 'none';
				}
				//concatenmaos o registro['id'] no id do botão para que cada botão tenha uma identidade única
				echo '<button type="button" id="btn_seguir_'.$registro['id'].'" style="display:'.$btn_seguir_display.'"  class="btn btn-primary btn_seguir" data-id_usuario="'.$registro['id'].'">Seguir</button>';
				echo '<button type="button" id="btn_deixar_seguir_'.$registro['id'].'" style="display:'.$btn_deixar_seguir_display.'" class="btn btn-danger btn_deixar_seguir" data-id_usuario="'.$registro['id'].'">Deixar de seguir</button>';
			echo '</p>';
			//quando usamos o pull right o elemento perde a noção do espaçamento, para isso usaremos o clearfix
			echo '<div class="clearfix"></div>';
		echo '</a>';
	}
}else{
	echo "<p>Erro na consulta de usuários</p>";
}








 ?>