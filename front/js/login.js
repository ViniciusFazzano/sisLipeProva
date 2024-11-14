// Lógica de envio do formulário de login
document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    // Captura os dados de usuário e senha
    const nome = document.getElementById("username").value;

    // Dados do formulário que serão enviados
    const loginData = { nome };
    // Faz a requisição para o backend
    fetch("http://localhost:8080/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(loginData)
    })
        .then(response => {
            // Verifica se o código de status é 200
            if (response.status === 200) {
                alert("Bem Vindo.");
                window.location.href = "../../front/pages/calculo.html";
            } else {
                throw new Error("Falha na requisição: " + response.status);
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            alert("Ocorreu um erro ao se conectar com o servidor.");
        });
});

// Lógica de criação de conta
document.getElementById("create-account-form").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita o envio padrão do formulário de criação de conta

    // Captura os dados de nome e e-mail
    const nome = document.getElementById("name").value;
    const email = document.getElementById("email").value;

    // Dados do formulário que serão enviados
    const createAccountData = { nome, email };
    // Faz a requisição para o backend para criar a conta
    fetch("http://localhost:8080/novo-login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(createAccountData)
    })
        .then(response => {
            // Verifica se o código de status é 200
            if (response.status === 201) {
                alert("Conta criada com sucesso!");
                // Fecha o modal após sucesso
                // const modal = new bootstrap.Modal(document.getElementById('modalCreateAccount'));
                // modal.hide();
            } else {
                throw new Error("Falha ao criar conta: " + response.status);
            }
        }).then(data => {
            console.log(data)
        })
        .catch(error => {
            console.error("Erro:", error);
            alert("Erro:", error);
        });
});
