# Secret notes (Mango)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 3 GB disk

# Agenda

You were contacted by a representative of a well-known startup and offered to test their completely new product that allows you to create and publish various notes. What's more, it allows you to create your own secret notes. The creators of this service declare that everything is safe. Let's check if this is so?


# Setup

*Requirements:*  **3 GB** of disk space for VM.

Put all files in **source** to folder **/var/www/html/**


```bash
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install nginx  php-fpm php-dev php-pear gnupg composer sudo unzip
sudo pecl install mongodb
wget -qO - https://www.mongodb.org/static/pgp/server-4.4.asc | sudo apt-key add -
echo "deb http://repo.mongodb.org/apt/debian buster/mongodb-org/4.4 main" | sudo tee /etc/apt/sources.list.d/mongodb-org-4.4.list
sudo apt-get update
sudo apt-get install -y mongodb-org
sudo systemctl start mongod
sudo systemctl enable mongod

####under root user
####sudo su or su -l
echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
####
#composer require mongodb/mongodb
#chmod 777 -R /var/www/html



sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*
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


#### Configure mongodb.so

Put ```extension=mongodb.so``` to **php.ini** in **php-fpm** folder in the extension section.
For example: 
```
cat /etc/php/7.3/fpm/php.ini

....
;   extension folders as well as the separate PECL DLL download (PHP 5+).
;   Be sure to appropriately set the extension_dir directive.
;

extension=mongodb.so
;extension=bz2
;extension=curl
;extension=ffi
;extension=ftp
;extension=file
...

```

Remember to restart **php-fpm**

```
sudo service php7.3-fpm restart
```


## How to check that everything works ?

1. Open the main page. You should see the working app. 
2. In **/var/www/html** init file should appear.
3. Check that public pastes has sequence in ID, like
- view.php?id=615abafbeb2d980c331e9c62
- view.php?id=615abafbeb2d980c331e9c63
- view.php?id=615abafbeb2d980c331e9c64


## Solution

https://techkranti.com/idor-through-mongodb-object-ids-prediction/


There is lack of authorization in posts edit. 
1. Register new user
2. Create new secret paste
3. Use mongo predict to find admin post

Password - 4j9X3hxG3w9feSk9