docker run \
    -d \
    -p 8080:80 \
    -v $(pwd)/src/vhost.conf:/etc/nginx/sites-enabled/vhost.conf \
    -v $(pwd)/src:/var/www \
    420px/nginx;
