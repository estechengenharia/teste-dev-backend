## Descrição do Projeto
<p align="center">Api de Sistema de vagas de emprego utilizando laravel</p>

<h4 align="center"> 
	Sistema de Vagas de Emprego 🚀 
</h4>

### Features

- [x] CRUD Vaga
- [x] CRUD Usuários
- [x] Inscrição/Cancelamento de inscrição em vaga
- [x] Autenticação Laravel Sanctum


### 🛠 Tecnologias

As seguintes ferramentas foram usadas na construção do projeto:

- [Laravel](https://laravel.com/)
- [Laravel Sail](https://laravel.com/docs/8.x/sail)
- [MySql](https://www.mysql.com/)
- [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum)

## Como rodar a aplicação


- Configure um Alias para o Laravel Sail
- `alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'`
- Uma vez que o alias Bash foi configurado, você pode executar comandos Sail simplesmente digitando sail
- Para iniciar todos os containers docker digite:
- `sail up`
- Para instalar os pacotes Execute o comando 
- `composer install`
- Execute o comando para configurar o arquivo .env
- `cp .env.example .env` 
- Execute o comando para gerar a chave da aplicação 
- `php artisan key:generate` 
- Para rodar todas as migrações execute o comando:
- `sail artisan migrate`
- Para popular o banco de dados execute o comando
- `sail artisan db:seed`

Acesse a url `http://localhost:80/`.


### Documentação da API
https://documenter.getpostman.com/view/12697037/UzQys4BS
