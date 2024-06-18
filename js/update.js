document.getElementById("form-upadate").addEventListener("submit", function(event) {
    event.preventDefault(); // Previne o envio do formulário padrão

    // Captura os valores do formulário
    var id = document.getElementById("id").value;
    var name = document.getElementById("name").value;
    var ccusto = document.getElementById("ccusto").value;
    var visivel_chamado = document.getElementById("visivel_chamado").value;
    var visivel_projeto = document.getElementById("visivel_projeto").value;
    var itens = document.getElementById("itens").value;
    var user = document.getElementById("user").value;
    var comment = document.getElementById("comment").value;

    // Cria um objeto com os dados do formulário
    var formData = {
        id: id,
        name: name,
        ccusto: ccusto,
        visivel_chamado: visivel_chamado,
        visivel_projeto: visivel_projeto,
        itens: itens,
        user: user,
        comment: comment
    };

    // Envia os dados para o script do lado do servidor usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/cco.update.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {

        }
    };
    xhr.send(JSON.stringify(formData));
});