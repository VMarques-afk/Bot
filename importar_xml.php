<?php
$host = 'localhost';
$port = '3307';
$user = 'root';
$password = '';
$database = 'chatbot_vendas';

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Carregar o arquivo XML
$xml = simplexml_load_file('lista_produtos_carros.xml');

if ($xml === false) {
    die("Erro ao carregar o arquivo XML.");
}

// Preparar a query de inserção
$stmt = $conn->prepare("INSERT INTO produtos (id, nome, descricao, aplicacao, valor) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isssd", $id, $nome, $descricao, $aplicacao, $valor);

// Inserir cada produto no banco de dados
foreach ($xml->produto as $produto) {
    $id = (int)$produto['id'];
    $nome = (string)$produto->nome;
    $descricao = (string)$produto->descricao;
    $aplicacao = (string)$produto->aplicacao;
    $valor = (float)$produto->valor;

    $stmt->execute();
}

echo "Produtos importados com sucesso!";

$stmt->close();
$conn->close();
?>