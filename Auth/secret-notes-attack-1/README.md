# Secret notes (1)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 2 GB disk

# Agenda

You were contacted by a representative of a well-known startup and offered to test their completely new product that allows you to create and publish various notes. What's more, it allows you to create your own secret notes. The creators of this service declare that everything is safe. Let's check if this is so?


# Setup

*Requirements:*  **2 GB** of disk space for VM.

Put all files in **source** to folder **/var/www/html/**


```bash
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install nginx mariadb-server php-fpm php-mysql sudo unzip

sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*
```

#### Manual database set up

```bash
sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database secrets";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON secrets.* TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";

sudo mysql secrets < /var/www/html/db.sql
sudo rm -f /var/www/html/db.sql

```



#### Nginx configure

Change **/etc/nginx/sites-enabled/default** (php-fpm version may be different):

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

Reload nginx config
```
sudo service nginx restart
#sudo systemctl restart nginx
```


## How to check that everything works ?

1. Open the main page. You should see the working app. 





## Solution




There is lack of authorization in posts edit. 
1. Register new user
2. Create new secret paste
3. Edit it and change it's ID to 15

There you will see other user paste!

Find post with id = 15 - saLuxUBroMBU