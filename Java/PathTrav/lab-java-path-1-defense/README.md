# Инструкция установки через setup.sh

- заходим на VM по sftp под пользователем admin
- загружаем все файлы и папки из ./deploy/* в /home/admin/
- заходим на VM по ssh и выполняем команду
```
sudo chmod +x /home/admin/setup.sh; /home/admin/setup.sh
```
# Инструкция установки 

#min 5 gb

# устанавливаем необходимое ПО
```sh

sudo apt-get update -y 
sudo apt-get install -y default-jdk unzip maven nginx curl wget

wget https://github.com/cdr/code-server/releases/download/2.1698/code-server2.1698-vsc1.41.1-linux-x86_64.tar.gz -O code-server.tar.gz
sudo mkdir /opt/code-server
sudo tar -zxvf code-server.tar.gz -C /opt/code-server --strip 1

# Jetty нужно распаковать в папку /opt/jetty


#sudo su
#adduser dev
sudo useradd -m -p $(perl -e 'print crypt($ARGV[0], "password")' 'dev123') dev
sudo mkdir /home/dev/source
sudo chmod 777 -R /home/dev/source
```

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

sudo nano  /etc/systemd/system/path.service
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
sudo systemctl start path
sudo systemctl enable path
sudo service nginx restart


# добавить всем возможность вызывать деплой скрипты
sudo nano -c /etc/sudoers

```
ALL ALL=NOPASSWD: /sbin/bot_test,/sbin/bot_reload,/sbin/bot_deploy,/sbin/bot_compile
```


# скопировать содержимое папки /root/ в /root

cd  /root
tr -d '\r' < /root/bot_deploy > /root/bot_deploy.sh
tr -d '\r' < bot_compile > bot_compile.sh
tr -d '\r' < bot_test > bot_test.sh
tr -d '\r' < bot_reload > bot_reload.sh
rm -f bot_deploy
rm -f bot_compile
rm -f bot_test
rm -f bot_reload
mv bot_deploy.sh bot_deploy
mv bot_compile.sh bot_compile
mv bot_test.sh bot_test
mv bot_reload.sh bot_reload

chmod +x /root/bot_deploy
chmod +x /root/bot_compile
chmod +x /root/bot_test
chmod +x /root/bot_reload
ln -s /root/bot_compile /sbin/bot_compile
ln -s /root/bot_deploy /sbin/bot_deploy
ln -s /root/bot_test /sbin/bot_test
ln -s /root/bot_reload /sbin/bot_reload



# скопировать содержимое папки /root/source в /home/dev/source 
cd /root/source
mvn clean
mvn compile
mvn package
cp -r /root/source/* /home/dev/source/
chmod 777 -R /home/dev/source

# clear history
mvn clean
mvn compile
mvn package

sudo cp /home/admin/target/ROOT.war.original /opt/jetty/webapps/ROOT.war

# manualy

# Установить расширение actionButtons

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

# нажать 



# clear
history -c
echo "" | sudo tee /var/log/auth.log
rm -rf ~/.bash_history
kill -9 $$

```