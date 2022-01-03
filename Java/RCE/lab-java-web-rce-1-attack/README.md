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
sudo apt-get update
sudo apt-get install wget curl unzip default-jdk wget unzip maven git whois dnsutils nginx



# jetty
sudo nano  /etc/systemd/system/rce.service
```
[Unit]
Description=service
After=network.target

[Service]

WorkingDirectory=/home/admin
ExecStart=/usr/bin/java -jar /home/admin/target/rce-0.0.1-SNAPSHOT.war

[Install]
WantedBy=multi-user.target
```


# sudo nano -c /etc/nginx/sites-enabled/default

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


sudo systemctl restart rce
sudo systemctl enable rce
sudo systemctl restart nginx

mvn clean
mvn compile
mvn package



;hostname

java-rce-attack-1