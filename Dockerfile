# Usar a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instalar dependências e a extensão PDO para PostgreSQL
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Baixe e instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar o módulo de reescrita do Apache
RUN a2enmod rewrite

# Configurar o diretório de trabalho para o Apache
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o contêiner
COPY ./src/ /var/www/html/

# Permissões para o diretório
RUN chown -R www-data:www-data /var/www/html

# Expor a porta 80 para acessar o servidor
EXPOSE 80
