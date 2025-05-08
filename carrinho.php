<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Verifica se a sessão já foi iniciada, se não, inicia uma nova sessão
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pré-Venda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            
            width: 100%;
            height: 100%;
            margin: 20;
            padding: 20;
}

body {
    background: linear-gradient(rgba(255, 255, 255, 0.25) 0px, transparent 10px);
    background-color: #131313;
    background-size: 7px 7px;
    
            color: white;
        }
        h2, h3 {
            color: white;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 50%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 3px solid black; /* Alterado para 3px */
            background-color: white;
        }
        input[type="submit"], .cart-button {
            background-color: white;
            color: black;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover, .cart-button:hover {
            background-color: darkgray;
        }
        .cart-bubble {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: gray; /* Corrigido para adicionar ponto e vírgula */
            color: black;
            padding: 10px;
            border-radius:30%;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .cart-bubble:hover {
            background-color: darkorange;
        }
        .cart-item {
            margin-bottom: 15px;
        }
        .cart-item strong {
            display: block; /* Corrigido de 'bla' para 'block' */
        }

        .cart-bubble
        .cart-item input[type="number"] {
            width: 60px;
            text-align: center;
        }

        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 24px; /* Tamanho do ícone */
            color: white; /* Cor do ícone */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: green; /* Cor de fundo do ícone */
            text-align: center;
            border-radius: 50%; /* Formato circular */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .cart-icon:hover {
            background-color: darkgreen; /* Cor ao passar o mouse */
        }

        .cart-count {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .cart-container {
            border: 2px solid black; /* Borda ao redor do carrinho */
            padding: 20px; /* Espaçamento interno */
            margin-top: 20px; /* Espaçamento superior */
            border-radius: 5px; /* Bordas arredondadas */
            background-color: #f9f9f9; /* Cor de fundo clara */
            color: black; /* Cor do texto */
        }
    </style>
</head>

<body>
    <!-- Ícone flutuante para exibir a quantidade de itens no carrinho -->
    <div class="cart-icon" onclick="window.location.href='carrinho.php'">
        🛒
        <span class="cart-count">
            <?php
            session_start();
            $carrinho_count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
            echo $carrinho_count;
            ?>
        </span>
    </div>

    <h2>Carrinho de Compras</h2>
    <form method="POST" action="">
        <label for="termo">Digite o que você procura (ex.: Motor Elétrico, Gol):</label><br>
        <input type="text" id="termo" name="termo" required><br><br>
        <input type="submit" value="Buscar">
    </form>

    <?php

    function exibirCarrinho() {
        if (!empty($_SESSION['carrinho'])) {
            echo "<h3>Itens no Carrinho:</h3>";
            echo "<table border='1' style='width: 100%; text-align: left; border-collapse: collapse;'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Produto</th>";
            echo "<th>Valor Unitário</th>";
            echo "<th>Quantidade</th>";
            echo "<th>Total</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $total_geral = 0;

            foreach ($_SESSION['carrinho'] as $produto_id => $item) {
                $total_item = $item['valor'] * $item['quantidade'];
                $total_geral += $total_item;

                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['nome']) . "</td>";
                echo "<td>R$ " . number_format($item['valor'], 2, ',', '.') . "</td>";
                echo "<td>" . $item['quantidade'] . "</td>";
                echo "<td>R$ " . number_format($total_item, 2, ',', '.') . "</td>";
                echo "<td>";
                // Formulário para remover uma quantidade específica
                echo "<form method='POST' action='' style='display:inline;'>";
                echo "<input type='hidden' name='produto_id' value='" . $produto_id . "'>";
                echo "<input type='hidden' name='acao' value='remover'>";
                echo "<input type='number' name='quantidade' value='1' min='1' max='" . $item['quantidade'] . "' style='width: 60px; text-align: center;'>";
                echo "<input type='submit' value='Remover' class='cart-button'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

            // Exibe o valor total do carrinho
            echo "<h3>Total Geral: R$ " . number_format($total_geral, 2, ',', '.') . "</h3>";
        } else {
            echo "<p>O carrinho está vazio.</p>";
        }
    }
    // Conexão com o banco de dados e busca de produtos, que fica no chatbot.php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['termo'])) {
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
                echo "<div class='cart-item'>";
                echo "<strong>Produto:</strong> " . htmlspecialchars($row['nome']) . "<br>";
                echo "<strong>Descrição:</strong> " . htmlspecialchars($row['descricao']) . "<br>";
                echo "<strong>Aplicação:</strong> " . htmlspecialchars($row['aplicacao']) . "<br>";
                echo "<strong>Valor:</strong> R$" . number_format($row['valor'], 2, ',', '.') . "<br>";
                echo "<form method='POST' action='' style='display:inline;'>";
                echo "<input type='hidden' name='produto_id' value='" . $row['id'] . "'>";
                echo "<input type='hidden' name='produto_nome' value='" . htmlspecialchars($row['nome']) . "'>";
                echo "<input type='hidden' name='produto_valor' value='" . $row['valor'] . "'>";
                echo "<input type='hidden' name='acao' value='adicionar'>";
                echo "<label for='quantidade_" . $row['id'] . "'>Quantidade:</label>";
                echo "<input type='number' id='quantidade_" . $row['id'] . "' name='quantidade' value='1' min='1' style='width: 60px; text-align: center;'>";
                echo "<input type='submit' value='Adicionar ao Carrinho' class='cart-button'>";
                echo "</form>";
                echo "</div><br>";
            }
        } else {
            echo "<p>Nenhum produto encontrado para '" . htmlspecialchars($_POST['termo']) . "'.</p>";
        }
        $stmt->close();
        $conn->close();
    }

    // Inicializa o carrinho se ainda não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Processa a ação enviada pelo formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao'])) {
        $produto_id = $_POST['produto_id'];
        $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

        if ($_POST['acao'] == 'adicionar') {
            // Adiciona ou atualiza a quantidade do produto no carrinho
            if (isset($_SESSION['carrinho'][$produto_id])) {
                $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
            } else {
                $_SESSION['carrinho'][$produto_id] = [
                    'id' => $produto_id,
                    'nome' => $_POST['produto_nome'],
                    'valor' => $_POST['produto_valor'],
                    'quantidade' => $quantidade
                ];
            }
            echo "<p>Produto adicionado ao carrinho com sucesso!</p>";
        } elseif ($_POST['acao'] == 'remover') {
            // Remove ou diminui a quantidade do produto no carrinho
            if (isset($_SESSION['carrinho'][$produto_id])) {
                $_SESSION['carrinho'][$produto_id]['quantidade'] -= $quantidade;
                if ($_SESSION['carrinho'][$produto_id]['quantidade'] <= 0) {
                    unset($_SESSION['carrinho'][$produto_id]);
                }
                echo "<p>Quantidade removida do carrinho com sucesso!</p>";
            } else {
                echo "<p>O produto não está no carrinho.</p>";
            }
        }
    }
    
    // Exibe os itens no carrinho
    if (!empty($_SESSION['carrinho'])) {
        exibirCarrinho();
    } else {
        echo "<p>O carrinho está vazio.</p>";
    }
    ?>
</body>
</html>
