#!/bin/bash
# generate-certificate.sh

# чистим папку, где могут находиться старые сертификаты
#rm -rf /etc/letsencrypt/live/certfolder

# выдаем себе сертификат (обратите внимание на переменные среды)
#certbot certonly --standalone --email $DOMAIN_EMAIL -d $DOMAIN_URL --cert-name=certfolder --key-type rsa --agree-tos

# удаляем старые сертификаты из примонтированной
# через Docker Compose папки Nginx
rm -rf ./docker/nginx/cert.pem
rm -rf ./docker/etc/nginx/key.pem

# копируем сертификаты из образа certbot в папку Nginx
cp /etc/letsencrypt/live/certfolder-0002/fullchain.pem ./docker/nginx/cert.pem
cp /etc/letsencrypt/live/certfolder-0002/privkey.pem ./docker/etc/nginx/key.pem