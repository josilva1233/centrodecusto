<?php
use Glpi\Application\View\TemplateRenderer;
use Glpi\RichText\RichText;
use Glpi\Dashboard\Grid;

include("../../../inc/includes.php");

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access this file directly");
}

Session::checkRight("profile", READ);

$plugin = new Plugin();
if (!$plugin->isInstalled('centrodecusto') || !$plugin->isActivated('centrodecusto')) {
    Html::displayNotFoundError();
}

class PluginCentrodecustoCadastro extends CommonTreeDropdown 
{
    static function htmlHeader()
    {
        echo
        <<<HTML
    
    <!-- Adicione o link para o jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="/glpi/js/notifications_ajax.min.js?v=6c873ee8602a18b5a8983a5c2c3b3c16a714dd06"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Adicione o link para o css -->
    <link rel="stylesheet" href="../css/style.css">
    
    <div id="header_32135966" class="card-header main-header d-flex flex-wrap mx-n2 mt-n2 align-items-stretch flex-grow-1">
        <h3 class="card-title d-flex align-items-center ps-4">
            <span class="centered-heading">
                <i class="fas fa-coins fa-lg me-2"></i>
                Novo item - Centro de Custo
            </span>
        </h3>
    </div>
    
    <div class="container">
        <div class="div1">
            <form method="POST" action="../ajax/cco.insertForm.php" id="form-register">
                <br>
                <div class="d-flex align-items-center">
                    <label for="name" class="me-auto text-right">Nome:</label> <!-- Adicionando margem à direita do label -->
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <label for="ccusto" class="me-auto text-right">Número:</label>
                    <input type="number" id="ccusto" name="ccusto" class="form-control" required>
                </div>
                <br>
                <h3 class="centered-heading">Chamado</h3>
                <div>
                    <label for="visivel_chamado" class="me-lg-4 text-right">Visível em um chamado:</label>
                    <select id="visivel_chamado" name="visivel_chamado">
                        <option  value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
    
                <h3 class="centered-heading">Projeto</h3>
                <div class="">
                    <label for="visivel_projeto" class="me-lg-1 text-right">Visível em um Projeto:</label>
                    <select id="visivel_projeto" name="visivel_projeto">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                
                <h3 class="centered-heading">Pode Conter</h3>
                <div>
                    <label for="itens" class="me-10 text-right">Itens:</label>
                    <select id="itens" name="itens">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                
                <div>
                    <label for="user" class="me-10 text-right">Usuários:</label>
                    <select id="user" name="user">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
            </div>

            <div class="div2">
                <label for="comment" class="me-2">Comentários:</label><br>
                <textarea id="comment" name="comment" rows="4" cols="50" class="form-control"></textarea><br><br>
            </div>
        </div>
       
        <button class="btn btn-primary me-2" type="submit" id="add" name="submit">
            <i class="fas fa-plus"></i>
            <span>Adicionar</span>
        </button>
        <br>
        <br>
        
    </form>
    
    <!-- Adicione o link para o js -->
    <script src="../js/insert.js"></script>
    
    HTML;
    }

    static function htmlnavigati() {
        //navigationheader
        echo '<div class="navigationheader justify-content-sm-between">';
        echo '   <div>';
        echo '   </div>';
        echo '   <div id="header_1926246407" class="card-header main-header d-flex flex-wrap mx-n2 mt-n2 align-items-stretch  align-self-end  flex-grow-1">';
   }

    static function htmldropdown() {
        //dropdown
        echo '      <div class="d-none d-sm-block btn-group ms-auto">';
        echo '        <a href="/glpi/plugins/centrodecusto/front/cco.php" title="Listar Centros de custo" class="btn btn-sm btn-icon btn-ghost-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Lista">';
        echo '            <i class="far fa-lg fa-list-alt fs-1"></i>';
        echo '         </a>';
        echo '         <a class="btn btn-outline-secondary" href="cco.form.php">';
        echo '            <i class="fas fa-coins me-1"></i> Adicionar Cco';
        echo '         </a>';
        echo '      </div>';
        echo '   </div>';
        echo '</div>';
   }

   static function htmlVertical() {
         //inicio do paleta lataral 
         echo ' <div class="d-flex card-tabs flex-column flex-md-row vertical">
         <ul class="nav nav-tabs flex-row flex-md-column d-none d-md-block" id="tabspanel" style="min-width: 200px" role="tablist">
            <li class="nav-item ms-0">
                <a class="nav-link justify-content-between pe-1 active" data-bs-toggle="tab" title="Grupo" href="#tab-Group_main-1681541691" data-bs-target="#tab-Group_main-1681541691">Centro de Custo</a>
            </li>
            <li class="nav-item ms-0">
               <a class="nav-link justify-content-between pe-1" data-bs-toggle="tab" title="Grupo" href="#tab-Group_main-1681541692" data-bs-target="#tab-Group_main-1681541692">Chamados criados</a>
            </li>
            <li class="nav-item ms-0">
               <a class="nav-link justify-content-between pe-1" data-bs-toggle="tab" title="Grupo" href="#tab-Group_main-1681541693" data-bs-target="#tab-Group_main-1681541693">Usuários</a>
            </li>
            <!-- Adicione mais links conforme necessário -->
        </ul>
        <select class="form-select border-2 border-secondary rounded-0 rounded-top d-md-none mb-2" id="tabspanel-select">
           <!-- Options for mobile view -->
           <option value="#tab-Group_main-1681541691">Centro de Custo</option>
           <option value="#tab-Group_main-1681541692">Chamados criados</option>
           <option value="#tab-Group_main-1681541693 ">Usuários</option>
        </select>

        ';
    }

}



