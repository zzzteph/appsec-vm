# Инструкция установки через докер

- заходим на VM по sftp под пользователем admin
- загружаем все файлы и папки из ./deploy/* в /home/admin/
- заходим на VM по ssh и выполняем команду
```
sudo chmod +x /home/admin/setup.sh; /home/admin/setup.sh
```

# Инструкция установки без докера
```
sudo apt-get update
sudo apt-get install nginx php-fpm mc unzip openssl phantomjs libssl-dev

cp html.zip /var/www/html
```

## /etc/nginx/nginx.conf

```
access_log /dev/null;
error_log /dev/null;
```



## /etc/nginx/sites-enabled/default

```
server {
        listen 80 default_server;
        listen [::]:80 default_server;

        root /var/www/html;

        index index.php;

        server_name _;

        location / {
                try_files $uri $uri/ =404;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
        }

}
```

## sudo nano -c /etc/ssl/openssl.cnf

```
# System default
#openssl_conf = default_conf

```
rm -f /home/admin/html.zip
history -c 
