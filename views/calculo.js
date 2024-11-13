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

  // Envia os dados usando fetch
  fetch('http://localhost:8099/calculo', {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(formData)
  })
    .then(response => response.json())
    .then(data => {
      // Manipula a resposta do servidor
      if (data.success) {
        alert("Cálculo realizado com sucesso!");
        console.log(data.resultados); // Exemplo de como lidar com os dados
      } else {
        alert("Erro ao realizar o cálculo. Tente novamente.");
      }
    })
    .catch(error => {
      console.error("Erro:", error);
      alert("Ocorreu um erro ao se conectar com o servidor.");
    });
});
