document.getElementById("calculoForm").addEventListener("submit", function (event) {
  event.preventDefault(); // Evita o envio padrão do formulário

  // Obtém os dados do formulário
  const formData = {
    qnt_saco: document.getElementById("qnt_saco").value,
    kilo_batida: document.getElementById("kilo_batida").value,
    kilo_saco: document.getElementById("kilo_saco").value,
    qnt_cabeca: document.getElementById("qnt_cabeca").value,
    consumo_cabeca: document.getElementById("consumo_cabeca").value,
    grama_homeopatia_cabeca: document.getElementById("grama_homeopatia_cabeca").value,
    gramas_homeopatia_caixa: document.getElementById("gramas_homeopatia_caixa").value
  };

  console.log( JSON.stringify(formData));

  // Envia os dados usando fetch
  fetch('http://localhost:8080/calculo', {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(formData)
  })
    .then(response => {
      // Verifica se o código de status é 200
      // console.log(response.json())
      if (response.status === 200) {
        return response.json()
        // alert("fez a requisicao.");
        // window.location.href = "../../front/pages/calculo.html";
      } else {
        throw new Error("Falha na requisição: " + response.status);
      }
    })
    .then(data => {
      console.log(data)
    })
    .catch(error => {
      console.error("Erro:", error);
      alert("Ocorreu um erro ao se conectar com o servidor.");
    });
});
