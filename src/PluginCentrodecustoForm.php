<?php

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access this file directly");
}

Session::checkRight("profile", READ);

$plugin = new Plugin();
if (!$plugin->isInstalled('centrodecusto') || !$plugin->isActivated('centrodecusto')) {
    Html::displayNotFoundError();
}

class PluginCentrodecustoForm extends CommonTreeDropdown  {

    static function getMenuName() {
        return __('Centro de Custo', 'centrodecusto');
    }

    static function getTypeName($nb = 0) {
        return _n('Centro de Custo', 'Centros de Custo', $nb, 'centrodecusto');
    }

    
    public static function getIcon()
    {
        return "ti ti-coins";
    }
    
    static function getMenuContent() {
        return [
            'title'  => self::getMenuName(),
            'page'   => '/plugins/centrodecusto/front/cco.php',
            'links'  => [],
            'icon'   => 'ti ti-coins'
        ];
    }

    static function showList(){
        GLOBAL $DB;
        //instância a classe
        $plugin = new PluginCentrodecustoApplication();
        // Chama a classe htmlHeader()
        $plugin->htmlHeader();
        // Chama a classe htmlaction()
        $plugin->htmlaction();
    
        $items_por_pagina = 10;
        $pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $offset = ($pagina_atual - 1) * $items_por_pagina;
        $sql = "SELECT * FROM glpi_plugin_centrodecusto_ccusto LIMIT $items_por_pagina OFFSET $offset";
        $result = $DB->query($sql);
    
        // Verificar se há registros retornados
        if ($result && $DB->numrows($result) > 0) {
            echo '<table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">'; //inicio da tabela
            echo '<tr>
                     <th style="background-color: #f2f2f2;">
                          <input class="form-check-input massive_action_checkbox" type="checkbox" id="checkall_title" value="" aria-label="Marcar todos como" onclick="checkAll(this)">
                     </th>
                     <th style="background-color: #f2f2f2;">
                          NOME COMPLETO
                     </th>
                     <th style="background-color: #f2f2f2;">
                          COMENTÁRIOS
                     </th>
                 </tr>';
    
            // Inicializa uma variável para alternar entre as cores
            $color = '#f9f9f9'; // cinza mais claro
    
            // Loop pelos resultados e criar linhas para a tabela
            while ($row = $DB->fetchAssoc($result)) {
                // Alterna entre as cores de fundo das linhas
                $color = ($color == '#f9f9f9') ? '#ffffff' : '#f9f9f9'; // alterna entre branco e cinza claro
                echo '<tr style="background-color: ' . $color . ';">'; // Abre a linha com cor alternada
                echo '<td><input class="form-check-input row_checkbox" type="checkbox" value="" aria-label="Marcar esta linha"></td>'; // Campo de entrada
                echo '<td><a href="cco.form.php?id=' . $row['id'] . '">' . $row['name'] . '</a></td>'; // Exibe o ID como um link
                echo '<td>' . $row['comment'] . '</td>'; // Exibe o Name
                echo '</tr>'; // Fecha a linha
            }
    
            $sql_total = "SELECT COUNT(*) AS total FROM glpi_plugin_centrodecusto_ccusto";
            $result_total = $DB->query($sql_total);
            $total_registros = $DB->fetchAssoc($result_total)['total'];
            $total_paginas = ceil($total_registros / $items_por_pagina);
    
            echo '<div class="card-footer search-footer" style="display: flex; justify-content: space-between;">';
            echo '<div>Página: <select onchange="location = this.value;">';
            for ($i = 1; $i <= $total_paginas; $i++) {
                $selected = ($pagina_atual == $i) ? 'selected' : '';
                echo "<option value='?pagina=$i' $selected>$i</option>";
            }
            echo '</select> de ' . $total_paginas . ' páginas</div>'; // Adiciona a quantidade de páginas aqui
    
            echo '<div>';
            if ($pagina_atual > 1) {
                echo '<a href="?pagina='.($pagina_atual - 1).'">Anterior</a> <- ';
            }
            if ($pagina_atual < $total_paginas) {
                echo ' --> <a href="?pagina='.($pagina_atual + 1).'">Próxima</a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</table>'; //Fim da tabela
            echo '<hr>';
        } else {
            echo '<br>';
            echo '<div style="text-align: center;">';
            echo __('No item found');
            echo '</div>';
        }
    } 

    static function getListData(){
        GLOBAL $DB;
        $data = array();
        $sql = "SELECT id, name FROM glpi_plugin_centrodecusto_ccusto";
        $result = $DB->query($sql);
        if ($result && $DB->numrows($result) > 0) {
            while ($row = $DB->fetchAssoc($result)) {
                $data[] = array(
                    'id' => $row['id'],
                    'name' => $row['name']
                );
            }
        }
        return $data;
    }

    static function getListDataUser(){
        GLOBAL $DB;
        $data2 = array();
        $sql2 = "SELECT id, users_id, ccusto_id FROM glpi_plugin_centrodecusto_ccusto_users";
        $result2 = $DB->query($sql2);
        if ($result2 && $DB->numrows($result2) > 0) {
            while ($row2 = $DB->fetchAssoc($result2)) {
                $data2[] = array(
                    'id' => $row2['id'],
                    'users_id' => $row2['users_id'],
                    'ccusto_id'=> $row2['ccusto_id']
                );
            }
        }
        return $data2;
    }




}



