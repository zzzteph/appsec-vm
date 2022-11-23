#min 5 gb

# устанавливаем необходимое ПО
sudo apt-get update
sudo apt-get install wget curl unzip default-jdk wget htop mc unzip maven git whois nginx markdown python python2.7

# Jetty нужно распаковать в папку /opt/jetty
wget https://repo1.maven.org/maven2/org/eclipse/jetty/jetty-distribution/9.4.27.v20200227/jetty-distribution-9.4.27.v20200227.zip
unzip jetty-distribution-9.4.27.v20200227.zip
rm -f jetty-distribution-9.4.27.v20200227.zip
sudo mkdir /opt/jetty
sudo cp -R jetty-distribution-9.4.27.v20200227/* /opt/jetty
sudo chmod 777 -R /opt/jetty
rm -rf jetty-distribution-9.4.27.v20200227/


# склонировать WP в /sources

cd /sources
sudo git clone https://github.com/WordPress/WordPress
sudo cp -R WordPress/* .
sudo rm -rf WordPress

# jetty
sudo nano  /etc/systemd/system/jetty.service
```
[Unit]
Description=VSCode as Service
After=network.target

[Service]

WorkingDirectory=/opt/jetty
ExecStart=/usr/bin/java -jar /opt/jetty/start.jar

[Install]
WantedBy=multi-user.target
```


# nginx proxy чтобы перекидывать с развернуторго jetty на 80 порт

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
sudo systemctl start jetty
sudo systemctl enable jetty


mvn clean
mvn compile
mvn package

sudo cp /home/admin/target/ROOT.war /opt/jetty/webapps/



sudo echo "java_rce_find_escaper" > /opt/jetty/flag.txt


