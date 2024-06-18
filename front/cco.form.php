<?php

include("../../../inc/includes.php");
require_once "../src/cco.form.class.php";

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access this file directly");
}

Session::checkRight("profile", READ);

$plugin = new Plugin();
if (!$plugin->isInstalled('centrodecusto') || !$plugin->isActivated('centrodecusto')) {
    Html::displayNotFoundError();
}

Html::header(
    PluginCentrodecustoForm::getMenuName(),
    $_SERVER['PHP_SELF'],
    "Admin",
    "PluginCentrodecustoForm"
);

// Verifica se o link foi clicado
if (isset($_GET['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    // Consulta para selecionar outras colunas com base no ID fornecido
    $select_query = "SELECT 
                     `name`, `ccusto`, `visivel_chamado`, `visivel_projeto`, `itens`, `user`, `comment` 
                     FROM 
                     `glpi_plugin_centrodecusto_ccusto` 
                     WHERE 
                     `id` = '$id'";
    // Executa a consulta
    $result = $DB->query($select_query);

    if ($result && $result->num_rows > 0) {
        // Obtém a linha da consulta
        $row = $result->fetch_assoc();
        // Obtém os valores das colunas
        $name = $row['name'];
        $ccusto = $row['ccusto'];
        $visivel_chamado = $row['visivel_chamado'];
        $visivel_projeto = $row['visivel_projeto'];
        $itens = $row['itens'];
        $user = $row['user'];
        $comment = $row['comment'];
    }
    // Exibe o código apenas se o ID corresponder ao link específico
    if ($id == $id) {
        //caso o nome e numero seja vazio
        $ccusto = isset($ccusto) ? $ccusto : null;
        $name = isset($name) ? $name : null;
        $comment = isset($comment) ? $comment : null;
        
        PluginCentrodecustoCadastro::htmlnavigati();
        // Botões de navegação para o ID anterior e próximo
        $prev_id = ($id - 1 >= 0) ? $id - 1 : 0;
        $next_id = $id + 1;

        echo "<a a class=' text-info' href='?id=$prev_id'><<--</a>";
        echo '&nbsp;&nbsp;&nbsp;&nbsp;';
        echo "<a class=' text-info' href='?id=$next_id'>-->></a>";

        //titulo
        echo '     <h3 class="card-title d-flex align-items-center ps-5" center>';
        echo '         <span class="status rounded-1">';
        echo '            <i class="ti ti-coins"></i>';
        echo 'Centro de custo - ' . ($ccusto ? $ccusto : 'N/A') . ' - ' . ($name ? $name : 'N/A') . '';
        echo '         </span>';
        echo '      </h3>';

        PluginCentrodecustoCadastro::htmldropdown();
        #adiciona os links de CSS e JS
        echo '
               <link rel="stylesheet" href="../css/style.css">
                <script src="../js/config.js"></script>
          ';
        
        PluginCentrodecustoCadastro::htmlVertical();

        echo ' <div class="tab-content p-2 flex-grow-1 card border-start-0" style="min-height: 150px">';
        echo ' <div class="tab-pane fade show" role="tabpanel" id="tab-Group_main-1681541691">';
        echo '     <div class="asset">';
        echo '   <div class="container">';
        echo '       <div class="div1">';
        echo'         <br>';
        echo '        <form  method="POST "action="../ajax/cco.update.php" id="form-upadate" >';
        echo '        <input type="hidden" id="id" name="id" value="'.($id).'">';
        echo '        <div class="d-flex align-items-center">';
        echo '              <label for="name" class="mr-2">Nome:</label>'; // Adiciona margem à direita para separação
        echo '              <input type="text" id="name" name="name" class="form-control" value="'. ($name). '" style="width: 400px;">';
        echo '        </div>';
        echo'         <br>';
        echo '         <div class="d-flex align-items-center">';
        echo '              <label for="ccusto">Número:</label><br>';
        echo '              <input type="number" id="ccusto" name="ccusto" value="' . ($ccusto) . '">';
        echo '        </div>';
        echo'         <br>';
        //Campo Chamados
        echo '        <h3 class="centered-heading"> Chamado</h3> ';
        echo '        <div> ';
        echo '        <label for="visivel_chamado">Visível em um chamado:</label> ';
        echo '        <select id="visivel_chamado" name="visivel_chamado"> ';
        if ($visivel_chamado == 1) {
            echo '            <option value="1" selected>Sim</option> ';
            echo '            <option value="0">Não</option> ';
        } else {
            echo '            <option value="1">Sim</option> ';
            echo '            <option value="0" selected>Não</option> ';
        }
        echo '        </select> ';
        echo '        </div>';
        //Campo Projetos
        echo '        <h3 class="centered-heading"> Projeto</h3> ';
        echo '        <div> ';
        echo '        <label for="visivel_projeto">Visível em um chamado:</label> ';
        echo '        <select id="visivel_projeto" name="visivel_projeto"> ';

        if ($visivel_projeto == 1) {
            echo '            <option value="1" selected>Sim</option> ';
            echo '            <option value="0">Não</option> ';
        } else {
            echo '            <option value="1">Sim</option> ';
            echo '            <option value="0" selected>Não</option> ';
        }
        echo '        </select> ';
        echo '        </div>';
        //Campo Pode conster Usuário e Itens
        echo '        <h3 class="centered-heading">Pode Conter</h3> ';
        //Itens
        echo '        <div> ';
        echo '        <label for="itens">Itens:</label> ';
        echo '        <select id="itens" name="itens"> ';

        if ($itens == 1) {
            echo '            <option value="1" selected>Sim</option> ';
            echo '            <option value="0">Não</option> ';
        } else {
            echo '            <option value="1">Sim</option> ';
            echo '            <option value="0" selected>Não</option> ';
        }
        echo '        </select> ';
        echo '        </div>';
        echo '        <div> ';
        echo'         <br>';
        //Usuários
        echo '        <label for="itens">Usuários:</label> ';
        echo '        <select id="user" name="user"> ';
        if ($user == 1) {
            echo '            <option value="1" selected>Sim</option> ';
            echo '            <option value="0">Não</option> ';
        } else {
            echo '            <option value="1">Sim</option> ';
            echo '            <option value="0" selected>Não</option> ';
        }
        echo '        </select> ';
        echo '        </div>';
        echo '        </div>';
        //formulário de atualização do cadastro tela cco.form.php
        echo ' <div class="div2">';
        echo '     <label for="comment">Comentários:</label><br>';
        echo '       <textarea id="comment" name="comment" rows="4" cols="50" class="form-control">' . ($comment) . '</textarea>';
        echo '       <br>';
        echo '       <br>';
        echo '      </div>';
        echo ' </div>';
        echo '    <br>';

        echo '  <div class="card-body mx-n2 mb-4 border-top d-flex flex-row-reverse align-items-start flex-wrap">';
        echo '     <button id="atualziarRegistro" class="btn btn-primary" type="submit" id="add" name="submit"  value="submit">';
        echo '           <i class="far fa-save"></i>';
        echo '           <span>Salvar</span>';
        echo '     </button>';
            
        echo '      <button id="excluirRegistro" class="btn btn-outline-danger me-2 mb-2" value="' . ($id) . '" name="id" title="Clique duas vezes para excluir.">';
        echo '           <i class="ti ti-trash"></i>';
        echo '           <span>Excluir permanentemente</span>';
        echo '      </button>';
        echo '       </div>';
        echo ' </form>';
        echo '      </div>';
        echo ' </div>';
        //fim do formulario Centro de custo
        //Inicio do formulario 2
        echo '   <div class="tab-pane fade" role="tabpanel" id="tab-Group_main-1681541692">'; 
        echo '    <div class="asset">'; 
        echo '     <form name="asset_form" method="post" action="/glpi/front/group.form.php" enctype="multipart/form-data" data-submit-once="">'; 
        echo '      <!-- Form fields do terceiro formulário -->'; 
        echo '           Vai retornar os chamados criados para o centro de custo nessa tela'; 
        echo '       </form>'; 
        echo '     </div>'; 
        echo '   </div>'; 
        //Fim do formulario 2
        //Inicio do formulario usuário
      //Inicio do formuário usuário 4
      echo '   <div class="tab-pane fade" role="tabpanel" id="tab-Group_main-1681541693">';
      echo '    <div class="asset">';
      echo '<form method="POST" action="../ajax/cco.insert.php" id="asset_form">'; //Inicio do Formulário
      // Seleciona e inputa o centro de custo cadastrado no GLPI
      echo '<input type="hidden" name="ccusto_id" id="ccusto_id" value="' . ($id) . '">';
      echo '<div class="firstbloc">';
      echo '    <table class="tab_cadre_fixe">';
      echo '        <tbody>';
      echo '            <tr class="tab_bg_1">';
      echo '                <th colspan="8">Adicionar usuário';
      echo '                </th>';
      echo '            </tr>';
      echo '            <tr class="tab_bg_2">';
      echo '                <td class="center">';
      echo '                    <div class="btn-group btn-group-sm" role="group">';
      echo '                        <select id="users_id" name="users_id"> ';
      // Adiciona uma opção vazia
      echo '                            <option value="">-----</option>';
      // Seleciona usuário cadastrado GLPI
      include('../ajax/cco.select.php');
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $id_user = $row["id"];
              $nome_user = $row["name"];
              echo "<option  value='".($id_user)."'>".($nome_user)."</option>";
          }
      } else {
          echo "<option value=''>Nenhum usuário encontrado</option>";
      }
      echo '                        </select>';
      echo '                        <div class="btn btn-outline-secondary">';
      echo '                            <a id="comment_link_users_id944430917" class="dropdown_tooltip" target="_top" href="/glpi/front/user.php">';
      echo '                                <span class="fas fa-info fa-fw"></span>';
      echo '                            </a>';
      echo '                        </div>';
      echo '                    </div>';
      echo '                </td>';
      echo '                <td class="center">Diretor</td>';
      echo '                <td class="center">';
      echo '                    <select id="is_director" name="is_director">';
      echo '                        <option value="0">Não</option>';
      echo '                        <option value="1">Sim</option>';
      echo '                    </select>';
      echo '                </td>';
      echo '                <td class="center">Gerente</td>';
      echo '                <td class="center">';
      echo '                    <select id="is_manager" name="is_manager">';
      echo '                        <option value="0">Não</option>';
      echo '                        <option value="1">Sim</option>';
      echo '                    </select>';
      echo '                </td>';
      echo '                <td class="center">Pertence</td>';
      echo '                <td class="center">';
      echo '                    <select id="is_belongs" name="is_belongs">';
      echo '                        <option value="1">Sim</option>';
      echo '                        <option value="0">Não</option>';
      echo '                    </select>';
      echo '                </td>';
      echo '                <td class="center">';
      echo '                    <input type="submit" name="submit" value="Adicionar" class="btn-primary" style="background-color: #fec95c; width: 110px; height: 32px; border-radius: 3px;">';
      echo '                </td>';
      echo '            </tr>';
      echo '        </tbody>';
      echo '    </table>';
      echo '</div>';
      echo '</form>'; //fim do formulário
      //Adicione o link para o js
      echo '<script src="../js/insertUserCco.js"></script>';
      // tooltip ações
      echo '                    <a title="Ações" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-sm btn-outline-secondary me-1" onclick="showModal();" href="#" data-bs-original-title="Ações em massa">';
      echo '                      <i class="ti ti-corner-left-down mt-1"></i><span>Ações</span>';
      echo '                    </a>';
      //modal de seleção
      echo'   <div class="modal" id="myModal">';
      echo'   <div class="modal-dialog modal-xl">';
      echo'         <div class="modal-content">';
      echo'             <div class="modal-header">';
      echo'                <h5 class="modal-title">Ações</h5>';
      echo'                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>';
      echo'             </div>';
      echo'             <div class="modal-body"><div class="center"><img src="/glpi/pics/warning.png" alt="Aviso"><br><br><span class="b">Nenhum item selecionado</span><br></div></div>';
      echo'             </div>';
      echo'         </div>';
      echo'   </div>';
      //Inicio da tabela de usuário cadastrado no centro de custo
      echo '<div class="spaced">';
      echo '<table class="tab_cadre_fixehov">';
      echo '<tbody>';
      echo '<tr>';
      echo '<th width="10">';
      echo '<input class="form-check-input massive_action_checkbox" type="checkbox" id="checkall_title" value="" aria-label="Marcar todos como" onclick="checkAll(this)">';
      echo '</th>';
      echo '<th>Usuário</th>';
      echo '<th>Diretor</th>';
      echo '<th>Gerente</th>';
      echo '<th>Pertence</th>';
      echo '<th>Ativo</th>';
      echo '</tr>';//Inicio do tag tr

      // Seleciona o usuário cadastrado no centro de custo
      include('../ajax/cco.select.php');
      if ($result2) {
          // Itera sobre os resultados da consulta
          while ($row = $result2->fetch_assoc()) {
              //Verifica se o centro de custo é o mesmo selecionado na rota /front/cco.form.php?id=1
              if($row['ccusto_id'] == $id){
                  echo '<tr class="tab_bg_1">';
                  echo '<td width="10">';
                  echo '<input type="checkbox" class="form-check-input row_checkbox" value="" aria-label="Marcar esta linha" name="item[Group_User][' . $row['id'] . ']" value="1">';
                  echo '</td>';
                  //selecionar o usuário do GLPI e verifica se ele está ativo e é se é igual ao ID
                  $select_query4 = "SELECT * FROM `glpi_users` WHERE `id` = '".$row['users_id']."'";
                  $result3 = $DB->query($select_query4);
                  if ($result3 && $result3->num_rows > 0) {
                      $row2 = $result3->fetch_assoc();
                  echo '<td><a href="/glpi/front/user.form.php?id='.$row['users_id'].'" title="usuário">'.($row2['name']).'</a></td>';
                  echo '<td>' . ($row['is_director'] ? '<img src="/glpi/pics/ok.png" width="14" height="14" alt="Ativo">' : '') . '</td>';
                  echo '<td>' . ($row['is_manager'] ? '<img src="/glpi/pics/ok.png" width="14" height="14" alt="Ativo">' : '') . '</td>';
                  echo '<td>' . ($row['is_belongs'] ? '<img src="/glpi/pics/ok.png" width="14" height="14" alt="Ativo">' : '') . '</td>';
                  echo '<td>' . ($row2['is_active'] ? '<img src="/glpi/pics/ok.png" width="14" height="14" alt="Ativo">' : '') . '</td>';
                  }
                  echo '</tr>';//Fim do tag tr
              }
          }
      }
      echo '</tbody>';
      echo '</table>';
      echo '</div>';
      echo '</div>';
      //Fim do formuário usuário.
     echo '    
        <!-- Adicione mais divs conforme necessário para outras abas -->
    </div>
</div>';

        //javascript busca efetuar a exclusão do registo se o ID for igual a o atual
        echo '<!-- Envia a solicitação AJAX para excluir o registro -->
        <script>
            document.getElementById("excluirRegistro").addEventListener("click", function(event) {
                event.preventDefault(); // Impede o comportamento padrão do botão (enviar o formulário)
                // Adicione aqui a lógica para confirmar a exclusão ou realizar outras ações desejadas
                $(document).ready(function(){
                    $("#excluirRegistro").click(function(){
                        // Pergunta se o usuário deseja realmente excluir o registro
                        if (confirm("Tem certeza que deseja excluir o centro de Custo: ' . ($name) . '?")) {
                            // Envia a solicitação AJAX para excluir o registro
                            $.ajax({
                                url: "../ajax/cco.delete.php", // URL do script PHP que executa a exclusão do registro
                                method: "POST",
                                data: {
                                    id: "' . ($id) . '",
                                    name: "' . ($name) . '"
                                }, // Dados a serem enviados para o servidor
                                success: function(response){
                                    // Aqui você pode lidar com a resposta do servidor, se necessário
                                    alert("Centro de custo: ' . ($name) . ' foi excluído com sucesso!");
                                    // Você pode redirecionar o usuário para outra página após a exclusão, se desejar
                                    window.location.href = "cco.php";
                                },
                                error: function(xhr, status, error){
                                    // Lidar com erros, se ocorrerem
                                    console.error(error);
                                    alert("Ocorreu um erro ao excluir o registro.");
                                }
                            });
                        } else {
                            alert("Centro de custo: ' . ($name) . ', não foi cancelado!");
                            // Caso o usuário clique em "Cancelar", você pode redirecioná-lo para outra página ou fazer qualquer outra ação desejada.
                            window.location.href = "../front/cco.form.php?id=' . ($id) . '";
                        }
                    });
                });
            });
        </script>
    ';
    } #Final do if(Exibe o código apenas se o ID corresponder ao link específico).
} #Final do if(Verifica se o link foi clicado).
else {

 #exibe formulário caso não ouver acesso pelo link cco.form.php?id=22
   PluginCentrodecustoCadastro::htmlHeader();
    
}