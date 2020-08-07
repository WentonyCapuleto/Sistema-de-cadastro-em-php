<?php
	require_once('usuario.php');
	$u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<title>Cadastro</title>
</head>
<body>
<div class="img-cima">
<img src="imagens/logo.png" alt="Logo Eniac">
</div>
		<div class="cont">
		<section>
			<h1>Cadastrar</h1>
			<form method="POST">
				<input type="text" name="nome_projeto" placeholder="Nome do Projeto" maxlength="30">
				<input type="text" name="nome_grupo" placeholder="Nome do Grupo" maxlength="40">
				<input type="data" name="data" placeholder="Data" maxlength="32">
				<input type="submit" value="CADASTRAR">
			</form>
		</section>
		<?php
		// verificar se clicou no botao

		if(isset($_POST['nome'])){
			$nome_projeto = addslashes($_POST['nome_projeto']);
			$nome_grupo = addslashes($_POST['nome_grupo']);
			$data = addslashes($_POST['data']);

			//verificar se esta preenchido
			if(!empty($nome_projeto) && !empty($nome_grupo) && !empty($data)){
				$u->conectar("projeto_tcc","localhost","root","");
				if($u->msgErro == ""){
						if($u->cadastraprojeto($nome_projeto,$nome_grupo,$data)){
							?>
							<form id='form' action='index.php' method='POST'>
								<input type='hidden' name='tipo' value='cadastro'>
								<input type='submit'>
							</form>
							<script>
								document.getElementById('form').submit()
							</script>
							<?php
						}else{
							?>
							<div class="msg-erro">
							Nome ja Cadastrado!
							</div>
							<?php
						}			
				}else{
					?>
					<div class="msg-erro">
					<?php echo "ERRO: ".$u->msgErro;?>
				</div>
					<?php
				}
			}else{
				?>
				<div class="msg-erro">
				...!
				</div>
				<?php
				}
			}
		?>
	</div>
</body>
</html>