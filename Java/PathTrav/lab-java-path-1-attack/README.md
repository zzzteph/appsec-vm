
sudo apt-get update -y 
sudo apt-get install -y default-jdk unzip maven nginx 



# jetty
sudo nano  /etc/systemd/system/path.service
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



# restarting service
sudo systemctl start path
sudo systemctl enable path
sudo systemctl restart nginx


mvn clean
mvn compile
mvn package


