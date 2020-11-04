# Current Version 2.1
FROM ubuntu:18.04

RUN apt-get upgrade; apt-get update -y;

ENV DEBIAN_FRONTEND=noninteractive

# Install Helpers
RUN apt-get install -y curl zsh nano git htop vim unzip; \
    sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"; \
    sed -i s^robbyrussell^example^g ~/.zshrc;

# Install SSH deps
RUN apt-get install -y openssh-server; \
    mkdir -p /root/.ssh; \
    touch /root/.ssh/authorized_keys

# Install Apache
RUN apt-get install -y apache2; \
    a2enmod actions alias ssl rewrite headers setenvif; \
    rm -rf /var/www/html/*; \
    echo "ServerName localhost\n$(cat /etc/apache2/apache2.conf)" > /etc/apache2/apache2.conf;

# Install Node + Yarn
RUN apt-get update && apt-get install -y gnupg2
RUN apt-get install -y nodejs;
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -;
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list;
RUN apt update -y;
RUN apt install -y yarn;

# Install PHP
RUN apt-get install -y software-properties-common zip; \
    add-apt-repository -y ppa:ondrej/php; \
    apt-get update -y; \
    apt-get install -y php7.2 php7.2-cli php7.2-common php7.2-dev php7.2-curl \
        php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml php7.2-intl \
        php7.2-json libapache2-mod-php7.2 php7.2-bcmath php7.2-gd php7.2-soap; \
    a2enmod php7.2; \
    curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer; \
    sed -i "s^memory_limit = -1^memory_limit=1024M^g" /etc/php/7.2/cli/php.ini; \
    sed -i "s^memory_limit = 128M^memory_limit=1024M^g" /etc/php/7.2/apache2/php.ini; \
    sed -i "s^max_execution_time = 30^max_execution_time = 300^g" /etc/php/7.2/apache2/php.ini;

# Install xdebug
RUN apt-get install -y php-xdebug; \
    touch /var/log/xdebug.log; \
    chmod 666 /var/log/xdebug.log;

# @NOTE: edit REMOTE_HOST - the default will work on docker desktop for mac
RUN config="[Xdebug]\nxdebug.remote_enable = true\nxdebug.remote_autostart = true\nxdebug.remote_host = 'host.docker.internal'\nxdebug.remote_port = 9000\nxdebug.remote_log = /var/log/xdebug.log\nxdebug.max_nesting_level = 250\n\n"; \
    echo "${config}$(cat /etc/php/7.2/cli/php.ini)" > /etc/php/7.2/cli/php.ini; \
    echo "${config}$(cat /etc/php/7.2/apache2/php.ini)" > /etc/php/7.2/apache2/php.ini;

# Runs apache process
CMD apachectl -D FOREGROUND
