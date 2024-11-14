
document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault(); 

    const nome = document.getElementById("username").value;

    const loginData = { nome };
    
    fetch("http://localhost:8080/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(loginData)
    })
        .then(response => {
            
            if (response.status === 200) {
                alert("Bem Vindo.");
                window.location.href = "../../front/pages/calculo.html";
            } else {
                alert("Falha na requisição: " + response.status)
                throw new Error("Falha na requisição: " + response.status);

            }
        })
        .catch(error => {
            console.error("Erro:", error);
            alert("Ocorreu um erro ao se conectar com o servidor.");
        });
});


document.getElementById("create-account-form").addEventListener("submit", function (event) {
    event.preventDefault(); 
    
    const nome = document.getElementById("name").value;
    const email = document.getElementById("email").value;

    const createAccountData = { nome, email };
    
    fetch("http://localhost:8080/novo-login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(createAccountData)
    })
        .then(response => {
            
            if (response.status === 201) {
                alert("Conta criada com sucesso!");        
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
