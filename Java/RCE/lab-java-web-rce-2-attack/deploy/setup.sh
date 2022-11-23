# устанавливаем необходимое ПО
sudo apt-get update -y
sudo apt-get install -y wget curl unzip default-jdk wget htop mc unzip maven git whois nginx markdown python python2.7

cd /home/admin

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
cd /sources/
sudo git clone https://github.com/WordPress/WordPress
sudo cp -R WordPress/* .
sudo rm -rf WordPress

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

cd /home/admin/source
sudo mvn clean
sudo mvn compile
sudo mvn package

sudo cp /home/admin/source/target/ROOT.war /opt/jetty/webapps/

sudo mvn clean

# flag
sudo echo "java_rce_find_escaper" > /opt/jetty/flag.txt

# delete and clean history
rm -rf /home/admin/source/
rm -f /home/admin/setup.sh

history -c
echo "" | sudo tee /var/log/auth.log
rm -rf ~/.bash_history
kill -9 $$
