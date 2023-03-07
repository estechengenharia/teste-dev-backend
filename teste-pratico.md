
#  Teste para candidatos à vaga de Desenvolvedor PHP Estech

1 - Rodar Migrations - ./vendor/bin/sail php artisan migrate --seed
Rodar o comando php artisan command:csvimport ou utilizar o endpoint api/datacsv/import



Olá caro desenvolvedor, nesse teste analisaremos seu conhecimento geral e inclusive velocidade de desenvolvimento. Abaixo explicaremos tudo o que será necessário.

##  Instruções

O desafio consiste em implementar uma aplicação API Rest utilizando o framework PHP Laravel, um banco de dados relacional (Mysql), que terá como finalidade a inscrição de candidatos a uma oportunidade de emprego.

Sua aplicação deve possuir:

- CRUD de candidatos:
	- Deve ser ser possível "pausar" a vaga, evitando a inscrição de candidatos (Somente Recrutador). (Criar endpoint)

- Cada CRUD:
	- Implementar Cache utilizando Redis.
	- Testes automatizados.


##  Banco de dados

- O banco de dados deve ser criado utilizando Migrations do framework Laravel, e também utilizar Seeds e Factorys para popular as informações no banco de dados. (Fazer seeds e Factorys)


##  Entrega

- Para iniciar o teste, faça um fork deste repositório; **Se você apenas clonar o repositório não vai conseguir fazer push.**

- Crie uma branch com o seu nome completo;
- Altere o arquivo teste-pratico.md com as informações necessárias para executar o seu teste (comandos, migrations, seeds, etc);

- Depois de finalizado, envie-nos o pull request;

##  Bônus

- Permitir deleção em massa de itens nos CRUDs.
- Implementar autenticação de usuário na aplicação usando sanctum.
- Alguma implementação utlizando "Jobs" e "Notifications" do Laravel.

##  O que será analisado?

- Organização do código;
- Aplicação de design patterns;
- Raciocínio lógico;
- Aplicação de testes;
- Legibilidade;
- Criação do ambiente com Docker.

###  Boa sorte!
