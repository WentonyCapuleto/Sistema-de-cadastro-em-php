<?php
Class Usuario
{
	private $pdo;
	public $msgErro = "";

	public function conectar($nome, $host, $usuario, $senha)
	{
		global $pdo;
		try
		{
		$pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
	}
	 catch (PDOException $e) {
		global $msgErro;
		$msgErro = $e->getMessage();
	}
	}

	public function cadastrar($nome, $email, $senha)
{
	global $pdo;
	//verificar no bd se ja existe o email cadastrado
	$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
	$sql->bindValue(":e",$email);
	$sql->execute();

	if($sql->rowCount() > 0){
		return false; //ja cadastrou
	}else{

		//se n cadastrou então se cadastre
		$sql = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)");

		$sql->bindValue(":n", $nome,PDO::PARAM_STR);
		$sql->bindValue(":e", $email,PDO::PARAM_STR);
		$sql->bindValue(":s", md5($senha),PDO::PARAM_STR) ;
		$sql->execute();
		return true;
	}
}

	public function logar($email, $senha)
	{
		global $pdo;
		//verificar se o email e senha estão corretos
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
		$sql->bindValue(":e",$email,PDO::PARAM_STR);
		$sql->bindValue(":s",md5($senha),PDO::PARAM_STR);
		$sql->execute();

		//entrar no sistema
		if($sql->rowCount() > 0){
			$dado = $sql->fetch();
			session_start();
			$_SESSION['id_usuario'] = $dado['id_usuario'];
			return true; //login com sucesso
		}else{
			return false;//não logou
		}
	}

	public function esqueceusenha($email, $nscriptografada){

		global $pdo;
		//ver se o email existe p poder ter a nova senha
		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :e");
		$sql->bindValue(":e",$email,PDO::PARAM_STR);
		$sql->execute();

		//verificando se tem email
		if($sql->rowCount() > 0){
			$dado=$sql->fetch();
			$sql2 = $pdo->prepare("SELECT * FROM recuperarSenha WHERE id_usuario = :i");
			$sql2->bindValue(":i",$dado['id_usuario'],PDO::PARAM_STR);
			$sql2->execute();
			$token=md5(md5(uniqid($email, true)));
			if($sql2->rowCount()>0){
				$sql3 = $pdo->prepare("UPDATE recuperarSenha SET token = :t WHERE id_usuario = :i");
			}else{
				$sql3 = $pdo->prepare("INSERT INTO recuperarSenha(id_usuario,token) values(:i,:t)");
			}
			$sql3->bindValue(":t",$token,PDO::PARAM_STR);
			$sql3->bindValue(":i",$dado['id_usuario'],PDO::PARAM_STR);
			$sql3->execute();
			
			$to = $email;
			$subject = 'Pedido de recuperação de senha';
			$message = '<html>
							<head>
								<title>Pedido de recuperação de senha</title>
							</head>
							<body>
								<span><a href="localhost/sistema/recuperarsenha.php?token='.$token.'">Clique aqui</a> para alterar sua senha</span>
							</body>
						</html>';
			$headers = 'From: webmaster@example.com' . "\r\n" .
			'Reply-To: webmaster@example.com' . "\r\n" .
			'MIME-Version: 1.0' . "\r\n" .
			'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			mail($to, $subject, $message, $headers);
			return true;//email enviado
		}else{
			return false;//email n enviado
		}
}

	/*public function buscaprojeto($nome_projeto){
		global $pdo

		$sql=$pdo->prepare("SELECT * FROM projetos WHERE nome_projeto LIKE '%:n%' LIMIT '15'");
		$sql->bindValue(":n",$nome_projeto,PDO::PARAM_STR);
		$sql->execute();

		if($sql->rowCount() > 0){
			$dado = $sql->fetch();
			return $dado; //Achou o projeto
		}else{
			return false;//não achou
		}
	}*/

	public function cadastraprojeto($nome_projeto,$nome_grupo,$data){
		global $pdo;
	//verificar no bd se ja existe o email cadastrado
	$sql = $pdo->prepare("SELECT id_projeto FROM projetos WHERE nome_projeto = :np AND nome_grupo = :ng");
	$sql->bindValue(":np",$nome_projeto);
	$sql->bindValue(":ng",$nome_projeto);
	$sql->bindValue(":d",$data);
	$sql->execute();

	if($sql->rowCount() > 0){
		return false; //ja cadastrou
	}else{

		//se n cadastrou então se cadastre
		$sql = $pdo->prepare("INSERT INTO projetos (nome_projeto, nome_grupo, data) VALUES (:np, :ng, :d)");

		$sql->bindValue(":np", $nome_projeto,PDO::PARAM_STR);
		$sql->bindValue(":ng", $nome_grupo,PDO::PARAM_STR);
		$sql->bindValue(":d", $data,PDO::PARAM_STR) ;
		$sql->execute();
		return true;
	}
	}
}
?>