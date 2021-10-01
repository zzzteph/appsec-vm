# Lorense 

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 2 GB disk

# Agenda

You need to test the new cloud-based "pastebin"-like service. Oh, sorry - new cloud-based end-to-end encryption note service. Should you trust your secrets to this service? Let's figure out and find an administration secret note!

tags: **authorization**, **idor**, **encryption**

# Setup

*Requirements:*  **2 GB** of disk space for VM.

Put all files in folder /var/www/html/
```
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install -y nginx php-fpm mariadb-server curl php-mysql unzip
```

Put all data to  **/var/www/html/**
```
sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*
sudo chmod 777 /var/www/html/uploads

#mysql setup
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database web";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON web . * TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";

#import Database and remove it
sudo mysql web < /var/www/html/web.sql
sudo rm -f /var/www/html/web.sql
```

Change **/etc/nginx/sites-enabled/default** (php-fpm version may be different):
```
server {
        listen       80;
        root   /var/www/html/;
        autoindex on;
        index index.php;
        location ~* ^/uploads/.*.php$ {
                return 403;
        }
        location ^~ /application/controllers/
        {
                deny all;
        }
       location / {
            try_files $uri $uri/ /index.php;
            location = /index.php {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
                fastcgi_param  SCRIPT_FILENAME /var/www/html/$fastcgi_script_name;
                include        fastcgi_params;
            }
        }
}
```


Reload nginx

```
sudo  systemctl restart nginx
 ```


## How to check that everything works ?

1. Open main page, you should that it opens without any errors.
2. Register and try to create note. If note was created, that means that everything works. Optionaly: login as admin.
3. Check that **/application/libraries/Supersecurity.php** can be downloaded.

**Default credentials**:
admin - WPEHfn121a





## Solution

1. With dirbuster/dirb/dirsearch find **application** folder. 
2. There you can find **/application/libraries/Supersecurity.php**. This library encrypt/decrypt node id.
3. There is authorization vulnerability, so you can view other users notes, but to do this, you need to write decryptor. (step 2). You can take decrypt function and put all required params in it.
4. Navigate note with ID=1 to view admin note.
    ```
        ----------------------
        Windows creds
        Ujin/Ey9QsjnH
        
        Bank creds
        ujin.v/ZvdAx2PS
        ----------------------
    ```
