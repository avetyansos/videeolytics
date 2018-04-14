FROM mysql:5.7

ARG MYSQL_DATABASE
ARG MYSQL_USER
ARG MYSQL_PASSWORD
ARG MYSQL_ROOT_PASSWORD

ENV MYSQL_DATABASE=${MYSQL_DATABASE}
ENV MYSQL_USER=${MYSQL_USER}
ENV MYSQL_PASSWORD=${MYSQL_PASSWORD}
ENV MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}

# Set Timezone
ARG TZ=UTC
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone

COPY docker-helper/configs/*.cnf /etc/mysql/conf.d/

# To be sure that MySQL will not ignore configs
RUN chmod og-w /etc/mysql/conf.d/*.cnf

EXPOSE 3306

CMD ["mysqld"]