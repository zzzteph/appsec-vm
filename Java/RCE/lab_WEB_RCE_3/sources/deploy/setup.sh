# install docker
sudo apt-get update -y
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh
rm get-docker.sh
sudo curl -L "https://github.com/docker/compose/releases/download/1.25.3/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo systemctl enable docker

# run docker-compose.yml
cd /home/admin/
sudo chmod +x /home/admin/source/phantomjs
sudo chown www-data:www-data /home/admin/source/ -R
sudo chmod 777 /home/admin/source/pdfs/

sudo docker-compose up -d --build;

# clear history
history -c
echo "" | sudo tee /var/log/auth.log
rm -rf ~/.bash_history
kill -9 $$
