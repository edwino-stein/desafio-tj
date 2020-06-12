## Desafio TJRR

Edwino Alberto Lopes Stein

### Requisitos

- php 7.2
  * php-common
  * php-cli
  * php-mb-string
  * php-curl
  * php-xml
  * php-pgsql
- composer
- postgresql
 
### Banco de dados

1. Criar um usuário no banco e configurar a conexão no arquivo `config/web.php`.
2. Execurar em sequencia os arquivos SQLs do diretório `bd/`

### Dependencias

Para instalar as dependencias do framework Yii, basta executar o comando:
```
$ composer install
```

### Executar o servido embutido do PHP

Abra o terminal e navegue pra o diretório raiz do projeto e então execute o comando:
```
$ ./yii serve
```
Será levantado um servidor HTTP na porta `8080`.
