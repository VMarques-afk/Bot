<!DOCTYPE html>
  <html lang="pt-BR">
  <head>
      <meta charset="UTF-8">
      <title>Lista de Produtos</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
      <div class="container mt-5">
          <h2>Lista de Produtos</h2>
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

          $result = $conn->query("SELECT * FROM produtos LIMIT 50");
          echo "<div class='row'>";
          while ($row = $result->fetch_assoc()) {
              echo "<div class='col-md-4 mb-3'>";
              echo "<div class='card'>";
              echo "<div class='card-body'>";
              echo "<h5 class='card-title'>" . htmlspecialchars($row['nome']) . "</h5>";
              echo "<p class='card-text'>" . htmlspecialchars($row['descricao']) . "</p>";
              echo "<p class='card-text'><strong>Aplicação:</strong> " . htmlspecialchars($row['aplicacao']) . "</p>";
              echo "<p class='card-text'><strong>Valor:</strong> R$" . number_format($row['valor'], 2, ',', '.') . "</p>";
              echo "</div></div></div>";
          }
          echo "</div>";

          $conn->close();
          ?>
      </div>
  </body>
  </html>