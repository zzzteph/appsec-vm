#min 5 gb

# устанавливаем необходимое ПО
sudo apt-get update
sudo apt-get install wget curl unzip default-jdk wget htop mc unzip maven git whois nginx markdown python python2.7

wget https://github.com/cdr/code-server/releases/download/2.1698/code-server2.1698-vsc1.41.1-linux-x86_64.tar.gz -O code-server.tar.gz
sudo mkdir /opt/code-server
sudo tar -zxvf code-server.tar.gz -C /opt/code-server --strip 1


# Jetty нужно распаковать в папку /opt/jetty
wget https://repo1.maven.org/maven2/org/eclipse/jetty/jetty-distribution/9.4.27.v20200227/jetty-distribution-9.4.27.v20200227.zip
unzip jetty-distribution-9.4.27.v20200227.zip
rm -f jetty-distribution-9.4.27.v20200227.zip
sudo mkdir /opt/jetty
sudo cp -R jetty-distribution-9.4.27.v20200227/* /opt/jetty
sudo chmod 777 -R /opt/jetty
rm -rf jetty-distribution-9.4.27.v20200227/
sudo mkdir /sources
sudo chmod 777 -R /sources

# склонировать WP в /sources

cd /sources
sudo git clone https://github.com/WordPress/WordPress
sudo cp -R WordPress/* .
sudo rm -rf WordPress


# Нужно добавить пользователя dev и проверить, что у него есть папка /home/dev/
sudo adduser dev


sudo mkdir /home/dev/source
chmod 777 -R /home/dev/source

# code-server сервис
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
sudo nano  /etc/systemd/system/jetty.service
```
[Unit]
Description=VSCode as Service
After=network.target

[Service]

WorkingDirectory=/opt/jetty
User=dev
Group=dev
ExecStart=/usr/bin/java -jar /opt/jetty/start.jar

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
sudo systemctl start jetty
sudo systemctl enable jetty
sudo service nginx restart


#Установить расширение actionButtons

```
{
    "actionButtons": {
        "reloadButton": null,
        "loadNpmCommands": false,
        "commands": [
		
		  {
                "name": "♻️ Compile",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_compile",
            },
		
            {
                "name": "▶ Deploy",
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

# скопировать содержимое папки /root/ в /root

sudo chmod +x /root/bot_deploy
sudo chmod +x /root/bot_compile
sudo chmod +x /root/bot_test
sudo chmod +x /root/bot_reload
sudo ln -s /root/bot_compile /sbin/bot_compile
sudo ln -s /root/bot_deploy /sbin/bot_deploy
sudo ln -s /root/bot_test /sbin/bot_test
sudo ln -s /root/bot_reload /sbin/bot_reload

# скопировать содержимое папки /root/source в /home/dev/source 


cd /root/source
mvn clean
mvn compile
mvn package
cp -r /root/source/* /home/dev/source/
chmod 777 -R /home/dev/source



