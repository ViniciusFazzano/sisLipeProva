# Usar a imagem oficial do PHP com Apache
FROM php:8.0-apache

# Instalar extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o contêiner
COPY . /var/www/html/

# Habilitar o módulo de reescrita do Apache
RUN a2enmod rewrite

# Configurar o Apache para permitir reescrita de URLs
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf
