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

class PluginCentrodecustoApplication extends CommonDBTM 
{
   function htmlHeader()
   { 
    echo
    <<<HTML
          <div class="btn-group flex-wrap mb-3">
              <span class="btn bg-blue-lt pe-none" aria-disabled="true">
                 <i class="fas fa-coins fa-lg me-2"></i>Centro de Custo
              </span>
              <a class="btn btn-outline-secondary" href="cco.form.php"><i class="fas fa-coins fa-lg me-2"></i>Adicionar Cco</a>
          </div>
      HTML;
    }

    function htmlaction() {
        echo
        <<<HTML
        
        <div class="card-header d-flex justify-content-between search-header pe-0 text-white">
        <div class="d-inline-flex search-controls">
            <a title="" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-sm btn-outline-secondary me-1" onclick="showModal();" href="#" data-bs-original-title="Ações em massa">
                <i class="ti ti-corner-left-down mt-1" style="margin-left: -2px;"></i><span>Ações</span>
            </a>   
            <label class="form-check form-switch btn btn-sm btn-ghost-secondary me-0 me-sm-1 px-1 mb-0 flex-column-reverse flex-sm-row" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover" title="" data-bs-original-title="Ativar filtros de pesquisa">
                <input type="checkbox" class="form-check-input ms-0 me-1 mt-0 fold-search" role="button" autocomplete="off">
                <span class="form-check-label mb-1 mb-sm-0">
                    <i class="ti fa-lg ti-search"></i>
                </span>
            </label>
            <div class="d-inline-flex" role="group">
                <button class="btn btn-sm btn-icon btn-ghost-secondary show_displaypreference_modal me-0 me-sm-1" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Selecione os itens padrões a serem mostrados">
                    <i class="ti fa-lg ti-tool"></i>
                </button>
                <button class="dropdown-toggle btn btn-sm btn-icon btn-ghost-secondary" type="button" id="dropdown-export" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="py-1 px-2 my-n1 mx-n2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Exportar">
                        <i id="export_dropdown_icon" class="ti fa-lg ti-file-download"></i>
                    </span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdown-export">
                    <li><a class="dropdown-item" href="/glpi/front/report.dynamic.php?item_type=Group&amp;sort%5B0%5D=1&amp;order%5B0%5D=ASC&amp;start=0&amp;criteria%5B0%5D%5Bfield%5D=view&amp;criteria%5B0%5D%5Blink%5D=contains&amp;criteria%5B0%5D%5Bvalue%5D=&amp;display_type=2">
                        <i class="far fa-lg fa-file-pdf"></i>
                        Página atual em PDF paisagem
                    </a></li>
                    <!-- other list items -->
                </ul>
            </div>
        </div>
    </div>
    
    <div class="modal" id="myModal">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Ações</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
               </div>
               <div class="modal-body"><div class="center"><img src="/glpi/pics/warning.png" alt="Aviso"><br><br><span class="b">Nenhum item selecionado</span><br></div></div>
           </div>
       </div>
    </div>
    
        <!-- Adicione o link para o js -->
        <script src="../js/config.js"></script>
    HTML;
    }

    function Buttonaction() {
        echo
        <<<HTML
        
        <div class="card-header d-flex justify-content-between search-header pe-0 text-white">
        <div class="d-inline-flex search-controls">
            <a title="" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-sm btn-outline-secondary me-1" onclick="showModal();" href="#" data-bs-original-title="Ações em massa">
                <i class="ti ti-corner-left-down mt-1" style="margin-left: -2px;"></i><span>Ações</span>
            </a>   
        </div>
    </div>
    
    <div class="modal" id="myModal">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Ações</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
               </div>
               <div class="modal-body"><div class="center"><img src="/glpi/pics/warning.png" alt="Aviso"><br><br><span class="b">Nenhum item selecionado</span><br></div></div>
           </div>
       </div>
    </div>
    
        <!-- Adicione o link para o js -->
        <script src="../js/config.js"></script>
    HTML;
    }
}


