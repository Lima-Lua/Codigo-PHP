<?php
include 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $preco = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $disponibilidade = $_POST['disponibilidade'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $nome_temp = $_FILES['imagem']['tmp_name'];
        $conteudo_binario = file_get_contents($nome_temp);
        $tamanho_max = 5 * 1024 * 1024; // 5MB
        $tipo_mime_upload = $_FILES['imagem']['type'];
        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (strlen($conteudo_binario) > $tamanho_max) {
            die("Erro: O arquivo excede o tamanho máximo permitido de 5MB.");
        }
        if (!in_array($tipo_mime_upload, $tipos_permitidos)) {
            die("Erro: Tipo de arquivo não permitido. Apenas JPEG, PNG ou GIF são aceitos.");
        }

        if (empty($nome) || empty($preco) || empty($categoria) || empty($disponibilidade)) {
            die("Erro: Todos os campos são obrigatórios.");
        }
        if (!is_numeric($preco) || $preco < 0) {
            die("Erro: O valor deve ser um número positivo.");
        }
        if (empty($_FILES['imagem']['name'])) {
            die("Erro: A imagem é obrigatória.");
        }

        if ($disponibilidade === 'disponivel') {
            $disponibilidade = 1; // true
        } else {
            $disponibilidade = 0; // false
        }
        
        $sql = "INSERT INTO cardapio (nome, preco, categoria, disponibilidade, imagem) VALUES (:nome, :preco, :categoria, :disponibilidade, :imagem)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':disponibilidade', $disponibilidade);
            $stmt->bindParam(':imagem', $conteudo_binario, PDO::PARAM_LOB);
            $stmt->execute();
            echo "Item do cardápio cadastrado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao cadastrar item: " . $e->getMessage();
        }
} else {
    
    echo "<p>Nenhum arquivo enviado ou erro no envio.</p>";
}

}

?>
