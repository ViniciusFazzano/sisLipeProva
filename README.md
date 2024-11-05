# SISTEMA DE RECALCULO DE BATIDAS PARA LOJA DE HOMEOPATIA ANIMAL

Este projeto é uma aplicação web simples construída em PHP, utilizando Docker para gerenciamento do ambiente. A aplicação tem como objetivo facilitar o recálculo de batidas de produtos homeopáticos para animais, permitindo que os usuários ajustem as dosagens conforme necessário.

## Dependências e Ferramentas

- **BACK-END**
  - Banco de dados: Postgres
  - Composer: psr-4, PDO e PHPUNIT

- **FRONT-END**
  - HTML, CSS, JavaScript

## Público Alvo

- Proprietários de animais que utilizam produtos homeopáticos e profissionais da área veterinária que desejam um sistema prático para recálculo de dosagens.

## Estrutura de Pastas

A estrutura de pastas do projeto é organizada da seguinte forma:

### Descrição das Pastas e Arquivos

- **diretorio-principal**
  - **public/**: Contém os arquivos que são diretamente acessíveis pelo navegador. O `index.php` atua como o ponto de entrada da aplicação.
  - **src/**: Contém a lógica do código-fonte da aplicação, incluindo o roteador e os controladores que gerenciam as requisições.
  - **views/**: Contém os arquivos de template que geram o HTML a ser enviado ao navegador.
  - **assets/**: Contém arquivos estáticos, como CSS e imagens, utilizados pela aplicação.
  - **Dockerfile**: Define como a imagem do Docker será construída, incluindo as configurações do PHP e do Apache.
  - **docker-compose.yml**: Configura os serviços do Docker, incluindo o contêiner do PHP/Apache.
  - **composer.json**: Define as dependências do PHP para o projeto, permitindo a instalação de bibliotecas e frameworks necessários.

## DRAW DO SISTEMA
![image](https://github.com/user-attachments/assets/faa8de95-c64a-4651-8046-442b10472dca)
