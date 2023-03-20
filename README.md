Bem vindo a um simples CRUD, utilizando PHP OOP com MariaDB e Docker


## Instalação

Inicie o projeto com Docker. Na raiz do projeto, digite

OBS: No arquivo "docker-compose-local.yml" há uma configuração comentada para você que quiser usar o Mysql. No exemplo, utilizei MariaDB.

```bash
  docker-compose up -d 
```

Acesse o container utilizando o bash

```bash
  docker exec -it volk-app bash
```

Crie as tabelas com as migrations

```bash
  ./vendor/bin/phinx migrate
```

## Acesse via Browser
```bash
  http://localhost:8888/
```


## Autores

- [@adrianomarinho](https://www.github.com/adrianomarinho)

## Referências
- [Docker](https://docs.docker.com/)
