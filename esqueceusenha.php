<?php
require_once('usuario.php');
$u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<title>Esqueci a senha</title>
</head>
<body>
    <div class="cont">
        <h1>Recuperar Senha</h1>
        <form method="POST">
            <input type="email" placeholder="Informe seu e-mail" name="email">
            <input type="submit" value="Recuperar">
            <a href='index.php'><strong>Voltar para a tela de login</strong></a>
        </form>
        <?php
        if(isset($_POST['email'])){

            $email = addslashes($_POST['email']);

            if(!empty($email)){
                $u->conectar("projeto_tcc","localhost","root","");
                if($u->msgErro == ""){
                    $senha = substr(md5(time()), 0, 6);
                    $nscriptografada = (md5(md5($senha)));
                    if($u->esqueceusenha($email,$nscriptografada)){
                        ?>
                        <div class="msg-sucesso">
                            Um link foi enviado ao seu email!
                        </div>
                        <div class="msg-sucesso">
                            <!-- <a href="https://gmail.com/mail/help/intl/pt_pt/about.html" target="_blank"><strong>Gmail</strong></a> -->
                        </div>
                    <?php
                    }else{
                        ?>
                        <div class="msg-erro">
                            Email nao encontrado no banco de dados!
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
                Preencha o campo corretamente!
                </div>
                <?php
            }
        }  
        ?>
    </div>
    </body>
    </html>