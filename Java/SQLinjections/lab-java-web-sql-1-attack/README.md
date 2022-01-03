#min 5 gb

# устанавливаем необходимое ПО
sudo apt-get update
sudo apt-get install wget curl unzip default-jdk unzip maven nginx mariadb-server 



# jetty
sudo nano  /etc/systemd/system/sql.service
```
[Unit]
Description=service
After=network.target

[Service]

WorkingDirectory=/home/admin
ExecStart=/usr/bin/mvn spring-boot:run

[Install]
WantedBy=multi-user.target
```

#nginx proxy чтобы перекидывать с развернуторго jetty на 80 порт
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


sudo systemctl start sql
sudo systemctl enable sql
sudo service nginx restart



#Настройки БД

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




cd /home/admin/source
mvn clean
mvn compile
mvn package








