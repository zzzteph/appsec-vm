# Инструкция установки через setup.sh

- заходим на VM по sftp под пользователем admin
- загружаем все файлы и папки из ./deploy/* в /home/admin/
- заходим на VM по ssh и выполняем команду
```
sudo chmod +x /home/admin/setup.sh; /home/admin/setup.sh
```
# Инструкция установки 

# устанавливаем необходимое ПО
sudo apt-get update -y
sudo apt-get install -y default-jdk wget unzip maven nginx mariadb-server curl unzip xvfb libxi6 libgconf-2-4 git nginx python python2.7 php-fpm php-mysql

wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo apt install -y ./google-chrome-stable_current_amd64.deb
wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
unzip chromedriver_linux64.zip

sudo mv chromedriver /usr/bin/chromedriver
sudo chown root:root /usr/bin/chromedriver
sudo chmod +x /usr/bin/chromedriver



# jetty
sudo nano  /etc/systemd/system/csrf.service
```
[Unit]
Description=service
After=network.target

[Service]

WorkingDirectory=/home/admin/source
ExecStart=/usr/bin/mvn spring-boot:run

[Install]
WantedBy=multi-user.target
```


# nginx proxy чтобы перекидывать с развернуторго jetty на 80 порт
sudo nano -c /etc/nginx/sites-enabled/default
```
server {
        listen 9090 default_server;
        listen [::]:9090 default_server;
        root /var/www/html;
        index index.php;
        server_name _;
        location / {
                try_files $uri $uri/ =404;
        }
        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        }
}


server {
  listen       80;

  location / {
    proxy_pass       http://localhost:8080;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header Host $http_host;
  }
}

```

sudo systemctl start csrf
sudo systemctl enable csrf
sudo service nginx restart
sudo systemctl restart csrf
# Database

sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database base_blogger";
sudo mysql -e "CREATE USER 'user_blogger'@'localhost' IDENTIFIED BY 'pass_blogger'";
sudo mysql -e "GRANT ALL PRIVILEGES ON base_blogger . * TO 'user_blogger'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";
sudo mysql -e "create database guestbook";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON guestbook . * TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";
sudo mysql -e "CREATE TABLE IF NOT EXISTS guestbook.posts (  \`id\` INT NOT NULL AUTO_INCREMENT, \`content\` MEDIUMTEXT NULL,  PRIMARY KEY (\`id\`))ENGINE = InnoDB;";


# собрать бота
cd /home/admin/bot_source_code
mvn package

# В папке /home/admin/bot_source_code/target будет файл bot-1.0.jar
# Пароли пользователей 1qazxsw23edcvfr45tgbnhy6

# Теперь нужно создать cron
# * * * * * sh /home/admin/run.sh >/dev/null 2>&1
echo "
* * * * * sh /home/admin/run.sh >/dev/null 2>&1
" | sudo tee /var/spool/cron/crontabs/admin
sudo service cron restart


echo "
java -jar /home/admin/bot_source_code/target/bot-1.0.jar --auth http://10.0.2.10/login --login admin --password 1qazxsw23edcvfr45tgbnhy6 --url http://10.0.2.10/post/1 --screenshot /home/admin/admin.jpg
sleep 10
java -jar /home/admin/bot_source_code/target/bot-1.0.jar --auth http://10.0.2.10/login --login bob --password 1qazxsw23edcvfr45tgbnhy6 --url http://10.0.2.10/post/1 --screenshot /home/admin/bob.jpg
sleep 10
java -jar /home/admin/bot_source_code/target/bot-1.0.jar --auth http://10.0.2.10/login --login mary --password 1qazxsw23edcvfr45tgbnhy6 --url http://10.0.2.10/post/1 --screenshot /home/admin/mary.jpg
sleep 10
java -jar /home/admin/bot_source_code/target/bot-1.0.jar --auth http://10.0.2.10/login --login andy --password 1qazxsw23edcvfr45tgbnhy6 --url http://10.0.2.10/post/1 --screenshot /home/admin/andy.jpg
" | sudo tee /home/admin/run.sh




Create bash script to run bot (eg: **run.sh**)

```bash
java -jar /home/admin/bot/target/bot-1.0.jar -l admin -p 1qazxsw23edcvfr45tgbnhy6 --screenshot /home/admin/admin.jpg
java -jar /home/admin/bot/target/bot-1.0.jar -l bob -p 1qazxsw23edcvfr45tgbnhy6 --screenshot /home/admin/bob.jpg
java -jar /home/admin/bot/target/bot-1.0.jar -l mary -p 1qazxsw23edcvfr45tgbnhy6 --screenshot /home/admin/mary.jpg
java -jar /home/admin/bot/target/bot-1.0.jar -l andy -p 1qazxsw23edcvfr45tgbnhy6 --screenshot /home/admin/andy.jpg

```
 Create a cronjob that will execute **run.sh** from every 5 minutes.
```
*/5 * * * * /bin/bash /home/admin/run.sh >/dev/null 2>&1
 ```


# можно поменять IP адресс с 10.0.2.10 на внешний и тогда при запуске крона, картинки будут созданы.







<form name="formname" action="http://104.155.43.226/like/1" method="POST">
<input type="hidden" name="value" value="1">
</form>
<script>
document.formname.submit();
</script>

