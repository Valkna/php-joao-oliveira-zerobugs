<?php

include('conexao.php');
$id = intval($_GET['id']);
function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str); //remove caracteres não-numéricos da string. usada para limpar número de tel, por exemplo
}


if (count($_POST) > 0) {


    $erro = false;

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];


    if (empty($nome)) {
        $erro = "Preencha o campo nome!";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha o campo e-mail!";
    }

    if (!empty($nascimento)) {
        $pedacos = explode('/', $nascimento);
        if (count($pedacos) == 3) {
            $nascimento = implode('-', array_reverse($pedacos));
        } else {
            $erro = "A data de nascimento deve seguir o padrão.";
        }
    }

    if (!empty($telefone)) {
        $telefone = limpar_texto($telefone);
        if (strlen($telefone) != 11)
            $erro = "O telefone deve ser prenchido no padrão.";
    }


    if ($erro) {
        echo "<p><b>$erro</b></p>";
    } else {
        // query para atualizar o cadastro do cliente 
        $sql_code = "UPDATE clientes
        SET nome = '$nome',
        email = '$email',
        telefone = '$telefone',
        nascimento = '$nascimento'
        WHERE id = '$id'";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if ($deu_certo) {
            echo "<p><b>Cliente atualizado com sucesso!</b></p>";
            unset($_POST);
        }
    }
}

//puxa os dados do cliente do banco de dados. mostra na tela para que possam ser alterados
$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
$cliente = $query_cliente->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <a href="/clientes.php">Voltar para a lista</a>
    <form method="POST" action="">
        <!-- formulário para mostrar em tela as informações do cliente que constam no banco de dados  -->
        <p>
            <label for="">Nome: </label>
            <input value="<?php echo $cliente['nome']; ?>" type="text" name="nome" id="">
        </p>
        <p>
            <label for="">Email: </label>
            <input value="<?php echo $cliente['email']; ?>" type="text" name="email" id="">
        </p>
        <p>
            <label for="">Telefone: </label>
            <input value="<?php if(!empty($cliente['telefone'])) echo formatar_telefone($cliente['telefone']); ?>" placeholder="(11) 98888-8888)" type="text" name="telefone" id="">
        </p>
        <p>
            <label for="">Data de Nascimento: </label>
            <input value="<?php if(!empty($cliente['nascimento'])) echo formatar_nascimento($cliente['nascimento']); ?>" type="text" name="nascimento" id="">
        </p>
        <p>
            <button type="submit">Salvar Cadastro</button>
        </p>
    </form>

</body>

</html>