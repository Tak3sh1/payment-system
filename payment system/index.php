<?php
include('conexao.php'); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabalho PW e QTS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap">
    <style>
        /* Estilo geral da página */
body {
    font-family: 'Work Sans', sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

h1{
    font-size:30px;
    text-align: center;
}

.container {
    width: 80%;
    max-width: 1200px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    box-sizing: border-box;
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h1 {
    font-size: 2.5em;
    color: #7b4b8a;
    margin: 0;
}

.quadro {
    margin-bottom: 20px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

form {
    margin: 0 auto;
    max-width: 600px;
    text-align: center;
}

input[type="radio"], input[type="checkbox"] {
    margin-right: 10px;
}

textarea, input[type="number"], select {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 2px 1px 2px 1px rgba(0, 0, 0, 0.2);
}

textarea {
    height: 100px;
    resize: vertical;
}

select {
    background-color: #fafafa;
}

input[type="submit"], input[type="button"] {
    background-color: #7b4b8a;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-right: 10px;
    display: inline-block;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
}

input[type="submit"]:hover, input[type="button"]:hover {
    background-color: #6d3f77;
    transform: scale(1.05);
}

.btn-deletar {
    background-color: #e74c3c;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-deletar:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    border-radius: 8px;
    overflow: hidden;
}

table, th, td {
    border: 1px solid #e0e0e0;
}

th {
    background-color: #7b4b8a;
    color: #fff;
    padding: 10px;
    text-align: left;
}

td {
    background-color: #f4f4f4;
    color: #333;
    padding: 10px;
    text-align: left;
    transition: background-color 0.3s ease;
}

td:hover {
    background-color: #dda0dd;
}

.acoes {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.acoes button {
    background-color: #7b4b8a;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.acoes button:hover {
    background-color: #dda0dd; 
    transform: scale(1.05);
}

    </style>
</head>
<body>
    <div class="container">
        <div class="quadro">
            <h1>Sistema de Pagamento</h1>
            <form method="post" action="cadastrarDados.php">
                <p class="valor">Dados:</p>
                <input type="radio" name="tipo" id="entrada" value="entrada">Entrada
                <input type="radio" name="tipo" id="saida" value="saida">Saída<br>
                <textarea name="descricao" id="descricao" placeholder="Descrição"></textarea><br>
                <input type="number" name="valor" id="valor" placeholder="Valor" step="0.01"><br>
                <select name="metodo_pagamento">
                    <option value="Credito">Crédito</option>
                    <option value="Debito">Débito</option>
                    <option value="Pix">Pix</option>
                    <option value="Dinheiro">Dinheiro</option>
                </select><br>
                <select name="beneficiario" id="beneficiario">
                    <?php
                    try {
                        $consulta = $PDO->query("SELECT id_beneficiario, nm_beneficiario FROM tb_beneficiario");
                        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='".$linha['id_beneficiario']."'>".$linha['nm_beneficiario']."</option>";
                        }
                    } catch (PDOException $e) {
                        echo "<option value=''>Erro ao carregar beneficiários</option>";
                    }
                    ?>
                </select><br>
                <p class="valor">Status:</p>
                <input type="radio" name="status" id="liquido" value="Liquido">Líquido
                <input type="radio" name="status" id="aberto" value="Em aberto">Em aberto
                <input type="radio" name="status" id="atraso" value="Em atraso">Em atraso<br><br>
                <input type="hidden" name="id_pagamento" id="id_pagamento">
                <input type="submit" value="Gravar">
                <input type="button" value="Limpar" onclick="limparCampo()">
            </form>
        </div>

        <div>
            <h3>Pagamentos Registrados</h3>
            <table id="tabelaPagamentos" border="1">
                <tr>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Forma de Pagamento</th>
                    <th>Beneficiário</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
                <?php
                try {
                    $consulta = $PDO->query("SELECT tp.*, tb.nm_beneficiario 
                                             FROM tb_pagar tp 
                                             LEFT JOIN tb_beneficiario tb ON tb.fk_id_pagamento = tp.id_pagamento");
                    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".($linha['nm_tipo'] == 'entrada' ? 'Entrada' : 'Saída')."</td>";
                        echo "<td>".$linha['ds_descricao']."</td>";
                        echo "<td>".$linha['vl_valor']."</td>";
                        echo "<td>".$linha['nm_metodo_pagar']."</td>";
                        echo "<td>".$linha['nm_beneficiario']."</td>";
                        echo "<td>".$linha['nm_status']."</td>";
                        echo "<td class='acoes'>
                                <form method='post' action='acoes.php' style='display:inline;'>
                                    <input type='hidden' name='id_pagamento' value='".$linha['id_pagamento']."'>
                                    <button type='submit' name='excluir_id' value='".$linha['id_pagamento']."' class='btn-deletar'>Deletar</button>
                                </form>
                                <button onclick='alterar(
                                    \"".$linha['id_pagamento']."\",
                                    \"".$linha['nm_tipo']."\",
                                    \"".$linha['ds_descricao']."\",
                                    \"".$linha['vl_valor']."\",
                                    \"".$linha['nm_metodo_pagar']."\",
                                    \"".$linha['nm_beneficiario']."\",
                                    \"".$linha['nm_status']."\"
                                )'>Alterar</button>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='7'>Erro ao consultar os dados: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        function limparCampo() {
            document.querySelectorAll('.quadro input[type="text"], .quadro input[type="number"], .quadro textarea').forEach(input => input.value = '');
            document.querySelectorAll('.quadro input[type="radio"]').forEach(radio => radio.checked = false);
            document.querySelector('.quadro select').selectedIndex = 0;
            document.getElementById('id_pagamento').value = '';
        }

        function alterar(id, tipo, descricao, valor, metodo_pagamento, beneficiario, status) {
            document.getElementById('id_pagamento').value = id;
            document.querySelector('input[name="tipo"][value="' + tipo + '"]').checked = true;
            document.getElementById('descricao').value = descricao;
            document.getElementById('valor').value = valor;
            document.querySelector('select[name="metodo_pagamento"]').value = metodo_pagamento;
            document.getElementById('beneficiario').value = beneficiario;
            document.querySelector('input[name="status"][value="' + status + '"]').checked = true;
        }
    </script>
</body>
</html>
