
#  Teste para candidatos à vaga de Desenvolvedor PHP Estech

##  Instruções

### 📋 Pré-requisitos

Requisitos para instalação e execução:

```
- Laravel 9.x
- Docker
- Composer
```

### 🔧 Instalação e Execução

Executar os seguintes comandos para trabalhar localmente:

- Instalar as dependencias com o composer:
```
composer i
```
- Criar o .env copando do example através do comando: 
```
cp .env.example .env (linux)
ou
copy .env.example .env (windows)
```
- Subir container:
```
./vendor/bin/sail up -d
```
    - OBS: Caso dê alguma falha no container, rebuildar a applicação com o comando ./vendor/bin/sail build --no-cache
- Rodar Migrations e Seeders: 
```
./vendor/bin/sail artisan migrate --seed
```
- Importar CSV de exemplo com o comando: 
```
./vendor/bin/sail artisan command:csvimport 
```
ou utilizar o endpoint http://localhost/api/datacsv/import
- Rodar migrations do BD de teste: 
```
./vendor/bin/sail artisan migrate --seed --env=testing
```
- Rodar os testes: 
```
./vendor/bin/sail artisan test
```

Foi criado uma Job simples que manda um email para todos os usuários:
- Disparar job pelo endpoint http://localhost/api/send-notifications
- Visualizar o disparo pelo mailhog: http://localhost:8025/

### 🔧 Documentação da API

Foi criado um documento para facilitar o entendimento da api, que pode ser acessado atráves do link: 
https://documenter.getpostman.com/view/17548537/2s93Joz6tG

Usuarios para teste:
| Email | Senha |
|--------|--------|
| recrutador@teste.com | 123 |
| candidato@teste.com | 123 |