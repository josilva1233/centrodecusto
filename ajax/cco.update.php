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

// Verifica se o JSON foi decodificado corretamente e se os campos esperados estão definidos
if (isset($_GET['id'])&& isset($_GET['name']) && isset($_GET['ccusto']) && isset($_GET['visivel_chamado']) && isset($_GET['visivel_projeto']) && isset($_GET['itens']) && isset($_GET['user']) && isset($_GET['comment'])) {
    // Insere os dados no banco de dados (este é um exemplo básico, substitua com sua própria lógica de inserção no banco de dados)
    $id = $_GET['id'];
    $name = $_GET['name'];
    $completename = $_GET['name'];
    $ccusto = $_GET['ccusto'];
    $visivel_chamado = $_GET['visivel_chamado'];
    $visivel_projeto = $_GET['visivel_projeto'];
    $itens = $_GET['itens'];
    $user = $_GET['user'];
    $comment = $_GET['comment'];

    $query = "UPDATE `glpi_plugin_centrodecusto_ccusto` 
          SET 
          `name` = '$name',
          `completename` = '$completename',
          `ccusto` = '$ccusto',
          `visivel_chamado` = '$visivel_chamado',
          `visivel_projeto` = '$visivel_projeto',
          `itens` = '$itens',
          `user` = '$user',
          `comment` = '$comment'
          WHERE `id` = $id";
    $DB->query($query);
    // Ajuste a mensagem conforme necessário
    $message = sprintf(__('Centro de custo atualizado com sucesso: <a href="cco.form.php?id=' . $id . '">' . $name . '</a>', 'centrodecusto'));
    Session::addMessageAfterRedirect($message);
    // Redirecionamento para outra página PHP
    header('Location: ../front/cco.form.php?id='.($id).'');
    exit;
}