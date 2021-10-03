# CSRF-Attack-1 (BadArticles)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 4 GB disk

# Agenda

Your old friend BOB asked you to help with his new article. On the site where he published his new article, you can put likes, however, users do not want to do this, and moreover, they write bad comments. Bob asked you to somehow make his article get at least 10 likes and then he will immediately start writing a new article. Well, can we help Bob get likes for his article?

# Setup

*Requirements:*  **4 GB** of disk space for VM.

Put contents of **web** folder to /var/www/html.
- /var/www/html/application/
-    /var/www/html/assets/
-    /var/www/html/system/
-    /var/www/html/index.php

 Put content of **bot** folder to /home/**USERNAME**/bot

-    /home/user/bot/
-    /home/user/bot/pom.xml
-    /home/user/bot/src/



```bash
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install -y nginx php-fpm mariadb-server curl unzip xvfb libxi6 libgconf-2-4 default-jdk wget htop mc unzip php-mysql maven

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
	
	
#### Configure database
```bash
    sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
    sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
    sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
    sudo mysql -e "DROP DATABASE IF EXISTS test;"
    sudo mysql -e "create database blog";
    sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
    sudo mysql -e "GRANT ALL PRIVILEGES ON blog . * TO 'admin'@'localhost'";
    sudo mysql -e "FLUSH PRIVILEGES";
```

#### Fill database with data
```bash
	sudo mysql blog</var/www/html/db.sql
	sudo rm -f /var/www/html/db.sql
```

    
#### Nginx configure

Change **/etc/nginx/sites-enabled/default** (php-fpm version may be different):
```bash
server {
        listen       80;
        root   /var/www/html/;
        autoindex on;
        index index.php;
        location / {
            try_files $uri $uri/ /index.php;
            location = /index.php {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
                fastcgi_param  SCRIPT_FILENAME /var/www/html/$fastcgi_script_name;
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




You can set host by yourself:

```
java -jar /home/user/bot/target/bot-1.0.jar -l liam -p someStrongAndUltraSecretpass -h 192.168.93.150 --screenshot /home/user/admin.jpg 
```

One-liner to automatically get IP address 

```bash
java -jar /home/user/bot/target/bot-1.0.jar -l liam -p someStrongAndUltraSecretpass -h `hostname --all-ip-addresses` --screenshot /home/user/admin.jpg
```



Create bash script to run bot (eg: **run.sh**)

```bash
java -jar /home/user/bot/target/bot-1.0.jar -l liam -p someStrongAndUltraSecretpass --screenshot /home/user/liam.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l noah -p someStrongAndUltraSecretpass --screenshot /home/user/noah.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l oliver -p someStrongAndUltraSecretpass --screenshot /home/user/oliver.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l elijah -p someStrongAndUltraSecretpass --screenshot /home/user/elijah.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l william -p someStrongAndUltraSecretpass --screenshot /home/user/william.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l james -p someStrongAndUltraSecretpass --screenshot /home/user/james.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l benjamin -p someStrongAndUltraSecretpass --screenshot /home/user/benjamin.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l lucas -p someStrongAndUltraSecretpass --screenshot /home/user/lucas.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l henry -p someStrongAndUltraSecretpass --screenshot /home/user/henry.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l alexander -p someStrongAndUltraSecretpass --screenshot /home/user/alexander.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l olivia -p someStrongAndUltraSecretpass --screenshot /home/user/olivia.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l harper -p someStrongAndUltraSecretpass --screenshot /home/user/harper.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l evelyn -p someStrongAndUltraSecretpass --screenshot /home/user/evelyn.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l mia -p someStrongAndUltraSecretpass --screenshot /home/user/mia.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l isabella -p someStrongAndUltraSecretpass --screenshot /home/user/isabella.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l amelia -p someStrongAndUltraSecretpass --screenshot /home/user/amelia.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l sophia -p someStrongAndUltraSecretpass --screenshot /home/user/sophia.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l charlotte -p someStrongAndUltraSecretpass --screenshot /home/user/charlotte.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l emma -p someStrongAndUltraSecretpass --screenshot /home/user/emma.jpg
java -jar /home/user/bot/target/bot-1.0.jar -l ava -p someStrongAndUltraSecretpass --screenshot /home/user/ava.jpg
```
 Create a cronjob that will execute **run.sh** from every 5 minutes.
```
*/5 * * * * /bin/bash /home/user/run.sh >/dev/null 2>&1
 ```

Don't forget to restart cron
```
sudo service cron restart
#or
systemctl restart cron
```




### Validation 

1. Open the main page. You should see the working app. Try to login with ```bob/password```
2. Navigate first post (```/posts/1```)
3. You may notice that there will appear some comments.


## Solution

Laboratory work to demonstrate the vulnerability of the CSRF.

Put ```<img src="/like/1">``` in comments and wait for some time. If you get more that 7 likes you'll see bob message: 
**what if your child is martian?**

Bob password: **password** - md5:5f4dcc3b5aa765d61d8327deb882cf99
Other users have password: **someStrongAndUltraSecretpass** - md5:30bdad3b2f064123f40da204e6172db6