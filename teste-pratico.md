#  Teste para candidatos à vaga de Desenvolvedor PHP Estech

##  O que foi implementado?

- Crud de Vagas (com cache nas consultas);
- Crud deUsuários (com cache nas consultas);
- Crud de Candidatos (com cache nas consultas);
- Comando para importação do arquivo exemple.csv;
- Endpoint que retorna (- Média, Mediana, Valor mínimo, Valor máximo, % acima de 10, % abaixo de -10, % entre -10 e 10.);
- Criação do ambiente com Docker.

## Teste para candidatos à vaga de Desenvolvedor PHP Estech

> **Status:** Developing ⚠️


## Alguns end points para facilitar

[Endpoints](https://documenter.getpostman.com/view/13172220/UzXKWyhY)


## Autores

- [@cidronioti](https://www.github.com/cidronioti)


## Tecnologias a serem utilizadas

**Back-end:** PHP, Laravel 9, Sail, Redis, Mysql


## Rodando localmente


Instalar dependências via composer

Subir os containers:
- No diretório do projeto executar

```bash
  ./vendor/bin/sail up
```

- Execute as migrations

```bash
  ./vendor/bin/sail artisan migrate
```

- Execute seeds para popular algumas tabelas

```bash
  ./vendor/bin/sail artisan db:seed
```

- Comando para importar dados do arquivo csv

```bash
  ./vendor/bin/sail artisan import:file
```


## Testes

Para fazer o deploy desse projeto rode primeiro os testes:

- [Todos os testes]()
```bash
  ./vendor/bin/sail artisan test
```





