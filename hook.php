<?php

/**
 * Install hook
 *
 * @return boolean
 */
function plugin_centrodecusto_install() {
   global $DB;

   // Instantiate migration with version
   $migration = new Migration(100);

   // Create table for centro de custo if it does not exist yet
   if (!$DB->tableExists('glpi_plugin_centrodecusto_ccusto')) {
      // Table creation query
      $query1 = "CREATE TABLE `glpi_plugin_centrodecusto_ccusto` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `entities_id` TINYINT(1) NOT NULL,
                  `is_recursive` TINYINT(1) NOT NULL,
                  `name` VARCHAR(255) NOT NULL,
                  `completename` VARCHAR(255) NOT NULL,
                  `ccusto` INT(11) NOT NULL,
                  `visivel_chamado` TINYINT(1) NOT NULL,
                  `visivel_projeto` TINYINT(1) NOT NULL,
                  `itens` TINYINT(1) NOT NULL,
                  `user` TINYINT(1) NOT NULL,
                  `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                  `date_mod` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
               ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC";
      $DB->queryOrDie($query1, $DB->error());
   }
   
   if ($DB->tableExists('glpi_plugin_centrodecusto_ccusto')) {
    //missed value for configuration
    $migration->addField(
       'glpi_plugin_centrodecusto_ccusto',
       'comment',
       'string'
    );

    $migration->addKey(
       'glpi_plugin_centrodecusto_ccusto',
       'name'
    );
 }

  // Create a new table for additional functionalities if it does not exist yet
  if (!$DB->tableExists('glpi_plugin_centrodecusto_ccusto_users')) {
   // Table creation query for new table
   $query2 = "CREATE TABLE `glpi_plugin_centrodecusto_ccusto_users` (
               `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
               `users_id` INT(10) UNSIGNED NOT NULL,
               `ccusto_id` INT(10) UNSIGNED NOT NULL,
               `is_director` TINYINT(4) NOT NULL,
               `is_manager` TINYINT(4) NOT NULL,
               `is_belongs` TINYINT(4) NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
   $DB->queryOrDie($query2, $DB->error());
}

   // Execute the whole migration
   $migration->executeMigration();

   return true;
}

/**
* Uninstall hook
*
* @return boolean
*/
function plugin_centrodecusto_uninstall() {
   global $DB;
 
   $tables = [
      'glpi_plugin_centrodecusto_ccusto_users',
      'glpi_plugin_centrodecusto_ccusto'
   ];
 
   foreach ($tables as $table) {
      if ($DB->tableExists($table)) {
         $DB->queryOrDie(
            "DROP TABLE `$table`",
            $DB->error()
         );
      }
   }
 
   return true;
 }

/**
  * Display information on login page
  *
  * @return void
  */
  function plugin_centrodecusto_display_login () {
   echo "That line will appear on the login page!";
}

//Integra o plugin a lista suspensa do GLPI
function plugin_centrodecusto_getDropdown() {
   return [
      'PluginCentrodecustoForm' => _n('Centro de custo', 'Centros de custo', 2, 'centrodecusto'),
   ];
}




