FROM ubuntu:16.04

RUN DEBIAN_FRONTEND=noninteractive

# Add config file
ADD docker/root/ /

# Update & upgrade
RUN apt-get update && apt-get -y upgrade

#-------------------------------------------------------------------------------
# Service management by supervisor
#-------------------------------------------------------------------------------
RUN apt-get -y install supervisor

#-------------------------------------------------------------------------------
# SSH
# Default option `INSTALL_SSH=false`
#-------------------------------------------------------------------------------
ADD docker/root/.ssh/id_rsa /root/.ssh/id_rsa
ADD docker/root/.ssh/id_rsa.pub /root/.ssh/id_rsa.pub
ARG INSTALL_SSH=false
ENV INSTALL_SSH ${INSTALL_SSH}
RUN if [ ${INSTALL_SSH} = true ]; then \
    apt-get -y install openssh-server && \
    cat /root/.ssh/id_rsa.pub >> /root/.ssh/authorized_keys && \
    chmod 644 /root/.ssh/authorized_keys /root/.ssh/id_rsa.pub && \
    chmod 400 /root/.ssh/id_rsa && \
    # SSH login fix. Otherwise user is kicked off after login
    sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd && \
    mkdir /var/run/sshd \
;fi

#-------------------------------------------------------------------------------
# Apache-php
# Default option `INSTALL_APACHE_PHP=false`
#-------------------------------------------------------------------------------
ARG INSTALL_APACHE_PHP=false
ENV INSTALL_APACHE_PHP ${INSTALL_APACHE_PHP}
RUN apt-get install -y software-properties-common language-pack-en-base && \
    LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php && \
    apt-get update
RUN if [ ${INSTALL_APACHE_PHP} = true ]; then \
    apt-get install -y apache2 && \
    apt-get install -y \
        curl \
        git-core \
        openssh-server \
        php7.2 \
        php7.2-common \
        php7.2-cli \
        php7.2-gd \
        php7.2-json \
        php7.2-mbstring \
        php7.2-xml \
        php7.2-xsl \
        php7.2-zip \
        php7.2-soap \
        php-pear \
        libapache2-mod-php7.2 \
        php7.2-curl \
        php7.2-mysql \
        php7.2-dev \
        && \
    # Apache2 config
    mkdir -p /var/lock/apache2 /var/run/apache2 && \
    mkdir -p /var/www/html/current/public/uploads/delivery_image && \
    mkdir -p /var/www/html/current/public/uploads/product_image && \
    chown -R www-data:www-data /var/www/html/current/public/uploads && \
    mkdir -p /var/www/html/current/storage && \
    chown -R www-data:www-data /var/www/html/current/storage && \

    # Enable mode
    a2enmod rewrite && \
    a2enmod proxy && \
    a2enmod proxy_http && \
    a2enmod proxy_wstunnel && \
    phpenmod mcrypt && \

    # Copy config php.ini
    rm /etc/php/7.2/apache2/php.ini && \
    cp /configs/custom.php.ini /etc/php/7.2/apache2/php.ini && \

    # Install composer and add its bin to the PATH.
    curl -s http://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \

    # Run composer vendors as globaly.
    echo "export PATH=${PATH}:/root/.composer/vendor/bin" >> ~/.bashrc \
;fi

#-------------------------------------------------------------------------------
# xDebug
# Default option `INSTALL_XDEBUG=false`
#-------------------------------------------------------------------------------
ARG INSTALL_XDEBUG=false
ENV INSTALL_XDEBUG ${INSTALL_XDEBUG}
ENV XDEBUGINI_PATH=/etc/php/7.2/mods-available/xdebug.ini
RUN if [ ${INSTALL_XDEBUG} = true ] && [ ${INSTALL_APACHE_PHP} = true ]; then \
    apt-get install -y php-xdebug && \
    echo "xdebug.remote_autostart = 0" >> $XDEBUGINI_PATH && \
    echo "xdebug.remote_enable = 1" >> $XDEBUGINI_PATH && \
    echo "xdebug.remote_connect_back = 0" >> $XDEBUGINI_PATH && \
    echo "xdebug.remote_port=9000" >> $XDEBUGINI_PATH && \
    echo "xdebug.remote_host=172.18.0.1" >> $XDEBUGINI_PATH && \
    echo "xdebug.idekey = PHPSTORM" >> $XDEBUGINI_PATH \
;fi

# Laravel Socket
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g laravel-echo-server

# Set timezone
RUN rm /etc/localtime && \
    ln -s /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime

# Clean up
USER root
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/html/current
EXPOSE 22 80 443

# Start supervisord
CMD ["/usr/bin/supervisord", "--configuration=/etc/supervisord.conf"]
