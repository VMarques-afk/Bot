<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pré-Venda</title>
</head>

<head>
 
<body><style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
        border-radius: 5px;
        background-color: black; /* Fundo preto */
        color: white; /* Texto branco */
    }
</style>
    <h2>Chatbot de Pré-Venda</h2>
    <form method="POST" action="">
        <label for="termo">Digite o que você procura (ex.: Motor Elétrico, Gol):</label><br>
        <input type="text" id="termo" name="termo" required><br><br>
        <input type="submit" value="Buscar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
        $port = '3307';
        $user = 'root';
        $password = '';
        $database = 'chatbot_vendas';

        $conn = new mysqli($host, $user, $password, $database, $port);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $termo = "%" . $_POST['termo'] . "%";
        $query = "SELECT * FROM produtos WHERE nome LIKE ? OR aplicacao LIKE ? LIMIT 5";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $termo, $termo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h3>Resultados da busca:</h3>";
            while ($row = $result->fetch_assoc()) {
                echo "<form method='POST' action='carrinho.php'>";
                echo "<strong>Produto:</strong> " . htmlspecialchars($row['nome']) . "<br>";
                echo "<strong>Descrição:</strong> " . htmlspecialchars($row['descricao']) . "<br>";
                echo "<strong>Aplicação:</strong> " . htmlspecialchars($row['aplicacao']) . "<br>";
                echo "<strong>Valor:</strong> R$" . number_format($row['valor'], 2, ',', '.') . "<br>";
                echo "<input type='hidden' name='produto_id' value='" . htmlspecialchars($row['id']) . "'>";
                echo "<input type='hidden' name='produto_nome' value='" . htmlspecialchars($row['nome']) . "'>";
                echo "<input type='hidden' name='produto_valor' value='" . htmlspecialchars($row['valor']) . "'>";
                echo "<label for='quantidade_" . htmlspecialchars($row['id']) . "'>Quantidade:</label>";
                echo "<input type='number' id='quantidade_" . htmlspecialchars($row['id']) . "' name='quantidade' value='1' min='1' style='width: 60px; text-align: center;'>";
                echo "<button type='submit' name='acao' value='adicionar'>+1</button>";
                echo "<button type='submit' name='acao' value='remover'>-1</button>";
                echo "</form><br>";
            }
        } else {
            echo "<p>Nenhum produto encontrado para '" . htmlspecialchars($_POST['termo']) . "'.</p>";
        }

        $stmt->close();
        $conn->close();
    }
?>
</body>
</html>