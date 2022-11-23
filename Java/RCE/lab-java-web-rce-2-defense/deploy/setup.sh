# устанавливаем необходимое ПО
sudo apt-get update -y 
sudo apt-get install -y default-jdk unzip maven nginx python python3 curl wget mc htop git python3-pip python2.7 whois markdown


cd /home/admin

# Установка vscode
wget https://github.com/cdr/code-server/releases/download/2.1698/code-server2.1698-vsc1.41.1-linux-x86_64.tar.gz -O code-server.tar.gz
sudo mkdir /opt/code-server
sudo tar -zxvf code-server.tar.gz -C /opt/code-server --strip 1
rm -f code-server.tar.gz

# Jetty нужно распаковать в папку /opt/jetty
wget https://repo1.maven.org/maven2/org/eclipse/jetty/jetty-distribution/9.4.27.v20200227/jetty-distribution-9.4.27.v20200227.zip
unzip jetty-distribution-9.4.27.v20200227.zip
rm -f jetty-distribution-9.4.27.v20200227.zip
sudo mkdir /opt/jetty
sudo cp -R jetty-distribution-9.4.27.v20200227/* /opt/jetty
sudo chmod 777 -R /opt/jetty
sudo rm -rf jetty-distribution-9.4.27.v20200227/

# склонировать WP в /sources
sudo mkdir /sources
cd /sources
sudo git clone https://github.com/WordPress/WordPress
sudo cp -R WordPress/* .
sudo rm -rf WordPress

# add user dev
sudo useradd -m -p $(perl -e 'print crypt($ARGV[0], "password")' '12345') dev
sudo mkdir /home/dev/source
sudo chmod 777 -R /home/dev/source

# configuring jetty, nginx and vscode

echo "
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
" | sudo tee /etc/systemd/system/jetty.service

echo "
server {
  listen       80;

  location / {
    proxy_pass       http://localhost:8080;
    proxy_set_header X-Real-IP \$remote_addr;
    proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
    proxy_set_header Host \$http_host;
  }
}
" | sudo tee /etc/nginx/sites-enabled/default


echo '
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
' | sudo tee /etc/systemd/system/vscode.service

# restarting service
sudo systemctl start vscode
sudo systemctl enable vscode
sudo systemctl start jetty
sudo systemctl enable jetty
sudo service nginx restart

# добавить всем возможность вызывать деплой скрипты
echo "
ALL ALL=NOPASSWD: /sbin/bot_test,/sbin/bot_reload,/sbin/bot_deploy,/sbin/bot_compile
" | sudo tee -a /etc/sudoers


# скопировать содержимое папки /root/ в /root
sudo cp /home/admin/bot_deploy /root/
sudo cp /home/admin/bot_compile /root/
sudo cp /home/admin/bot_test /root/
sudo cp /home/admin/bot_reload /root/

sudo chmod +x /root/bot_deploy
sudo chmod +x /root/bot_compile
sudo chmod +x /root/bot_test
sudo chmod +x /root/bot_reload
sudo ln -s /root/bot_compile /sbin/bot_compile
sudo ln -s /root/bot_deploy /sbin/bot_deploy
sudo ln -s /root/bot_test /sbin/bot_test
sudo ln -s /root/bot_reload /sbin/bot_reload

# скопировать содержимое папки /root/source в /home/dev/source 
cd /home/admin/source
sudo mvn clean
sudo mvn compile
sudo mvn package

# this command not work
sudo cp /home/admin/source/target/ROOT.war /opt/jetty/webapps/ROOT.war

sudo mvn clean

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

# restarting service
sudo systemctl restart vscode
sudo systemctl restart jetty
sudo service nginx restart

# manualy
# 1. go ip:8081 install web plugin VScode Actions Buttons
# 2. test vscode comands
# - reload, compile, deploy, test
# - reload, compile, deploy, reload
# 3. dissable extensions and debug & run

# delete and clean history
rm -rf /home/admin/source/
rm -f /home/admin/bot*
rm -f /home/admin/setup.sh

history -c
echo "" | sudo tee /var/log/auth.log
rm -rf ~/.bash_history
kill -9 $$
