<?php

$cod = 0;
$msg = array('mensagem' => file_get_contents('confirmeEmail.html'), 'erro' => 0);

if($_GET)$cod = $_GET['cod']; 


$link = mysqli_connect('localhost', 'root', '');
if($link){
	$pegaDados = mysqli_query($link,"SELECT * FROM fireedev.tbl_usuario WHERE usu_codigo_confirmacao = '" . $cod . "'");
	$num_rows = mysqli_num_rows($pegaDados);
	if($num_rows > 0){
		$usuario = mysqli_fetch_assoc($pegaDados);		
		if($usuario){			
			$msg['mensagem'] = str_replace('[cod]', $usuario['usu_codigo_confirmacao'], $msg['mensagem']); 
			$msg['mensagem'] = str_replace('[apelido]', $usuario['usu_apelido'], $msg['mensagem']); 
		}
	}else{
		$msg['mensagem'] = "Usuário não encontrado!";
		$msg['erro'] = 1;
	}
	
}else{
	$msg['mensagem'] = "Erro na conexão do banco de dados!";
	$msg['erro'] = 1;
}


/*--------------------------------------------*/

echo utf8_encode($msg['mensagem']);

?>