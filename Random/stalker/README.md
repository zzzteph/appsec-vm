
# Stalker 

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 2 GB disk

# Agenda

In your research, you discovered a strange server that, at first glance, only has one page. However, later it turned out that the system administrator uses this server to develop his virtual terminal, which allows him to execute some Linux commands, such as ls, find, wget and others. Well, this is a great chance to try to access the server and look for what else is so interesting there. Maybe we can even find his password?

# Setup

*Requirements:*  **2 GB** of disk space for VM.

Put all files in folder /var/www/html/

```
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install -y php-fpm nginx sqlite3 php-sqlite3 unzip
sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*

```

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

Reload nginx

```
sudo  systemctl restart nginx
```


## How to check that everything works ?

1. Open main page, you should cats.
2. Navigate **/?id=2**, you should see cat.
 
**Default credentials**:
stalker - 123qweasdzxc
 
default flag -  M0N0Lith_in_An0ther_Castl3

## Solution

1. There is an SQL injection in ```?id={SQL_INJECTION}```
2. With SQLMap extract table **User**. There you can find user with name **stalker**
3. With dirsearch/dirb/dirbuster find **/admin** folder.
4. Continue searching directories inside **/admin** dir.
5. Find file **/admin/admin/.index.php.swp**. Inside this file you can find the hash algo for password ```md5($_POST['login'].$_POST['password'].$_POST['login']."_salt");```
6. You can either bruteforce hash, or do online bruteforce.
7. After login to admin panel, you can find that part of the interface is hidden (textarea) by JS code. 
8. You can get code execution on server through box on step 7 - ``` eval($_POST['code']);```






