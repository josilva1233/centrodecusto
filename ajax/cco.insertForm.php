<?php
include("../../../inc/includes.php");

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access this file directly");
}

Session::checkRight("profile", READ);

$plugin = new Plugin();
if (!$plugin->isInstalled('centrodecusto') || !$plugin->isActivated('centrodecusto')) {
    Html::displayNotFoundError();
}

// Pega os valores da URL
$data = json_decode(file_get_contents("php://input"), true);
// Verifica se o JSON foi decodificado corretamente e se os campos esperados estão definidos
if ($data && isset($data['name']) && isset($data['ccusto']) && isset($data['visivel_chamado']) && isset($data['visivel_projeto']) && isset($data['itens']) && isset($data['user']) && isset($data['comment'])) {
    // Insere os dados no banco de dados (este é um exemplo básico, substitua com sua própria lógica de inserção no banco de dados)
    $name = $data['name'];
    $completename = $data['name'];
    $ccusto = $data['ccusto'];
    $visivel_chamado = $data['visivel_chamado'];
    $visivel_projeto = $data['visivel_projeto'];
    $itens = $data['itens'];
    $user = $data['user'];
    $comment = $data['comment'];
    // Insere os dados no banco de dados do GLPI
    $query = "INSERT INTO `glpi_plugin_centrodecusto_ccusto` 
              (`name`,`completename`, `ccusto`, `visivel_chamado`, `visivel_projeto`, `itens`, `user`, `comment`) 
              VALUES ('$name','$completename','$ccusto', '$visivel_chamado', '$visivel_projeto', '$itens', '$user', '$comment')";
    if ($DB->query($query)) {
        // Obtém o ID inserido
        $select_query = "SELECT `id` FROM `glpi_plugin_centrodecusto_ccusto` WHERE `name` = '$name'";
        $result = $DB->query($select_query);
        if ($result && $result->num_rows > 0) {
            // Obtém a linha da consulta
            $row = $result->fetch_assoc();
            // Obtém o ID cadastrado
            $id = $row['id'];
            $name = $row['name'];
            $ccusto = $row['ccusto'];
            // Ajuste a mensagem conforme necessário
            $message = sprintf(__('Item adicionado com sucesso: <a href="cco.form.php?id=' . $id . '">' . $id . '</a>', 'centrodecusto'));
            Session::addMessageAfterRedirect($message);
        }
    } else {
        Session::addMessageAfterRedirect(__('Erro ao cadastrar o item', 'centrodecusto'), false, ERROR);
    }
    http_response_code(200);
}
