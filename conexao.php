<?php // sempre usar include nos arquivos para linkar com o conexao.php

//gera conexão com o banco de dados
$host = "localhost";
$db = "crud_clientes";
$user = "root";
$pass = "";

//mensagem de erro
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("Fail DB link");
}


//formata datas 
function formatar_nascimento($nascimento) {
    return implode('/', array_reverse(explode('-', $nascimento)));
}


//formata número de telefone 
function formatar_telefone($telefone) {
        $ddd = substr($telefone, 0, 2);
        $parte1 = substr($telefone, 2, 5);
        $parte2 = substr($telefone, 7);
        return "($ddd) $parte1-$parte2";
    }
