FROM ubuntu:16.04

ENV DEBIAN_FRONTEND noninteractive
ENV ACCEPT_EULA Y

RUN sed -i 's/http:\/\/archive/http:\/\/th.archive/g' /etc/apt/sources.list

RUN apt-get update

RUN apt-get install -y apt-transport-https


RUN \
    apt-get update && \
    apt-get install -y software-properties-common python-software-properties && \
    apt-get install -y ca-certificates &&\
    LC_ALL=C.UTF-8 add-apt-repository -y -u ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y imagemagick graphicsmagick && \
    apt-get install -y php7.2-bcmath php7.2-bz2 php7.2-cli php7.2-common php7.2-curl php7.2-dba php7.2-fpm php7.2-gd php7.2-gmp php7.2-imap php7.2-intl php7.2-ldap php7.2-mbstring php7.2-mysql php7.2-odbc php7.2-pgsql php7.2-recode php7.2-snmp php7.2-soap php7.2-sqlite php7.2-tidy php7.2-xml php7.2-xmlrpc php7.2-xsl php7.2-zip && \
    apt-get install -y php-gnupg php-imagick php-mongodb php-streams php-fxsl && \
    mkdir /tmp/composer/ && \
    cd /tmp/composer && \
    apt-get update &&\
    apt-get install curl &&\
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod a+x /usr/local/bin/composer && \
    cd / && \
    rm -rf /tmp/composer && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/*
RUN \
    apt-get update && \
    apt-get install -y nginx
    


COPY config/nginx.conf /etc/nginx/sites-enabled/default

RUN apt-get update
RUN apt-get install -y vim

RUN apt-get update

RUN apt-get install -y locales && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/ubuntu/16.04/prod.list | tee /etc/apt/sources.list.d/msprod.list
RUN apt-get update
RUN apt-get install -y mssql-tools
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql unixodbc-dev gcc g++ build-essential

RUN apt-get install -y php-pear
RUN apt-get update
RUN apt-get install -y php7.2-dev
RUN apt-get update

RUN pecl install sqlsrv-4.3.0
RUN pecl install pdo_sqlsrv-4.3.0

RUN echo "extension=/usr/lib/php/20170718/sqlsrv.so" >> /etc/php/7.2/cli/php.ini
RUN echo "extension=/usr/lib/php/20170718/pdo_sqlsrv.so" >> /etc/php/7.2/cli/php.ini
RUN echo "extension=/usr/lib/php/20170718/sqlsrv.so" >> /etc/php/7.2/fpm/php.ini
RUN echo "extension=/usr/lib/php/20170718/pdo_sqlsrv.so" >> /etc/php/7.2/fpm/php.ini

RUN apt-get update
RUN apt-get install -y composer

EXPOSE 80 443
CMD service php7.2-fpm start && nginx -g "daemon off;"