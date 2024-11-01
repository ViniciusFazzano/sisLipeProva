# SITE DE INSTALADOR DE UM JOGO

Este projeto é uma aplicação web simples construída em PHP, utilizando Docker para gerenciamento do ambiente. A aplicação inclui uma tela de login e uma tela para criação de conta, com um sistema de roteamento básico.

## Dependencias e Ferramentas
- **BACK-END**
  * Banco de dados  : Postgres
  * Composer : psr-4, PDO e PHPUNIT
- **FRONT-END**
  * HTML,CSS,JAVASCRIPT

     
## Publico alvo
* Pessoas que gostam de jogos de tiro e gastar dinhero com isso!


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

## Configuração do Ambiente

Para executar este projeto, você precisará ter o Docker e o Docker Compose instalados em sua máquina.
