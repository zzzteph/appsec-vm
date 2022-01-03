# Инструкция установки через setup.sh

- заходим на VM по sftp под пользователем admin
- загружаем все файлы и папки из ./deploy/* в /home/admin/
- заходим на VM по ssh и выполняем команду
```
sudo chmod +x /home/admin/setup.sh; /home/admin/setup.sh
```

#min 5 gb

# устанавливаем необходимое ПО
sudo apt-get update
sudo apt-get install wget curl unzip default-jdk unzip maven whois nginx python python2.7 dnsutils

wget https://github.com/cdr/code-server/releases/download/2.1698/code-server2.1698-vsc1.41.1-linux-x86_64.tar.gz -O code-server.tar.gz
sudo mkdir /opt/code-server
sudo tar -zxvf code-server.tar.gz -C /opt/code-server --strip 1




# Нужно добавить пользователя dev и проверить, что у него есть папка /home/dev/
sudo adduser dev



#code-server сервис
sudo nano  /etc/systemd/system/vscode.service
```
[Unit]
Description=VSCode as Service
After=network.target

[Service]

#WorkingDirectory=/opt/code-server
WorkingDirectory=/home/dev/source/
Environment="PASSWORD=12345"
User=dev
Group=dev
ExecStart=/opt/code-server/code-server --host=0.0.0.0 --port=8081 --allow-http --auth=none /home/dev/source/

[Install]
WantedBy=multi-user.target


```

# jetty
sudo nano  /etc/systemd/system/rce.service
```
[Unit]
Description=service
After=network.target

[Service]
User=dev
Group=dev

WorkingDirectory=/home/dev
ExecStart=/usr/bin/java -jar /home/dev/source/target/rce-0.0.1-SNAPSHOT.war

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

sudo systemctl start vscode
sudo systemctl enable vscode
sudo systemctl start rce
sudo systemctl enable rce
sudo systemctl restart nginx


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


# добавить всем возможность вызывать деплой скрипты
sudo nano -c /etc/sudoers

```
ALL ALL=NOPASSWD: /sbin/bot_test,/sbin/bot_reload,/sbin/bot_deploy,/sbin/bot_compile
```

#скопировать содержимое папки /root/ в /root

sudo tr -d '\r' < /root/bot_deploy > /root/bot_deploy.sh
sudo tr -d '\r' < /root/bot_test > /root/bot_test.sh
sudo tr -d '\r' < /root/bot_reload > /root/bot_reload.sh
sudo tr -d '\r' < /root/bot_compile > /root/bot_compile.sh

sudo rm -f /sbin/bot_deploy
sudo rm -f /sbin/bot_test
sudo rm -f /sbin/bot_reload
sudo rm -f /sbin/bot_compile


sudo mv /root/bot_deploy.sh /root/bot_deploy
sudo mv /root/bot_test.sh /root/bot_test
sudo mv /root/bot_reload.sh /root/bot_reload
sudo mv /root/bot_compile.sh /root/bot_compile
####

sudo chmod +x /root/bot_deploy
sudo chmod +x /root/bot_test
sudo chmod +x /root/bot_reload
sudo chmod +x /root/bot_compile

sudo ln -s /root/bot_deploy /sbin/bot_deploy
sudo ln -s /root/bot_test /sbin/bot_test
sudo ln -s /root/bot_reload /sbin/bot_reload
sudo ln -s /root/bot_compile /sbin/bot_compile

#скопировать содержимое папки /root/source в /home/dev/source 
cd /root/source
mvn clean
mvn compile
mvn build
cp -r /root/source/* /home/dev/source/
chmod 777 -R /home/dev/source





