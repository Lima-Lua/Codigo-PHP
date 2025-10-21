<?php

include 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            echo "Login bem-sucedido! Bem-vindo, " . htmlspecialchars($user['username']) . ".";
            
            // Redirecionar para a página de administração
            header("Location: Administração.html");
        } else {
            echo "Nome de usuário ou senha incorretos.";
        }
    } catch (PDOException $e) {
        echo "Erro ao processar login: " . $e->getMessage();
    }
} else {
    echo "Método de requisição inválido.";
}

?>
