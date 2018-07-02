# Pull debian 8 oficial base image
FROM debian:jessie

# Install basic packages
RUN apt-get -y update && apt-get -y install apt-utils curl git ant vim nano --force-yes

# Install web server
RUN apt-get -y install apache2 php5 libapache2-mod-php5 php5-xdebug php5-cli php5-xsl php5-pgsql php5-json php5-curl php5-sqlite php5-mysqlnd php5-intl php5-mcrypt php-pear php5-xmlrpc --force-yes

# Clean apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Define apache virtualhosts
COPY etc/apache2/sites-available/*  /etc/apache2/sites-available/

# Setup root directory
RUN chown -R :www-data /var/www

# PHP configurations (errors, timezone, xdebug)
COPY etc/php5/apache/conf.d/* /etc/php5/apache/conf.d/
COPY etc/php5/cli/conf.d/* /etc/php5/cli/conf.d/

# Timezone
COPY etc/timezone /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata

RUN mkdir /var/www/logapi
RUN chown -R :www-data /var/www/logapi

# Set Apache environment variables (can be changed on docker run with -e)
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_SERVERADMIN admin@localhost
ENV APACHE_SERVERNAME localhost
ENV APACHE_SERVERALIAS docker.localhost
ENV APACHE_DOCUMENTROOT /var/www

# Mod rewrite
RUN a2enmod rewrite


# Install Composer
RUN cd $HOME &&\
    curl -sS https://getcomposer.org/installer | php &&\
    chmod +x composer.phar &&\
    mv composer.phar /usr/local/bin/composer

RUN a2ensite api.pril.local

RUN echo "date.timezone=America/Argentina/Buenos_Aires" >> /etc/php5/apache2/conf.d/01-timezone.ini

# Expose http and https ports
EXPOSE 80 443

# Init service
CMD ["/usr/sbin/apache2", "-D", "FOREGROUND"]
