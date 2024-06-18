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

// Verifica se os campos obrigatórios estão definidos
if ($data && isset($data['users_id']) && isset($data['ccusto_id']) && isset($data['is_director']) 
    && isset($data['is_manager']) && isset($data['is_belongs'])) {
    $users_id = $data['users_id'];
    $ccusto_id = $data['ccusto_id'];
    // Verifica se o usuário já pertence ao centro de custo
    $existing_query = "SELECT COUNT(*) as count FROM `glpi_plugin_centrodecusto_ccusto_users` 
                       WHERE `users_id` = '$users_id' AND `ccusto_id` = '$ccusto_id'";
    $existing_result = $DB->query($existing_query);
    $existing_data = $existing_result->fetch_assoc();
    // Se o usuário já existir no centro de custo, retorne uma resposta de erro
    if ($existing_data['count'] > 0) {
        Session::addMessageAfterRedirect(__('Esse usuário já pertence ao centro de custo', 'centrodecusto'), false, ERROR);
        http_response_code(200); // Bad Request
        echo json_encode(array("error" => $error_message));
        exit();
    }
    // Se o usuário não existir, continue com a inserção no banco de dados
    $is_director = $data['is_director'];
    $is_manager = $data['is_manager'];
    $is_belongs = $data['is_belongs'];
    // Insere os dados no banco de dados do GLPI
    $query2 = "INSERT INTO `glpi_plugin_centrodecusto_ccusto_users` 
               (`users_id`, `ccusto_id`, `is_director`, `is_manager`, `is_belongs` ) 
               VALUES ('$users_id', '$ccusto_id', '$is_director', '$is_manager', '$is_belongs')";
    $DB->query($query2);
    $message = sprintf(__('Foi adicionado um usuário no centro de custo.', 'centrodecusto'));
    Session::addMessageAfterRedirect($message);
    http_response_code(200);
} else {
    // Se os campos obrigatórios não estiverem definidos, retorne uma resposta de erro
    $error_message = __('Campos obrigatórios não estão definidos.', 'centrodecusto');
    http_response_code(400); // Bad Request
    echo json_encode(array("error" => $error_message));
    exit();
}
