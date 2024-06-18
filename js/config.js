document.addEventListener("DOMContentLoaded", function() {
    var navLinks = document.querySelectorAll(".nav-link");
    var tabPanes = document.querySelectorAll(".tab-pane");

    // Função para ativar a aba específica
    function activateTab(targetId) {
        // Remove a classe "active" de todos os links
        navLinks.forEach(function(link) {
            link.classList.remove("active");
        });

        // Adiciona a classe "active" ao link que corresponde ao targetId
        var activeLink = document.querySelector(`.nav-link[data-bs-target="${targetId}"]`);
        if (activeLink) {
            activeLink.classList.add("active");
        }

        // Oculta todas as outras abas e mostra apenas a aba alvo
        tabPanes.forEach(function(tab) {
            if (tab.id === targetId.substring(1)) { // remove o # do targetId
                tab.classList.add("show");
                tab.classList.add("active"); // Adiciona a classe 'active' à aba mostrada
            } else {
                tab.classList.remove("show");
                tab.classList.remove("active"); // Remove a classe 'active' das outras abas
            }
        });
    }

    // Adiciona um ouvinte de evento de clique a cada link
    navLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            var targetId = this.getAttribute("data-bs-target");
            // Salva o targetId no localStorage
            localStorage.setItem("activeTab", targetId);
            // Ativa a aba clicada
            activateTab(targetId);
        });
    });

    // Verifica se há uma aba ativa salva no localStorage
    var savedTab = localStorage.getItem("activeTab");
    if (savedTab) {
        activateTab(savedTab);
    } else {
        // Ativa a primeira aba por padrão, caso não haja nada salvo no localStorage
        var firstTab = navLinks[0].getAttribute("data-bs-target");
        activateTab(firstTab);
    }
});

function checkAll(source) {
    var checkboxes = document.getElementsByClassName("row_checkbox");
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}

function showModal() {
    var myModal = new bootstrap.Modal(document.getElementById("myModal"), {
        keyboard: false
    });
    myModal.show();
}