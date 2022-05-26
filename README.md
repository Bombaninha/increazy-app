# increazy-app

## Breve descrição
A API foi construída através da utilização de um service (ViacepService). 
Nele construiu-se uma função para validação de CEP, para evitar Bad Requests, conforme descrito na API oficial. E duas outras funções que servem para buscar por um único CEP e outra para múltiplos.
Ademais, como o recurso é útil para a aplicação, em geral, construiu-se um command artisan que pode ser utilizado da seguinte maneira.

```
php artisan viacep:search ceps
```

Um exemplo seria: 

```
php artisan viacep:search 01001000,17560-246
```

## Quickstart
É necessário instalar as dependências, através de:

```
composer install && npm install
```

## Testes

Para rodar os testes é necessário:

```
php artisan test
```
