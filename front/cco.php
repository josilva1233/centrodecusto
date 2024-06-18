<?php

include("../../../inc/includes.php");
require_once "../src/cco.class.php";

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access this file directly");
}

Session::checkRight("profile", READ);

//Verifica se o plugin está ativo.
if (!(new Plugin())->isActivated('centrodecusto')) {
    Html::displayNotFoundError();
}

Html::header(
    PluginCentrodecustoForm::getMenuName(),
    $_SERVER['PHP_SELF'],
    "Admin",
    "PluginCentrodecustoForm",
);

PluginCentrodecustoForm::showList();


Html::footer();