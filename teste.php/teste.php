<?php
$host = 'localhost';
$port = '3307';
$user = 'root';
$password = ''; // Senha vazia
$database = 'chatbot_vendas';

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$result = $conn->query("SELECT nome, preco FROM produtos");
while ($row = $result->fetch_assoc()) {
    echo "Produto: " . $row['nome'] . " - Preço: R$" . $row['preco'] . "<br>";
}

$conn->close();
?>