document.getElementById("asset_form").addEventListener("submit", function(event) {
    event.preventDefault(); // Previne o envio do formulário padrão
    // Captura os valores do formulário
    var users_id = document.getElementById("users_id").value;
    var ccusto_id = document.getElementById("ccusto_id").value;
    var is_director = document.getElementById("is_director").value;
    var is_manager = document.getElementById("is_manager").value;
    var is_belongs = document.getElementById("is_belongs").value;
    // Cria um objeto com os dados do formulário
    var formData = {
        users_id: users_id,
        ccusto_id: ccusto_id,
        is_director: is_director,
        is_manager: is_manager,
        is_belongs: is_belongs
    };
    // Envia os dados para o script do lado do servidor usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/cco.insert.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Força a atualização da página após o envio do formulário
            location.reload();
        }
    };
    xhr.send(JSON.stringify(formData));
});