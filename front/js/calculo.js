document.getElementById("formulario").addEventListener("submit", function (event) {
  event.preventDefault(); 

  const formData = {
    qnt_saco: document.getElementById("varQntSaco").value,
    kilo_batida: document.getElementById("varKiloBatida").value,
    kilo_saco: document.getElementById("varKiloSaco").value,
    qnt_cabeca: document.getElementById("varQntCabeca").value,
    consumo_cabeca: document.getElementById("varConsumoCabeca").value,
    grama_homeopatia_cabeca: document.getElementById("varGramaHomeopatiaCabeca").value,
    gramas_homeopatia_caixa: document.getElementById("varGramasHomeopatiaCaixa").value
  };

  fetch('http://localhost:8080/calculo', {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(formData)
  })
    .then(response => {
      if (response.status === 200) {
        return response.json();
      } else {
        alert("Falha na requisição: " + response.status)
        throw new Error("Falha na requisição: " + response.status);
      }
    })
    .then(data => {
      console.log(data);
      alert(JSON.stringify(data.message));

      const items = data.items;
      document.getElementById("varQntSaco").value = items.varQntSaco;
      document.getElementById("varKiloBatida").value = items.varKiloBatida;
      document.getElementById("varKiloSaco").value = items.varKiloSaco;
      document.getElementById("varQntCabeca").value = items.varQntCabeca;
      document.getElementById("varConsumoCabeca").value = items.varConsumoCabeca;
      document.getElementById("varGramaHomeopatiaCabeca").value = items.varGramaHomeopatiaCabeca;
      document.getElementById("varGramasHomeopatiaCaixa").value = items.varGramasHomeopatiaCaixa;

      document.getElementById("qntBatida").value = items.qntBatida;
      document.getElementById("qntCaixa").value = items.qntCaixa;
      document.getElementById("varGramasHomeopatiaSaco").value = items.varGramasHomeopatiaSaco;
      document.getElementById("varKiloHomeopatiaBatida").value = items.varKiloHomeopatiaBatida;
      document.getElementById("pesoTotal").value = items.pesoTotal;
      document.getElementById("consumoCabecaKilo").value = items.consumoCabecaKilo;
      document.getElementById("cabecaSaco").value = items.cabecaSaco;

    })
    .catch(error => {
      console.error("Erro:", error);
      alert("Ocorreu um erro ao se conectar com o servidor.");
    });
});
