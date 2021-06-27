# CSRF-Attack-1 (BadArticles)

Laboratory work to demonstrate the vulnerability of the CSRF.
## Legend:

Your old friend BOB asked you to help with his new article. On the site where he published his new article, you can put likes, however, users do not want to do this, and moreover, they write bad comments. Bob asked you to somehow make his article get at least 10 likes and then he will immediately start writing a new article. Well, can we help Bob get likes for his article?

## Setup

### Requirements

Disk space: 4 GB


### Building from sources (Debian 10)


1. Install all necessary packages

    ```bash
    sudo apt-get update
    sudo apt-get install -y nginx php-fpm mariadb-server curl unzip xvfb libxi6 libgconf-2-4 default-jdk wget htop mc unzip php-mysql maven
    
    
    #Chrome driver for selenium
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
    /var/www/html/application/
    /var/www/html/assets/
    /var/www/html/system/
    /var/www/html/index.php
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
    sudo mysql -e "create database blog";
    sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
    sudo mysql -e "GRANT ALL PRIVILEGES ON blog . * TO 'admin'@'localhost'";
    sudo mysql -e "FLUSH PRIVILEGES";
    ```

4. Fill database with data
    ```SQL
    CREATE TABLE IF NOT EXISTS `users` (  `id` INT NOT NULL AUTO_INCREMENT,  `login` VARCHAR(45) NULL,  `password` VARCHAR(45) NULL,  PRIMARY KEY (`id`))ENGINE = InnoDB;
    CREATE TABLE IF NOT EXISTS `posts` (  `id` INT NOT NULL AUTO_INCREMENT, `header` VARCHAR(45), `content` MEDIUMTEXT NULL,  `user_id` INT NULL,  PRIMARY KEY (`id`))ENGINE = InnoDB;
    CREATE TABLE IF NOT EXISTS `comments` (  `id` INT NOT NULL AUTO_INCREMENT,  `post_id` INT NULL,  `content` MEDIUMTEXT NULL,`user_id` INT NULL,  PRIMARY KEY (`id`))ENGINE = InnoDB;
    CREATE TABLE IF NOT EXISTS `likes` (`post_id` INT NULL,  `user_id` INT NULL,   PRIMARY KEY (`post_id`, `user_id`))ENGINE = InnoDB;
    
    
    insert into `users`(`login`,`password`) values ('bob','5f4dcc3b5aa765d61d8327deb882cf99');
    insert into `users`(`login`,`password`) values ('liam','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('noah','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('oliver','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('elijah','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('william','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('james','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('benjamin','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('lucas','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('henry','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('alexander','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('olivia','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('harper','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('evelyn','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('mia','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('isabella','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('amelia','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('sophia','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('charlotte','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('emma','30bdad3b2f064123f40da204e6172db6');
    insert into `users`(`login`,`password`) values ('ava','30bdad3b2f064123f40da204e6172db6');
    
    
    
    insert into `posts`(`header`,`content`,`user_id`) values ('Martians invade earth','Mea aperiri inciderint et, sea equidem fabulas pericula ne. An alii eruditi incorrupte duo, his te erat debet. Verterem constituto consectetuer at per. Summo accusam ne sit, eu aliquip alienum apeirian duo. Hinc invidunt consulatu pro ad. Duo utamur indoctum sententiae ne, an alii nobis gloriatur vel. Per ei veri appetere, porro accusamus vis cu.',1);
    ```
    Bob password: **password** - md5:5f4dcc3b5aa765d61d8327deb882cf99
    Other users have password: **someStrongAndUltraSecretpass** - md5:30bdad3b2f064123f40da204e6172db6


6. Configure nginx (php7.3)
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



5. Compile bot
    ```bash
    cd ~
    cd bot
    mvn package
    ```
    You will find target folder where will be **bot-1.0.jar**

6. Create bash script to run bot (eg: run.sh)

    ```bash
    
    java -jar /home/admin/bot/target/bot-1.0.jar -l liam -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l noah -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l oliver -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l elijah -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l william -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l james -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l benjamin -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l lucas -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l henry -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l alexander -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l olivia -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l harper -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l evelyn -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l mia -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l isabella -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l amelia -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l sophia -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l charlotte -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l emma -p someStrongAndUltraSecretpass
    java -jar /home/admin/bot/target/bot-1.0.jar -l ava -p someStrongAndUltraSecretpass
    
    ```
7. Create a cronjob that will execute run.sh from **step 6** every 5 minutes.

    ```bash
    */5 * * * * /bin/bash /home/admin/run.sh >/dev/null 2>&1
    ```



### Validation 

1. Login with bob credentials (bob/password)
2. Navigate first post (/posts/1)
3. You may notice that there will appear some comments.


## Solution

Put ```<img src="/like/1">``` in comments and wait for some time. If you get more that 7 likes you'll see bob message 
**what if your child is martian?**




