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
    apt-get install -y php7.3-bcmath php7.3-bz2 php7.3-cli php7.3-common php7.3-curl php7.3-dba php7.3-fpm php7.3-gd php7.3-gmp php7.3-imap php7.3-intl php7.3-ldap php7.3-mbstring php7.3-mysql php7.3-odbc php7.3-pgsql php7.3-recode php7.3-snmp php7.3-soap php7.2-sqlite php7.2-tidy php7.2-xml php7.3-xmlrpc php7.3-xsl php7.3-zip && \
    apt-get install -y php-gnupg php-imagick php-mongodb php-streams php-fxsl && \
    mkdir /tmp/composer/ && \
    cd /tmp/composer && \
    apt-get update &&\
    apt-get install -y curl &&\
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
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql17
RUN ACCEPT_EULA=Y apt-get install -y mssql-tools unixodbc-dev
RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc


RUN apt-get install -y php-pear  php7.3-dev
RUN apt-get update

RUN pecl install sqlsrv-5.6.0
RUN pecl install pdo_sqlsrv-5.6.0

RUN printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/7.3/mods-available/sqlsrv.ini
RUN printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/7.3/mods-available/pdo_sqlsrv.ini
RUN phpenmod -v 7.3 sqlsrv pdo_sqlsrv

RUN apt-get update
RUN apt-get install -y composer

EXPOSE 80 443 9515
CMD service php7.3-fpm start && nginx -g "daemon off;"
