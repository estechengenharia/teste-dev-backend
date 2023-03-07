
#  Teste para candidatos à vaga de Desenvolvedor PHP Estech

##  Instruções

1 - Rodar o composer: composer i
2 - Criar o .env: cp .env.example .env
3 - Subir os containeres: ./vendor/bin/sail up -d
OBS: Caso dê alguma falha nos containeres, rebuildar a applicação com o comando ./vendor/bin/sail build --no-cache
4 - Rodar Migrations e seeders: ./vendor/bin/sail artisan migrate --seed
5 - Importar CSV de exemplo com o comando ./vendor/bin/sail artisan command:csvimport ou utilizar o endpoint api/datacsv/import
6 - Rodar migrations do BD de teste: ./vendor/bin/sail artisan migrate --seed --env=testing
7 - Rodar os testes: ./vendor/bin/sail artisan test

Documentação básica da API: https://documenter.getpostman.com/view/17548537/2s93Joz6tG
