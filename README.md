# app-choose-pic

Este é um projeto Laravel para upload e gestão de imagens, configurado para rodar localmente com PHP, Composer, Node.js e Vite.

## Pré-requisitos

- PHP 8.2+
- Composer
- Node.js 18+ / npm
- PostgreSQL (ou outro banco configurado em `.env`)
- Redis, se usar filas ou cache via Redis

> O `.env.example` está configurado por padrão para `DB_CONNECTION=pgsql`.

## Instalação

1. Instale as dependências PHP:

```bash
composer install
```

2. Crie o arquivo de ambiente:

```bash
copy .env.example .env
```

3. Gere a chave da aplicação:

```bash
php artisan key:generate
```

4. Ajuste as configurações de banco de dados em `.env` se necessário.

5. Rode as migrations:

```bash
php artisan migrate
```

6. Instale as dependências de frontend:

```bash
npm install
```

## Execução em modo desenvolvimento

Para iniciar o servidor e o Vite em modo de desenvolvimento:

```bash
npm run dev
```

Em outro terminal, rode o servidor Laravel local:

```bash
php artisan serve
```

A aplicação ficará disponível em `http://127.0.0.1:8000`.

## Scripts úteis

- `composer setup` — instala dependências, cria `.env`, gera a chave, executa migrations e compila assets.
- `composer test` — executa os testes do Laravel.
- `npm run build` — gera os assets de produção.

## Testes

```bash
composer test
```

## Observações

- Se você usar `QUEUE_CONNECTION=database`, execute `php artisan queue:listen` ou `php artisan queue:work` para processar filas.
- Se precisar de Redis, ajuste `REDIS_HOST`, `REDIS_PORT` e `REDIS_PASSWORD` em `.env`.
