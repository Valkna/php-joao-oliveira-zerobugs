<?php
if(isset($_POST['confirmar'])) { //gera a função que deleta o cadastro

    include("conexao.php");
    $id = intval($_GET['id']); //formata o id em numero, protege de sql inject
    $sql_code = "DELETE FROM clientes WHERE id = '$id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error); //query para deletar registros

    if ($sql_query) { ?>
        <h1>Cliente deletado com sucesso</h1>
        <p> <a href="clientes.php"> Clique aqui</a> para voltar para a lista de clientes</p>
        <?php
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Cliente</title>
</head>

<body>
    <h1>Tem certeza que deseja deletar o cadastro?</h1>

    <form action="" method="post">
        <button><a href="clientes.php">Não</a></button>        
        <button name="confirmar" value="1" type="submit">Sim</button> 
        <!-- name "confirmar" gera o delete -->
    </form>

</body>

</html>