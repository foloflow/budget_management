# Utilisez une image de PHP avec Apache
FROM php:8.1-apache

# Configurez le serveur Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Mettez à jour les paquets et installez les dépendances nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    nodejs \
    npm \
    locales \
    apt-utils \
    git \
    libicu-dev \
    g++ \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libxslt-dev \
    libssl-dev \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen

# Installez Composer
RUN curl -sS https://getcomposer.org/installer | php -- --disable-tls --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Installez des extensions PHP
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip calendar dom mbstring zip gd xsl

# Installez l'extension APCu
RUN pecl install apcu && docker-php-ext-enable apcu

# Copiez le contenu de votre application dans le conteneur
COPY . /var/www/

# Copiez la configuration Apache
COPY ./vhosts/vhosts.conf /etc/apache2/sites-available/000-default.conf

# Définissez le répertoire de travail
WORKDIR /var/www/project

# Exposez le port 80
EXPOSE 80