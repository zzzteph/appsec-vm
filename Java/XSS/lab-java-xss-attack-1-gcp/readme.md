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
sudo apt-get install -y default-jdk wget maven nginx curl unzip xvfb libxi6 libgconf-2-4 python python2.7

wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo apt install -y ./google-chrome-stable_current_amd64.deb
wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
unzip chromedriver_linux64.zip

sudo mv chromedriver /usr/bin/chromedriver
sudo chown root:root /usr/bin/chromedriver
sudo chmod +x /usr/bin/chromedriver




# jetty
sudo nano  /etc/systemd/system/xss.service
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
  listen       80;

  location / {
    proxy_pass       http://localhost:8080;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header Host $http_host;
  }
}
```

sudo systemctl start xss
sudo systemctl enable xss
sudo service nginx restart
sudo systemctl restart xss

sudo cp /home/admin/source/target/ROOT.war.original /opt/jetty/webapps/ROOT.war


# собрать бота
cd /home/admin/bot_source_code
mvn package

# В папке /home/admin/bot_source_code/target будет файл bot-1.0.jar
# Секретный адрес - /secret?key=are3you4crazy5yes6i7am

# Теперь нужно создать cron
* * * * * sh /home/admin/run.sh >/dev/null 2>&1


sudo service cron restart
/home/admin/run.sh

echo "
java -jar /home/admin/bot/target/bot-1.0.jar --screenshot test.jpg
" | sudo tee /home/admin/run.sh



#Проверить 
```
java -jar /home/admin/bot_source_code/target/bot-1.0.jar --url http://127.0.0.1/secret?key=are3you4crazy5yes6i7am --screenshot /home/admin/test.jpg
```
Должна появиться картинка /home/admin/test.jpg







