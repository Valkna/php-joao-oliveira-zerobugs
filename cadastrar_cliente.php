<?php

function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str); //remove caracteres não-numéricos da string. usada para limpar número de tel, por exemplo
}


if (count($_POST) > 0) { //linka com as colunas do banco de dados

    include('conexao.php'); //linkar com include
    $erro = false;

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];


    //code obrigando determinados campos a serem preenchidos. já é solicitado quando criado o BD
if (empty($nome)) {
    $erro = "Preencha o campo nome!";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "Preencha o campo e-mail!";
}

if (!empty($nascimento)) {
    $pedacos = explode('/', $nascimento);
    if(count($pedacos) == 3) {
        $nascimento = implode('-', array_reverse($pedacos));
    } else {
        $erro = "A data de nascimento deve seguir o padrão.";
    }
}

if(!empty($telefone)) {
    $telefone = limpar_texto($telefone);
    if(strlen($telefone) != 11)
    $erro = "O telefone deve ser prenchido no padrão."; 
    }


    //query para inserir os dados do formulário no BD
if ($erro) {
    echo "<p><b>$erro</b></p>";
} else {
    $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data_cadastro) VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    if($deu_certo) {
        echo "<p><b>Cliente cadastrado com sucesso!</b></p>";
        unset($_POST);
    }
}
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>

<!-- isset verifica se o campo está preenchido -->
    <a href="/clientes.php">Voltar para a lista</a>
    <form method="POST" action="">
        <p>
            <label for="">Nome: </label>
            <input value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" type="text" name="nome" id="">
        </p>
        <p>
            <label for="">Email: </label>
            <input value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" type="text" name="email" id="">
        </p>
        <p>
            <label for="">Telefone: </label>
            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98888-8888)" type="text" name="telefone" id="">
        </p>
        <p>
            <label for="">Data de Nascimento: </label>
            <input value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" type="text" name="nascimento" id="">
        </p>
        <p>
            <button type="submit">Salvar Cadastro</button>
        </p>
    </form>

</body>

</html>