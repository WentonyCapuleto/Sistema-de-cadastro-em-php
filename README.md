<?php
require_once('usuario.php');
$u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<title>Login</title>
</head>
<body>
		<div class="cont">
			<h1>Entrar</h1>
			<?php
			if(isset($_POST['tipo'])){
				switch($_POST['tipo']){
					case 'cadastro':
						?>
						<div class='msg-sucesso'>
							Cadastro realizado com sucesso!
						</div>
						<?php
					break;
					case 'recuperar senha':
						?>
						<div class='msg-sucesso'>
							Senha alterada com sucesso!
						</div>
						<?php
					break;
				}
			}
			?>
			<form method="POST">
				<input type="email" placeholder="Email" name="email">
				<input type="password" placeholder="Senha" name="senha">
				<div class='flexWrapper horizontal'>
					<input type="submit" value="ENTRAR">
					<input type="submit" class='google' value="GOOGLE">
				</div>
				<a href="cadastro.php">Ainda não é inscrito?<strong> Cadastre-se</strong></a> </br></br>
				<a href="esqueceusenha.php">Esqueceu a senha?<strong> Recupere agora!</strong></a>
			</form>
	</div>
	<?php
	if(isset($_POST['email'])){
		$email = addslashes($_POST['email']);
		$senha= addslashes($_POST['senha']);

		if(!empty($email) && !empty($senha)){
			$u->conectar("projeto_tcc","localhost","root","");
			if($u->msgErro == ""){

			if($u->logar($email,$senha)){
				header("location: acessou.php");
			}else{
				?>
				<div class="msg-erro">
				Email ou senha incorretos!
				</div>
				<?php
			}
		}else{
			?>
			<div class="msg-erro">
				<?php echo "Erro: ".$u->msgErro; ?>
			</div>
				<?php
			}
		}else{
			?>
			<div class="msg-erro>">
			Preencha todos os campos!
		    </div>
			<?php
		}
	}
	?>

</body>
</html>
