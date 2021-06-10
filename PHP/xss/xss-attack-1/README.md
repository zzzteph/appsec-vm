# XSS-Attack-1 (Welcome)

Laboratory work to demonstrate the Stored XSS vulnerability.
## Legend:

TODO
## Setup

### Requirements

Disk space: 4 GB


### Building from sources (Debian 10)


1. Install all necessary packages

    ```bash
    sudo apt-get update
    sudo apt-get install -y nginx php-fpm mariadb-server curl unzip xvfb libxi6 libgconf-2-4 default-jdk wget htop mc unzip php-mysql maven
    
    
 
    wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
    sudo apt install -y ./google-chrome-stable_current_amd64.deb
    wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
    unzip chromedriver_linux64.zip
    sudo mv chromedriver /usr/bin/chromedriver
    sudo chown root:root /usr/bin/chromedriver
    sudo chmod +x /usr/bin/chromedriver
    ```
2. Copy files to the server 
    Put contents of **web** folder to /var/www/html.
    ```bash
    /var/www/html/index.php
	...
    ```
    Put content of **bot** folder to /home/**USERNAME**/bot
    ```bash
    /home/admin/bot/
    /home/admin/bot/pom.xml
    /home/admin/bot/src/
    ```
    
    

3. Configure database
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

4. Fill database with data
    ```SQL
    CREATE TABLE IF NOT EXISTS `users` (  `id` INT NOT NULL AUTO_INCREMENT,  `login` VARCHAR(45) NULL,  `password` VARCHAR(45) NULL,  PRIMARY KEY (`id`))ENGINE = InnoDB;
    CREATE TABLE IF NOT EXISTS `posts` (  `id` INT NOT NULL AUTO_INCREMENT, `content` MEDIUMTEXT NULL,  PRIMARY KEY (`id`))ENGINE = InnoDB;
    insert into `users`(`login`,`password`) values ('admin','30bdad3b2f064123f40da204e6172db6');
    
    ```
    Admin password: **someStrongAndUltraSecretpass** - md5:30bdad3b2f064123f40da204e6172db6


6. Configure nginx (php7.3)
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



5. Compile bot
    ```bash
    cd ~
    cd bot
    mvn package
    ```
    You will find target folder where will be **bot-1.0.jar**

6. Create bash script to run bot (eg: run.sh)

    ```bash
    
    java -jar /home/admin/bot/target/bot-1.0.jar -l admin -p someStrongAndUltraSecretpass

    
    ```
7. Create a cronjob that will execute run.sh from **step 6** every minute.

    ```bash
    * * * * * /bin/bash /home/admin/run.sh >/dev/null 2>&1
    ```



### Validation 

1. Login with admin credentials (admin/someStrongAndUltraSecretpass)
2. Navigate admin.php



## Solution

TODO:

Someday I will finish this page. Need to change the name of my blog to <b> Super_MBlog</b>




