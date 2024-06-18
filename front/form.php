<?php

include("../../../inc/includes.php");

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access this file directly");
}

$dropdown = new PluginCentrodecustoForm();

include(GLPI_ROOT . "/plugins/centrodecusto/front/cco.php");
