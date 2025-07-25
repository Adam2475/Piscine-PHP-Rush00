# Pacchetti da installare:

Composer version 2.8.10
PHP version 8.2.29 
Symfony CLI version 5.12.0


sudo apt update && sudo apt install -y php8.2 php8.2-cli php8.2-xml php8.2-mbstring php8.2-intl php8.2-curl php8.2-zip composer git
composer install

wget https://github.com/symfony-cli/symfony-cli/releases/download/v5.12.0/symfony_linux_amd64.tar.gz
tar -xzf symfony_linux_amd64.tar.gz
sudo mv symfony /usr/local/bin/symfony
rm symfony_linux_amd64.tar.gz

# Avviare progetto:

composer create-project symfony/website-skeleton nome_progetto