<?php
include('conexao.php'); // Inclui o arquivo de conexão

if (isset($_POST['excluir_id'])) {
    $id_pagamento = $_POST['excluir_id'];
    
    try {
        // Deleta o registro
        $sql = "DELETE FROM tb_pagar WHERE id_pagamento = :id_pagamento";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id_pagamento', $id_pagamento);
        
        if ($stmt->execute()) {
            echo "Registro excluído com sucesso!";
        } else {
            echo "Erro ao excluir registro.";
        }
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
