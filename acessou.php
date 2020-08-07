<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
header("location: index.php");
exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
                <title>Seja Bem Vindo!</title>
</head>
<body>
	<div id="cont">
    <div class="flexWrapper.horizontal" >
    <h1 class="titulo-acecou-php">Projetos</h1><br>
    <h2 class="titulo-acecou-php">Projetos</h2><br>
    <form method="POST" action="pag-projeto.php">
	<input type="busca-projeto" placeholder="Buscar Projeto" name="busca-projeto"><br>
    <input id="input-pesquiza" type="submit" value="pesquizar">
    </form>
	</div>

<ul id="projetos" >
	<li id="foto01" ><div><img src="imagens/1234.jpg" alt=""></div></li>
    <li id="foto02" ><div><img src="imagens/1234.jpg" alt=""></div></li>
    <li id="foto03" ><div><img src="imagens/1234.jpg" alt=""></div></li>
    <li id="foto04" ><div><img src="imagens/1234.jpg" alt=""></div></li>
    <li id="foto05" ><div><img src="imagens/1234.jpg" alt=""></div></li>
    <li id="foto06" ><div><img src="imagens/1234.jpg" alt=""></div></li>
</ul>
</div>

<?php
if(isset($_POST['busca-projeto'])){
    $nome = addslashes($_POST['busca-projeto']);

    //verificar se esta preenchido
    if(!empty($nome_projeto)){
        $u->conectar("projeto_tcc","localhost","root","");
        if($u->msgErro == ""){
                if($u->buscaprojeto($nome_projeto)){
                    ?>
                    <form id='form' action='pag-projeto.php' method='POST'>
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
                    Dados incorretos!
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
    }
}
?>
</body>
</html>