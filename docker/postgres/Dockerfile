FROM postgres:latest

ENV POSTGRES_DB HackTheRoot
ENV POSTGRES_USER postgres
ENV POSTGRES_PASSWORD postgres

COPY docker/postgres/init.sql /docker-entrypoint-initdb.d/