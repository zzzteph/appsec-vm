# устанавливаем необходимое ПО
sudo apt-get update -y 
sudo apt-get install -y default-jdk wget unzip maven nginx curl unzip xvfb libxi6 libgconf-2-4 git nginx python python2.7
cd /home/admin


# install chromedriver
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo apt install -y ./google-chrome-stable_current_amd64.deb

wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
unzip chromedriver_linux64.zip
sudo mv chromedriver /usr/bin/chromedriver
sudo chown root:root /usr/bin/chromedriver
sudo chmod +x /usr/bin/chromedriver


# Jetty нужно распаковать в папку /opt/jetty
wget https://repo1.maven.org/maven2/org/eclipse/jetty/jetty-distribution/9.4.27.v20200227/jetty-distribution-9.4.27.v20200227.zip
unzip jetty-distribution-9.4.27.v20200227.zip
rm -f jetty-distribution-9.4.27.v20200227.zip
sudo mkdir /opt/jetty
sudo cp -R jetty-distribution-9.4.27.v20200227/* /opt/jetty
sudo chmod 777 -R /opt/jetty
sudo rm -rf jetty-distribution-9.4.27.v20200227/


# configuring jetty, nginx
echo "
[Unit]
Description=VSCode as Service
After=network.target

[Service]

WorkingDirectory=/opt/jetty
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

# restarting service
sudo systemctl start jetty
sudo systemctl enable jetty
sudo service nginx restart

# maven
cd /home/admin/source
sudo mvn clean
sudo mvn compile
sudo mvn package

sudo cp /home/admin/source/target/ROOT.war /opt/jetty/webapps/
sudo mvn clean

# собрать бота
cd /home/admin/bot_source_code
mvn clean
mvn package

# Теперь нужно создать cron
echo "
java -jar /home/admin/bot_source_code/target/bot-1.0.jar --url http://10.0.2.10/secret?key=are3you4crazy5yes6i7am --screenshot test.jpg
" | sudo tee /home/admin/run.sh

echo "
* * * * * sh /home/admin/run.sh >/dev/null 2>&1
" | sudo tee /var/spool/cron/crontabs/admin
sudo service cron restart


# delete and clean history
rm -rf /home/admin/source/
rm -f /home/admin/setup.sh

history -c
echo "" | sudo tee /var/log/auth.log
rm -rf ~/.bash_history
kill -9 $$
