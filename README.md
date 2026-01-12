# Backend

Este repositório contém uma API desenvolvida em Laravel, responsável por autenticação de usuários e gerenciamento da lista de filmes favoritos. Desenvolvida para o teste técnico da empresa [LWSA | King Host](https://king.host/hospedagem-de-sites).


## Tecnologias Utilizadas

- **PHP 8.1**
- **Laravel 10**
- **Laravel Sanctum**
- **MySQL**
- **Docker**
- **Docker Compose**
- **Nginx**
- **Composer**
- **REST API**

## Instalação
### Pré-requisitos

Certifique-se de ter instalado na sua máquina:

- Docker
- Docker Compose

---

Rode o seguinte comando na raiz do projeto:
```bash
./start.sh
```

Este comando executa um script auxiliar, que facilita a inicialização:
- Sobe os containers
- Instala de dependências e gera a chave da aplicação
- Executa as migrations e as seeders

Caso queira recriar o banco do zero, utilize:
```bash
./start.sh --reset
```

---

A API ficará disponível em:

```
http://localhost:8000
```

## Rotas

Para ver a documentação completa da API, [acesse aqui!](https://www.postman.com/cryosat-geoscientist-4230260/apis/collection/33926909-6d97e181-9f0e-4ad1-ab91-267387cf5483/?action=share&creator=33926909)


### Autenticação

`POST /register` Permite que novos usuários se registrem na aplicação.

`POST /login` Autenticar um usuário com base nas credenciais fornecidas (email e senha) e gerar um token de acesso, se as credenciais forem válidas.

```bash
{
  "email": "ana@gmail.com.br",
  "password": "password"
}
```

`POST /logout` Permite que usuários autenticados encerram sua sessão e invalidam o token de acesso.

---

### Favoritos
Ao realizar o login, copie o token gerado na resposta da requisição e adicione-o em Authorization → Bearer Token.

`POST /favorites` Permite criar adicionar um filme como favorito.
```bash
{
  "tmdb_movie_id": 540,
  "title": "D.E.B.S",
  "poster_path": "/78mnEEftCn4RBz68VRCRIgb1o3o.jpg",
  "genre_ids": [
      28, 35, 10749
  ]
}
```

`GET /favorites` Retorna a lista de filmes favoritos do usuário, incluindo algumas informações base da TMDB.

`DELETE /favorites/{id}` Permite excluir um filme da lista de favoritos com base no ID fornecido.

## Estruturas de pastas

```bash
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php              # Registro, login e logout de usuários
│   │   └── FavoriteMovieController.php     # CRUD de filmes favoritos
│   │
│   └── Requests/                           # Validação dos dados das requisições
│       ├── LoginRequest.php
│       ├── RegisterRequest.php
│       └── StoreFavoriteMovieRequest.php
│
├── Models/
│   ├── User.php                            # Model de usuários
│   └── FavoriteMovie.php                   # Model de filmes favoritos
│
├── Repositories/                           # Regras de negócios e acesso ao banco
│   ├── Contracts/                          # Interfaces dos repositórios
│   ├── AuthRepository.php
│   └── FavoriteMovieRepository.php

database/
├── migrations/
│   ├── x_create_users_table.php            # Estrutura da tabela de usuários
│   └── x_create_favorite_movies_table.php  # Estrutura da tabela de favoritos
│
├── seeders/
│   └── DatabaseSeeder.php                  # Seeds de dados

routes/
├── api.php                                 # Rotas da API

tests/
└── Feature/
    └── FavoriteMovieTest.php               # Testes da funcionalidade de favoritos
```

## Testagem da aplicação

A API pode ser testada de três formas:

- Utilize a [Postman Collection](https://www.postman.com/cryosat-geoscientist-4230260/apis/collection/33926909-6d97e181-9f0e-4ad1-ab91-267387cf5483/?action=share&creator=33926909), que contém exemplos de payloads, autenticação e endpoints configurados.

- Faça a configuração do [ambiente frontend](https://github.com/anaahnb/favorite-movies) e siga o fluxo:
  1. Login ou cadastro
  2. Pesquisa de filmes
  3. Adição de um filme aos favoritos
  4. Visualização da lista de favoritos, com opção de acessar o detalhe do filme ou removê-lo da lista

- Execute os **testes automatizados** da API, focados na funcionalidade de filmes favoritos (adição, listagem, remoção e controle de acesso).

### Testes automatizados
Para executá-los, utilize:
```bash
docker-compose exec app php artisan test
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
