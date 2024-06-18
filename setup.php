<?php

define('CENTRODECUSTO_VERSION', '1.0.0');

/**
 * Init the hooks of the plugins - Needed
 *
 * @return void
 */
function plugin_init_centrodecusto() {
   global $PLUGIN_HOOKS;

   //required!
   $PLUGIN_HOOKS['csrf_compliant']['centrodecusto'] = true;
   //$PLUGIN_HOOKS['display_login']['centrodecusto'] = 'myplugin_display_login';
   $PLUGIN_HOOKS['config_page']['centrodecusto'] = 'front/cco.php';
   $PLUGIN_HOOKS['menu_entry']['centrodecusto'] = true;
   $PLUGIN_HOOKS['menu_toadd']['centrodecusto'] = ['admin' => 'PluginCentrodecustoForm'];

   // Display fields in any existing tab
   $PLUGIN_HOOKS['post_item_form']['centrodecusto'] = [
      'PluginCentrodecustoForm',
      'showForTab'
   ];

}



/**
 * Get the name and the version of the plugin - Needed
 *
 * @return array
 */
function plugin_version_centrodecusto() {
   return [
      'name'           => __('Centro de Custo', 'centrodecusto'),
      'version'        => CENTRODECUSTO_VERSION,
      'author'         => 'Josias Silva, <a href="https://www.montreal.com.br">Mi Montreal</a>',
      'license'        => 'GLPv3',
      'homepage'       => 'https://www.montreal.com.br',
      'requirements'   => [
         'glpi'   => [
            'min' => '9.1'
         ]
      ]
   ];
}

/**
 * Optional : check prerequisites before install : may print errors or add to message after redirect
 *
 * @return boolean
 */
function plugin_centrodecusto_check_prerequisites() {
   //do what the checks you want
   return true;
}

/**
 * Check configuration process for plugin : need to return true if succeeded
 * Can display a message only if failure and $verbose is true
 *
 * @param boolean $verbose Enable verbosity. Default to false
 *
 * @return boolean
 */
function plugin_centrodecusto_check_config($verbose = false) {
   if (true) { // Your configuration check
      return true;
   }

   if ($verbose) {
      echo "Installed, but not configured";
   }
   return false;
}

/**
 * Optional: defines plugin options.
 *
 * @return array
 */
function plugin_centrodecusto_options() {
   return [
      Plugin::OPTION_AUTOINSTALL_DISABLED => true,
   ];
}

   // Version check
   if (version_compare(GLPI_VERSION, '9.1', 'lt') || version_compare(GLPI_VERSION, '9.2', 'ge')) {
    if (method_exists('Plugin', 'messageIncompatible')) {
       //since GLPI 9.2
       Plugin::messageIncompatible('core', 9.1, 9.2);
    } else {
       echo "This plugin requires GLPI >= 9.1 and < 9.2";
    }
    return false;
 }

