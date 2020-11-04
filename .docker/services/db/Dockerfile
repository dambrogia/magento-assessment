FROM ubuntu:18.04

RUN apt-get upgrade -y; apt-get update -y;

# Install MySQL Server. Create user, password, database.
RUN apt-get install -y mariadb-server mariadb-client; \
    sed -i "s^bind-address		= 127.0.0.1^bind-address = 0.0.0.0^g" /etc/mysql/mariadb.conf.d/50-server.cnf; \
    service mysql start; \
    mysql -e "DROP USER IF EXISTS 'docker'@'%';"; \
    mysql -e "FLUSH PRIVILEGES;"; \
    mysql -e "CREATE USER 'docker'@'%' IDENTIFIED BY 'docker';"; \
    mysql -e "DROP DATABASE IF EXISTS mage;"; \
    mysql -e "CREATE DATABASE mage;"; \
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'docker'@'%';"; \
    mysql -e "FLUSH PRIVILEGES;";

# Copy over a mysql tarball dump
COPY ./import.sql.tgz /tmp/import.sql.tgz

# Remove any existing .sql files (should never be any)
# Unload the tarball, rename it so we can import it.
RUN cd /tmp && \
    tar -zxf import.sql.tgz && \
    mv ./*.sql import.sql

CMD service mysql start; tail -f /var/log/mysql/*
