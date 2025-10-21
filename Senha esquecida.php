<?php
include 'pdo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="senha_esquecida.php" method="POST">
        <label for="email">Digite seu email para recuperar a senha:</label>
        <input type="text" id="email" name="email" required><br><br>
        
        <input type="submit" value="Recuperar Senha">

    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        try {
            // Verificar se o email está registrado
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE username = :username");
            $stmt->bindParam(':username', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Aqui você pode implementar a lógica para enviar um email de recuperação de senha
                echo "Um link de recuperação de senha foi enviado para " . htmlspecialchars($email) . ".";
                
                
            } else {
                echo "Este email não está registrado.";
            }
        } catch (PDOException $e) {
            echo "Erro ao processar a solicitação: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
