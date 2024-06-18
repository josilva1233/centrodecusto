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

//seleciona todos os usuários cadastrado no GLPI
$select_user = "SELECT * FROM glpi_users";
$result = $DB->query($select_user);

//seleciona todos os usuários cadastrado em um centro de custo.
$select_user3 = "SELECT * FROM `glpi_plugin_centrodecusto_ccusto_users`";
$result2 = $DB->query($select_user3);


