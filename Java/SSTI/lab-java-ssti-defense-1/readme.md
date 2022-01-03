sudo apt-get update -y
sudo apt-get install -y default-jdk unzip maven nginx curl unzip wget python2 python-pip
wget https://github.com/cdr/code-server/releases/download/2.1698/code-server2.1698-vsc1.41.1-linux-x86_64.tar.gz -O code-server.tar.gz
sudo mkdir /opt/code-server
sudo tar -zxvf code-server.tar.gz -C /opt/code-server --strip 1



# Пользователь
 
sudo adduser dev
sudo mkdir /home/dev/source
sudo chmod 777 -R /home/dev/source

# configuring jetty, nginx and vscode

#code-server сервис

sudo nano  /etc/systemd/system/vscode.service
```
[Unit]
Description=VSCode as Service
After=network.target

[Service]


WorkingDirectory=/home/dev/source/
Environment="PASSWORD=12345"
User=dev
Group=dev
ExecStart=/opt/code-server/code-server --host=0.0.0.0 --port=8081 --allow-http --auth=none /home/dev/source/

[Install]
WantedBy=multi-user.target
```

sudo nano  /etc/systemd/system/ssti.service
```
[Unit]
Description=service
After=network.target

[Service]
User=dev
Group=dev
WorkingDirectory=/home/dev/source/
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

# restarting service
sudo systemctl start vscode
sudo systemctl enable vscode
sudo systemctl start ssti
sudo systemctl enable ssti
sudo service nginx restart



# добавить всем возможность вызывать деплой скрипты
sudo nano -c /etc/sudoers

```
ALL ALL=NOPASSWD: /sbin/bot_test,/sbin/bot_reload,/sbin/bot_deploy
```

# скопировать содержимое папки /root 
sudo su
cd  /root
########
unzip *
########
tr -d '\r' < bot_deploy > bot_deploy.sh
tr -d '\r' < bot_test > bot_test.sh
tr -d '\r' < bot_reload > bot_reload.sh
rm -f bot_deploy
rm -f bot_test
rm -f bot_reload
mv bot_deploy.sh bot_deploy
mv bot_test.sh bot_test
mv bot_reload.sh bot_reload

sudo chmod +x /root/bot_deploy
sudo chmod +x /root/bot_test
sudo chmod +x /root/bot_reload
sudo ln -s /root/bot_deploy /sbin/bot_deploy
sudo ln -s /root/bot_test /sbin/bot_test
sudo ln -s /root/bot_reload /sbin/bot_reload
cd /root/source
mvn clean
mvn compile
mvn package
mvn clean
cp -r /root/source/* /home/dev/source/
chmod 777 -R /home/dev/source


# нужно еще собрать бота, для этого в папке /root есть папка bot
# внутри неё 
mvn clean
mvn compile
mvn package
cp /root/bot/target/bot-1.0.jar /root





#Установить расширение actionButtons

```
{
    "actionButtons": {
        "reloadButton": null,
        "loadNpmCommands": false,
        "commands": [
		
            {
                "name": "▶ Compile & Deploy",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_deploy",
            },
            {
                "name": "✅ Test your code",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_test",
            },
            {
                "name": "↻ Reload source code",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_reload",
            },


        ]
    },
    "workbench.startupEditor": "newUntitledFile"
    
}
```
























