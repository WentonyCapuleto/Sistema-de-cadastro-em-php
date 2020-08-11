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
		<div class="cont">
		<section>
			<h1>Cadastrar</h1>
			<form method="POST">
				<input type="text" name="nome" placeholder="Nome Completo" maxlength="40">
				<input type="email" name="email" placeholder="Email" maxlength="30">
				<input type="password" name="senha" placeholder="Senha" maxlength="32">
				<input type="password" name="confSenha" placeholder="Confirmar Senha" maxlength="20">
				<input type="submit" value="CADASTRAR">
			</form>
			<a href="index.php">Já é cadastrado?<strong> Login</strong></a> </br>
		</section>
		<?php
		// verificar se clicou no botao

		if(isset($_POST['nome'])){
			$nome = addslashes($_POST['nome']);
			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);
			$confirmarSenha = addslashes($_POST['confSenha']);

			//verificar se esta preenchido
			if(!empty($nome) && !empty($email) && !empty($senha) && !empty($confirmarSenha)){
				$u->conectar("projeto_tcc","localhost","root","");
				if($u->msgErro == ""){
					if($senha == $confirmarSenha){
						if($u->cadastrar($nome,$email,$senha)){
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
							Email já cadastrado!
							</div>
							<?php
						}
					}else{
						?>
						<div class="msg-erro">
						Senhas não coincidem!
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
				Preencha todos os campos!
				</div>
				<?php
				}
			}
		?>
	</div>
</body>
</html>