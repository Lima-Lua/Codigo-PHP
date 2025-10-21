<?php

 //atualizando cardapio
 include 'pdo.php';

    if (isset($_POST['id'], $_POST['nome'], $_POST['preco'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
    
        try {
            $stmt = $pdo->prepare("UPDATE cardapio SET nome = :nome, preco = :preco WHERE id = :id");
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            header("Location: show_cardapio.php");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao atualizar item: " . $e->getMessage();
        }
    } else {
        echo "Dados incompletos para atualização.";
    }
?>
