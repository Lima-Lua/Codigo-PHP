<?php 
include 'pdo.php'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Delícias da Benedita</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1> Delícias da Benedita </h1>
        <nav>
            <a href="#sobre">Sobre o Estabelecimento</a>
            <a href="#cardapio">Cardápio</a>
            <a href="#contato">Contato</a>
            <a href="login.html">Login Adm</a>
        </nav>
    </header>

    <section id="sobre">
        <h2>Sobre Nós</h2>
        <p>Comida caseira feita com Carinho! Servimos almoços, Café da Manhã e Janta! (<strong>só atendemos presencialmente</strong>, não temos delivery!).</p>
    </section>

    <section id="cardapio">
        <h2>Nosso Cardápio</h2>
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM cardapio");
            $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($itens)> 0) {
                foreach ($itens as $item) {
                    echo "<div class='prato'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($item['imagem']) . "' alt='" . htmlspecialchars($item['nome']) . "' style='width:200px;height:auto;'><br>";
                    echo "<strong>" . htmlspecialchars($item['nome']) . "</strong><br>";
                    echo "Preço: " . number_format($item['preco'], 2, ',', '.') . "<br>";
                    echo "Categoria: " . htmlspecialchars($item['categoria']) . "<br>";
                    echo $item['disponibilidade'] ? "<span style='color:green;'>Disponível</span>" : "<span style='color:red;'>Indisponível</span>";
                    echo "</div><hr>";
                }
            } else {
                echo "<p>O cardápio ainda não foi cadastrado</p>";
            } 
           }   catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
         }
         ?>
    </section>  
    
    <footer>
        <p>Ana Refeições - Recife, PE</p>
    </footer>
</body>
</html>
