
# устанавливаем необходимое ПО
sudo apt-get update -y
sudo apt-get install -y default-jdk wget maven unzip nginx




sudo nano  /etc/systemd/system/ssti.service
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

sudo systemctl start ssti
sudo systemctl enable ssti
sudo service nginx restart


cd /home/admin/source
mvn package


sudo cat "SECRET_FLAG_VERY" >> /home/admin/flag.txt