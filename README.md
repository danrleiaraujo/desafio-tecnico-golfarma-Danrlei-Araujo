# Desafio Técnico - API de Pedidos Golfarma -  Danrlei Araujo
Esta é uma API RESTful simples para gerenciamento de pedidos, construída com o framework Laravel. O projeto inclui funcionalidades de CRUD (Create, Read, Update, Delete) para pedidos utilizando Laravel Sail para um ambiente de desenvolvimento local baseado em Docker e a autenticação de usuários é feita com Laravel Sanctum.

<details open="open">
<summary>Sumário</summary>

- [Funcionalidades] (#Funcionalidades)
- [Pré-requisitos] (#Pré-requisitos)
- [Instalação e Configuração] (#Instalação-e-Configuração)
- [Executando a Aplicação] (#Executando-a-Aplicação)
- [Executando os Testes] (#Executando-os-Testes)
- [Documentação da API] (#Documentação-da-API)
- [Resumo das Rotas] (#Resumo-das-Rotas)
</details>

## Funcionalidades
-   Registro e Login de usuários.
-   Autenticação baseada em token (Sanctum).
-   CRUD completo para a entidade de Pedidos (Orders).
-   Testes de feature para garantir o funcionamento da API.

## Pré-requisitos
-   Git
-   Ide de sua preferencia (Ex. VSCode)
-   PHP = 8.3.6
-   Composer 
-   Laravel Framework = 12.28.1
-   Docker 
-   WSL (para usuários Windows)

## Instalação e Configuração

Siga os passos abaixo para configurar o ambiente de desenvolvimento.

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/danrleiaraujo/DesafioTecnico.git
    cd desafio-tecnico
    ```
2.  **Copie o arquivo de ambiente:**
    O Laravel Sail utiliza as configurações do arquivo `.env` para configurar os containers.
    ```bash
    cp .env.example .env
    ```

3.  **Suba os containers:**
    Este comando irá construir e iniciar os containers do servidor de aplicação, banco de dados (MySQL) e outros serviços.
    ```bash
    ./vendor/bin/sail up -d
    ```

4.  **Instale as dependências:**
    ```bash
    ./vendor/bin/sail composer install
    ```

5.  **Gere a chave da aplicação:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6.  **Execute as migrações e os seeders:**
    Este comando dropar as tabelas, rodar todas as migrations e executar os seeders.
    ```bash
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```

## Executando a Aplicação
Após o passo `./vendor/bin/sail up -d`, a aplicação já estará rodando e acessível em:
`http://localhost`

O banco de dados MySQL está rodando dentro de um container e pode ser acessado na porta `3306`do seu computador com as seguintes credenciais (definidas no `.env`):
-   **Host:** `127.0.0.1`
-   **Database:** `laravel`
-   **User:** `sail`
-   **Password:** `password`
-   Em caso de erro no docker, troque as portas para 3307 (tanto no `.env` quanto no `docker-composer.yml`)

## Executando os Testes
Para rodar a suíte de testes e verificar a integridade da API, utilize o comando:

```bash
./vendor/bin/sail artisan test
```

---

## Documentação da API
A URL base para todas as requisições é `http://localhost/`. Todas as requisições e respostas são no formato `JSON`.

### Autenticação
A maioria das rotas requer autenticação via token. Após o registro ou login, um `token` de acesso (Bearer Token) é retornado. Este token deve ser incluído no cabeçalho `Authorization` de todas as requisições subsequentes.

**Cabeçalhos necessários para rotas protegidas:**
```
Authorization: Bearer <seu-token>
Accept: application/json
```

---

### Rotas de Autenticação
#### 1. Registrar Usuário
-   **Endpoint:** `POST /api/register`
-   **Descrição:** Cria um novo usuário no sistema.
-   **Autenticação:** Não requerida.
-   **Parâmetros (Body):**
    -   `name` (string, required): Nome do usuário.
    -   `email` (string, required, unique): E-mail do usuário.
    -   `password` (string, required, min:6): Senha do usuário.
    -   `password_confirmation` (string, required): Confirmação da senha.
-   **Exemplo de Requisição:**
    ```json
    {
        "name": "Danrlei Araujo",
        "email": "danrlei@example.com",
        "password": "password123",
        "password_confirmation": "password123"
    }
    ```
-   **Resposta de Sucesso (201 Created):**
    ```json
    {
        "user": {
            "name": "Danrlei Araujo",
            "email": "danrlei@example.com",
            "updated_at": "2024-05-22T18:00:00.000000Z",
            "created_at": "2024-05-22T18:00:00.000000Z",
            "id": 1
        },
        "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890"
    }
    ```

#### 2. Login de Usuário
-   **Endpoint:** `POST /api/login`
-   **Descrição:** Autentica um usuário e retorna um token de acesso.
-   **Autenticação:** Não requerida.
-   **Parâmetros (Body):**
    -   `email` (string, required): E-mail do usuário.
    -   `password` (string, required): Senha do usuário.
-   **Exemplo de Requisição:**
    ```json
    {
        "email": "danrlei@example.com",
        "password": "password123"
    }
    ```
-   **Resposta de Sucesso (200 OK):**
    ```json
    {
        "user": {
            "id": 1,
            "name": "Danrlei Araujo",
            "email": "danrlei@example.com",
            "email_verified_at": null,
            "created_at": "2024-05-22T18:00:00.000000Z",
            "updated_at": "2024-05-22T18:00:00.000000Z"
        },
        "token": "2|aBcDeFgHiJkLmNoPqRsTuVwXyZ0987654321"
    }
    ```

#### 3. Logout de Usuário
-   **Endpoint:** `POST /api/logout`
-   **Descrição:** Invalida o token de acesso atual do usuário.
-   **Autenticação:** Requerida.
-   **Resposta de Sucesso (200 OK):**
    ```json
    {
        "message": "Logged out successfully"
    }
    ```

---

### Rotas de Pedidos (Orders)
As rotas a seguir **requerem autenticação**.
#### 1. Listar Pedidos
-   **Endpoint:** `GET /api/orders`
-   **Descrição:** Retorna uma lista paginada de todos os pedidos.
-   **Resposta de Sucesso (200 OK):**
    ```json
    {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "cliente": "Cliente Exemplo 1",
                "total": "199.99",
                "status": "pending",
                "created_at": "2024-05-22T18:05:00.000000Z",
                "updated_at": "2024-05-22T18:05:00.000000Z"
            }
        ],
        "first_page_url": "http://localhost/orders?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost/orders?page=1",
        "links": [],
        "next_page_url": null,
        "path": "http://localhost/orders",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
    ```

#### 2. Criar um Novo Pedido
-   **Endpoint:** `POST /api/orders`
-   **Parâmetros (Body):**
    -   `cliente` (string, required): Nome do cliente.
    -   `total` (numeric, required, min:0): Valor total do pedido.
    -   `status` (string, required): Status do pedido. Valores permitidos: `pending`, `processing`, `completed`, `cancelled`.
-   **Exemplo de Requisição:**
    ```json
    {
        "cliente": "Novo Cliente",
        "total": 123.45,
        "status": "pending"
    }
    ```
-   **Resposta de Sucesso (201 Created):**
    ```json
    {
        "cliente": "Novo Cliente",
        "total": "123.45",
        "status": "pending",
        "updated_at": "2024-05-22T18:15:00.000000Z",
        "created_at": "2024-05-22T18:15:00.000000Z",
        "id": 2
    }
    ```

#### 3. Exibir Detalhes de um Pedido
-   **Endpoint:** `GET /api/orders/{id}`
-   **Parâmetro (URL):**
    -   `id` (integer, required): O ID do pedido.
-   **Resposta de Sucesso (200 OK):**
    ```json
    {
        "id": 1,
        "cliente": "Cliente Exemplo 1",
        "total": "199.99",
        "status": "pending",
        "created_at": "2024-05-22T18:05:00.000000Z",
        "updated_at": "2024-05-22T18:05:00.000000Z"
    }
    ```

#### 4. Atualizar um Pedido
-   **Endpoint:** `PUT /api/orders/{id}` ou `PATCH /orders/{id}`
-   **Parâmetro (URL):**
    -   `id` (integer, required): O ID do pedido a ser atualizado.
-   **Parâmetros (Body):**
    -   `cliente` (string, optional): Novo nome do cliente.
    -   `total` (numeric, optional): Novo valor total do pedido.
    -   `status` (string, optional): Novo status do pedido. Valores permitidos: `pending`, `processing`, `completed`, `cancelled`.
-   **Exemplo de Requisição (PATCH):**
    ```json
    {
        "status": "completed"
    }
    ```
-   **Resposta de Sucesso (200 OK):**
    ```json
    {
        "id": 1,
        "cliente": "Cliente Exemplo 1",
        "total": "199.99",
        "status": "completed",
        "created_at": "2024-05-22T18:05:00.000000Z",
        "updated_at": "2024-05-22T18:20:00.000000Z"
    }
    ```

#### 5. Deletar um Pedido
-   **Endpoint:** `DELETE /orders/{id}`
-   **Parâmetro (URL):**
    -   `id` (integer, required): O ID do pedido a ser deletado.
-   **Resposta de Sucesso (204 No Content):**
    -   Nenhum conteúdo no corpo da resposta.

## Resumo das Rotas
| Método | Endpoint           | Autenticação | Descrição                |
| ------ | ------------------ | ------------ | ------------------------ |
| POST   | `/api/register`        | ❌           | Criar usuário            |
| POST   | `/api/login`           | ❌           | Login                    |
| POST   | `/api/logout`          | ✅           | Logout                   |
| GET    | `/api/orders`          | ✅           | Listar pedidos           |
| POST   | `/api/orders`          | ✅           | Criar pedido             |
| GET    | `/api/orders/{id}`     | ✅           | Exibir pedido específico |
| PUT    | `/api/orders/{id}`     | ✅           | Atualizar pedido         |
| DELETE | `/api/orders/{id}`     | ✅           | Excluir pedido           |
