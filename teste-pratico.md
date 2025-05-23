# usar usuário no build
export HOST_UID=$(id -u)
export HOST_USER=$(whoami)

# build e up
docker-compose build --build-arg user=$HOST_USER --build-arg uid=$HOST_UID
docker-compose up -d

# gerar chave da aplicação Laravel
docker-compose exec app php artisan key:generate

# ajuste de permissões do storage e cache
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/

# roda as migrations e seeders
docker-compose exec app php artisan migrate:fresh --seed

# rodar os testes
sudo docker-compose exec app php artisan test --env=testing

# importação do csv
docker-compose exec app php artisan app:import-temperature example.csv
docker-compose exec app php artisan queue:work