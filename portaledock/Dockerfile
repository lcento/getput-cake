FROM debian:6.0
MAINTAINER Leopoldo Centore email: lcento@gmail.com

ENV TZ=Europe/Rome
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Update the image with latest packages
RUN apt-get update; apt-get upgrade -y

# Add group ftpusers
RUN groupadd -g 1010 ftpusers

# Add group ftpadmin
RUN groupadd -g 501 ftpadmin

# Add user fromext
RUN useradd -u 1024 -g 1010 -p fromext fromext

# Add user ftpadmin
RUN useradd -u 500 -g 501 -G 1010 -p czc320X ftpadmin

# Install Apache2 Web Server
RUN apt-get -y install apache2
RUN apt-get -y install mysql-client
RUN apt-get -y install php5 libapache2-mod-php5 php5-mysql php5-imap php5-ldap
RUN apt-get -y install libapache2-mod-perl2
RUN apt-get -y install libapache2-mod-python
RUN apt-get -y install vim iputils-ping

# Add the tar file of the web site
ADD ./files/getput-cake.tar /tmp/

# Docker automatically extracted. So move files to web directory
RUN mkdir -p /var/local/share/getput-cake/
RUN cp -p -r /tmp/getput-cake/* /var/local/share/getput-cake/
RUN rm -r /tmp/getput-cake/

# Add getput configuration files
ADD ./files/database.php /var/local/share/getput-cake/app/config/

# Set chmod permit for app TEMP
RUN chmod -R 777 /var/local/share/getput-cake/app/tmp

# Add Apache Configuration files 
RUN mkdir /etc/apache2/ssl/
RUN mkdir /var/run/apache2/

ADD ./files/default-ssl /etc/apache2/sites-available/
ADD ./files/ports.conf /etc/apache2/
ADD ./files/ftp.ilmattino.it.cert /etc/apache2/ssl/
ADD ./files/ftp.ilmattino.it.key /etc/ssl/private/
ADD ./files/intermediate.crt /etc/ssl/private/
ADD ./files/php.ini /etc/php5/apache2/
ADD ./files/xcache.ini /etc/php5/apache2/conf.d/

ADD https://github.com/hiteshjasani/nim-mungehosts/releases/download/v0.1.1/mungehosts /usr/local/bin/mungehosts
RUN chmod 755 /usr/local/bin/mungehosts

RUN a2enmod ssl
RUN a2ensite default-ssl
RUN a2enmod rewrite

RUN mungehosts -a "81.208.11.67 linux"

EXPOSE 443

# By default, simply start apache
CMD [ "/usr/sbin/apache2ctl", "-D", "FOREGROUND" ]
