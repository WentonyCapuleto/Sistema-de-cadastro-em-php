<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id='cont'>
        <?php
            require_once('usuario.php');
            $u=new Usuario;
            $u->conectar('projeto_tcc','localhost','root','');
            $token=addslashes($_GET['token']);
            $sql=$pdo->prepare('SELECT * FROM recuperarsenha WHERE token=:t');
            $sql->bindValue(':t',$token,PDO::PARAM_STR);
            $sql->execute();
            $dado=$sql->fetch();
            if($sql->rowCount()==0){
                Header("location:index.php");
            }
            if(isset($_POST['senha'])){
                $sql1=$pdo->prepare('UPDATE usuarios SET senha=:s WHERE id_usuario=:i');
                $sql1->bindValue(':s',md5($_POST['senha']),PDO::PARAM_STR);
                $sql1->bindValue(':i',$dado['id_usuario'] ,PDO::PARAM_STR);
                $sql1->execute();
                ?>
                    <form method='POST' id='form' action='index.php'>
                        <input type='hidden' name='tipo' value='recuperar senha'>
                        <input type='submit'>
                    </form>
                    <script>document.getElementById('form').submit()</script>
                <?php
            }
        ?>
        <h1>Recuperar Senha</h1>
        <form method='POST'>
            <input type='hidden' name='tipo' value='recuperar senha'>
            <input type='password' name='senha' placeholder='Digite sua senha'>
            <input type='password' name='confirmarSenha' placeholder='Confirme sua senha'>
            <input type='submit' value='Alterar Senha'>
        </form>
    </div>
</body>
</html>