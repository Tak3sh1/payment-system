<?php
include('conexao.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $valor = isset($_POST['valor']) ? $_POST['valor'] : 0.00;
    $metodo_pagamento = isset($_POST['metodo_pagamento']) ? $_POST['metodo_pagamento'] : '';
    $beneficiario = isset($_POST['beneficiario']) ? $_POST['beneficiario'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    $sql = "INSERT INTO tb_pagar (nm_tipo, ds_descricao, vl_valor, nm_metodo_pagar, nm_status)
            VALUES (:tipo, :descricao, :valor, :metodo_pagamento, :status)";

    try {
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':metodo_pagamento', $metodo_pagamento);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        $id_pagamento = $PDO->lastInsertId();

        if ($beneficiario) {
            $sql_update = "UPDATE tb_beneficiario SET fk_id_pagamento = :id_pagamento WHERE id_beneficiario = :beneficiario";
            $stmt_update = $PDO->prepare($sql_update);
            $stmt_update->bindParam(':id_pagamento', $id_pagamento);
            $stmt_update->bindParam(':beneficiario', $beneficiario);
            $stmt_update->execute();
        }

        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        echo 'Erro ao gravar dados: ' . $e->getMessage();
    }
}
?>
