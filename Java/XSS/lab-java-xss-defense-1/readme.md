
# устанавливаем необходимое ПО
sudo apt-get update -y
sudo apt-get install -y default-jdk wget unzip maven nginx curl xvfb libxi6 libgconf-2-4 python python3  python3-pycurl python3-bs4 python3-geoip python3-gi python3-cairocffi python3-selenium python3-pip python-pip git




# Установка vscode
wget https://github.com/cdr/code-server/releases/download/2.1698/code-server2.1698-vsc1.41.1-linux-x86_64.tar.gz -O code-server.tar.gz
sudo mkdir /opt/code-server
sudo tar -zxvf code-server.tar.gz -C /opt/code-server --strip 1
rm -f code-server.tar.gz


# Пользователь
sudo su
adduser dev
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

sudo nano  /etc/systemd/system/xss.service
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
sudo systemctl start xss
sudo systemctl enable xss
sudo service nginx restart



cd /home/admin/source
mvn package

sudo cp /home/admin/source/target/ROOT.war.original /opt/jetty/webapps/ROOT.war
sudo mv /home/admin/source /root/
sudo mv /home/admin/xsser /root/

sudo tr -d '\r' < /home/admin/bot_deploy > /home/admin/bot_deploy.sh
sudo tr -d '\r' < /home/admin/bot_compile > /home/admin/bot_compile.sh
sudo tr -d '\r' < /home/admin/bot_test > /home/admin/bot_test.sh
sudo tr -d '\r' < /home/admin/bot_reload > /home/admin/bot_reload.sh

sudo rm -f /home/admin/bot_deploy
sudo rm -f /home/admin/bot_compile
sudo rm -f /home/admin/bot_test
sudo rm -f /home/admin/bot_reload
sudo mv /home/admin/bot_deploy.sh /root/bot_deploy
sudo mv /home/admin/bot_compile.sh /root/bot_compile
sudo mv /home/admin/bot_test.sh /root/bot_test
sudo mv /home/admin/bot_reload.sh /root/bot_reload



sudo chmod +x /root/bot_deploy
sudo chmod +x /root/bot_compile
sudo chmod +x /root/bot_test
sudo chmod +x /root/bot_reload
sudo ln -s /root/bot_compile /sbin/bot_compile
sudo ln -s /root/bot_deploy /sbin/bot_deploy
sudo ln -s /root/bot_test /sbin/bot_test
sudo ln -s /root/bot_reload /sbin/bot_reload



# добавить всем возможность вызывать деплой скрипты
echo "
ALL ALL=NOPASSWD: /sbin/bot_test,/sbin/bot_reload,/sbin/bot_deploy,/sbin/bot_compile
" | sudo tee -a /etc/sudoers

sudo cp -r /root/source/* /home/dev/source/
sudo chmod 777 -R /home/dev/source

sudo mkdir /home/dev/.local/share/code-server/User/
sudo touch /home/dev/.local/share/code-server/User/settings.json


sudo mkdir /root/source
sudo cp -r /home/admin/source/* /root/source/
sudo cp -r /home/admin/source/* /home/dev/source/
sudo chmod 777 -R /home/dev/source

sudo mkdir /home/dev/.local/share/code-server/User/
sudo touch /home/dev/.local/share/code-server/User/settings.json
echo '
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
' | sudo tee /home/dev/.local/share/code-server/User/settings.json

sudo chown dev:dev -R /home/dev/

# manualy
# 1. install web plugin VScode Actions Buttons
# 2. dissable extensions and debug & run
# 3. test vscode comands
# - reload, compile, deploy, test
# - reload, compile, deploy, reload

# delete and clean history
rm -rf /home/admin/*

history -c
echo "" | sudo tee /var/log/auth.log
rm -rf ~/.bash_history
kill -9 $$







