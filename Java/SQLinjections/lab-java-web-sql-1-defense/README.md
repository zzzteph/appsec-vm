#min 4 gb

# устанавливаем необходимое ПО
sudo apt-get update
sudo apt-get install wget curl unzip default-jdk unzip maven nginx mariadb-server sqlmap

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
sudo nano  /etc/systemd/system/sql.service
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

sudo systemctl start vscode
sudo systemctl enable vscode
sudo systemctl start sql
sudo systemctl enable sql
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




# Настройки БД

sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database admin";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON admin . * TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";
sudo mysql -e "create table admin.users(\`login\` varchar(48) PRIMARY KEY,\`passwd\` varchar(64));";
sudo mysql -e "insert into admin.users(\`login\`,\`passwd\`) values ('admin','someverysecreyfauoiuasd');";



#добавить всем возможность вызывать деплой скрипты
sudo nano -c /etc/sudoers

```
ALL ALL=NOPASSWD: /sbin/bot_test,/sbin/bot_reload,/sbin/bot_deploy
```

#скопировать содержимое папки /root/ в /root

cd  /root
tr -d '\r' < bot_deploy > bot_deploy.sh
tr -d '\r' < bot_test > bot_test.sh
tr -d '\r' < bot_reload > bot_reload.sh
rm -f bot_deploy
rm -f bot_test
rm -f bot_reload
mv bot_deploy.sh bot_deploy
mv bot_test.sh bot_test
mv bot_reload.sh bot_reload

chmod +x /root/bot_deploy
chmod +x /root/bot_test
chmod +x /root/bot_reload
ln -s /root/bot_deploy /sbin/bot_deploy
ln -s /root/bot_test /sbin/bot_test
ln -s /root/bot_reload /sbin/bot_reload

#скопировать содержимое папки /root/source в /home/dev/source 


cd /root/
mvn clean
mvn compile
mvn package
mvn clean

