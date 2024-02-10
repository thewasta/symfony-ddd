FROM nginx:alpine

RUN rm -rf /usr/share/nginx/html/* /etc/nginx/conf.d/*

COPY /docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf