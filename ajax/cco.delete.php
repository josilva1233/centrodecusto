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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecte ao banco de dados e exclua o registro
    $id = $_POST['id'];
    $sql_excluir_user = "DELETE 
    FROM `glpi_plugin_centrodecusto_ccusto_users` 
    WHERE `ccusto_id` = '$id'";
    // Execute a consulta de exclusão
    $DB->query($sql_excluir_user);
    $sql_excluir_cco = "DELETE 
                    FROM `glpi_plugin_centrodecusto_ccusto` 
                    WHERE `id` = '$id'"; 
    // Execute a consulta de exclusão
    $DB->query($sql_excluir_cco);
}