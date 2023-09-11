# Desafio API VENDAS

## Desafio Proposto

Desenvolver uma API para cadastro de vendas para vendedores e calcular a
comissão dessas vendas (a comissão será de 8.5% sobre o valor da venda)

Ao final de cada dia deve ser enviado um email com um relatório com a soma de
todas as vendas efetuadas no dia.

Criar uma aplicação que consuma essa api onde possamos utilizar todos os
serviços dela.

## Detalhes do Projeto
Tecnologias Usadas:
- Laravel
- Mysql
- Vuejs 3
- Bootstrap 5
- Docker
- PHPUnit

## API
Documentação da API: https://github.com/MatheusMeloAntiquera/desafio-api-vendas/wiki/API-Documentation

Para subir a API em ambiente local usando o docker bastar rodar os comandos:
Entrar na pasta da API:
```
cd api/
```
Copiar o .env example
```
cp .env.example .env
```
Subir o container da aplicação
```
docker-compose up -d
```
## Aplicação (Frontend)

O frontend da aplicação foi desenvolvido utilizando Vuejs 3 e Bootstrap.

Para subir aplicação rode os seguintes comandos:
Primeiro entre na pasta:
```
cd front/
```
Instale as dependências 
```
npm install
//or
yarn install
```
Suba aplicação:
```
npm run dev
```

## Envio do Relatório Diário

Para realizar o envio do relatório diário foi desenvolvido um commando (https://laravel.com/docs/10.x/artisan).

Esse comando fica localizado em `api\app\Console\Commands\EnviarRelatorioVendas.php`

O comando será utilizado pelo agendador do Laravel (https://laravel.com/docs/10.x/scheduling). 

O agendamento ficá localizado em `api\app\Console\Kernel.php`.

## Testes 

Foram desenvolvidos testes unitários e de integração para todas as rotas da API e o comando de envio de e-mail.

Juntamente foi criado uma automação com GitHub Actions no qual os testes serão executados sempre que houver commit na branch develop.

Os testes podem serem consultados aqui: https://github.com/MatheusMeloAntiquera/desafio-api-vendas/actions

