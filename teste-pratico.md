#  Teste para candidatos à vaga de Desenvolvedor PHP Estech

Olá caro desenvolvedor, nesse teste analisaremos seu conhecimento geral e inclusive velocidade de desenvolvimento. Abaixo explicaremos tudo o que será necessário.

##  Instruções

#### copiar o arquivo .env
- cp .env.example .env (linux)
- copy .env.example .env (windows)
#### Rodar o docker
- docker-compose up -d --build
- docker exec -it estech_laravel-app_1 bash
- cd /usr/share/nginx
#### instalar o laravel
- composer install
#### limpar cache
- php artisan cache:clear
- php artisan config:clear
#### db
- php artisan migrate --seed
- exit
#### .env
vá no arquivo .env e altere DB_HOST=127.0.0.1  
#### Gerar Key
- php artisan key:generate
#### rodar o projeto
php artisan serve
