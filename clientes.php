<?php include('conexao.php');

// linka com o banco de dados
$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>

<body>
    <h1>Lista de Clientes</h1>
    <p>Estes são os clientes cadastrados no sistema:</p>


    <!-- tabela com as informações do cliente -->
    <table border="1" cellpadding="10"> 
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Nascimento</th>
            <th>Data de Cadastro</th>
            <th>Ação</th>
        </thead>

        <tbody>

            <?php if ($num_clientes == 0) { ?>
                <tr>
                    <td colspan="7"><strong>Nenhum cliente foi cadastrado</strong></td> 
                    <!-- colspan mescla células da tabela  -->
                </tr>
                <?php } else {
                while ($cliente = $query_clientes->fetch_assoc()) {

                    $telefone = "Não informado";
                    if(!empty($cliente['telefone'])) {
                        $telefone = formatar_telefone($cliente['telefone']); //format está no arquivo conexao.php
                    }
                    $nascimento = "Não informada";
                    if(!empty($cliente['nascimento'])) {
                        $nascimento = formatar_nascimento($cliente['nascimento']);
                    }
                    $data_cadastro = date("d/m/Y H:i", strtotime($cliente['data_cadastro']));

                ?>
                    <tr>
                        <!-- printa as variáveis na tabela  -->
                        <td><?php echo $cliente['id']; ?></td>
                        <td><?php echo $cliente['nome']; ?></td>
                        <td><?php echo $cliente['email'];?></td>
                        <td><?php echo $telefone;?></td>
                        <td><?php echo $nascimento;?></td>
                        <td><?php echo $data_cadastro;?></td>
                        <td>
                            <!-- linka aos arquivos com escript de ações  -->
                            <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                            <a href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                        </td>
                    </tr>
            <?php
                }
            } ?>

        </tbody>
    </table>

</body>

</html>