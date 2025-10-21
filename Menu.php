<?php
include 'pdo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cardápio</title>
</head>
<body>
    
    <h1 >Cardápio Registrado</h1>

    <p>Aqui estará o cardápio registrado.</p>
    <div class="cardapio">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM cardapio");
            $cardapio = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                if (count($cardapio) > 0) {
                    foreach ($cardapio as $item) {
                        echo "<div>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($item['imagem']) . "' alt='" . htmlspecialchars($item['nome']) . "' style='width:200px;height:auto;'><br>";
                        echo "<h2>" . htmlspecialchars($item['nome']) . "</h2>";
                        echo"<p>Categoria: " . htmlspecialchars($item['categoria']) . "</p>";
                        echo "<p>Preço: R$ " . number_format($item['preco'], 2, ',', '.') . "</p>";
                        echo "<p>Disponibilidade: " . ($item['disponibilidade'] ? "Disponível" : "Indisponível") . "</p>";
                        echo "<a href=' excluir_cardapio.php?id=" . $item['id'] . "' onclick =\"return confirm(' Tem certeza que deseja exluir esse prato?');\"> Excluir </a>";
                        echo "</div><hr>";
                    }
                } else {
                    echo "<p>Nenhum item no cardápio.</p>";}
        } catch (PDOException $e) {
        echo "Erro ao exibir cardápio: " . $e->getMessage();
        }

        ?>
    </div>

    <a href="Administração.html">Voltar para o formulário</a>
</body>
</html>

<!--

criando bd

CREATE DATABASE cardapio;
USE cardapio;
CREATE TABLE cardapio (
id INT AUTO_INCREMENT PRIMARY KEY, 
nome VARCHAR(100),
categoria VARCHAR(100),
preco DECIMAL(10,2),
disponibilidade BOOLEAN,
imagem TEXT);
--->
