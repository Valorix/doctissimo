FROM php:7.2-fpm-alpine
RUN apk add --update --no-cache \
 $PHPIZE_DEPS \
 mysql-client \
 && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
 && docker-php-ext-install -j${NPROC} pdo_mysql \
 # Composer install
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
 && wget https://composer.github.io/installer.sig -O - -q | tr -d '\n' > installer.sig \
 && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
 && php composer-setup.php \
 && php -r "unlink('composer-setup.php'); unlink('installer.sig');" \
 && mv composer.phar /usr/local/bin/composer
WORKDIR /var/www/html
CMD ["php-fpm"]