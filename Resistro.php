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
    <form action="registro.php" method="POST">
        <label for="email">Email do usuário:</label>
        <input type="text" id="email" name="email" required><br><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirmar">Confirme sua Senha:</label>
        <input type="password" id="confirmar" name="confirmar" required><br><br>

        <label for="questao">Cargo</label>
        <select name="questoes" id="questoes" required>
            <option value="Funcionário">Disponivel</option>
            <option value="Dono">Indisponivel</option>
        </select>
        
        <input type="submit" value="Registrar">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmar = $_POST['confirmar'];
        $questao = $_POST['questoes'];

        if ($password !== $confirmar) {
            echo "As senhas não coincidem.";
        } else if (strlen($password) < 7) {
            echo "A senha deve ter pelo menos 7 caracteres.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Formato de email inválido.";
        } else if (empty($email) || empty($password)) {
            echo "Por favor, preencha todos os campos.";
        } else if ($password === $email) {
            echo "A senha não pode ser igual ao email.";
        } else if (preg_match('/^\d+$/', $password)) {
            echo "A senha não pode ser composta apenas por números.";
        } else if (preg_match('/^[a-zA-Z]+$/', $password)) {
            echo "A senha não pode ser composta apenas por letras.";
        }
        else {
            try {
                // Verificar se o email já está registrado
                $stmt = $pdo->prepare("SELECT * FROM usuario WHERE username = :username");
                $stmt->bindParam(':username', $email);
                $stmt->execute();
                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingUser) {
                    echo "Este email já está registrado.";
                } else {
                    // Inserir novo usuário
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO usuario (username, password, cargo) VALUES (:username, :password, :cargo)");
                    $stmt->bindParam(':username', $email);
                    $stmt->bindParam(':password', $hashedPassword);
                    $stmt->bindParam(':cargo', $questao);
                    $stmt->execute();

                    echo "Registro bem-sucedido! Você já pode fazer login.";
                }
            } catch (PDOException $e) {
                echo "Erro ao registrar usuário: " . $e->getMessage();
            }
        }
    }
    ?>
</body>
</html>
