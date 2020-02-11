# Carrinho de compras

Para o desenvolvimento da aplicação foi utilizado: 

- **PHP 7.1.32**.
- **MySql 8.0.0**. 
- **PhpStorm 2019.1**.

## Passos para rodar o projeto

1.  Configurar a database url no arquivo **.io-config.php** que se encontra na raiz do projeto:	
    - $DB_HOST = "localhost";
    - $DB_USER = 'root';
    - $DB_PASS = "";
    - $DB_NAME = "shopping";
    - $DB_CHARSET = "utf8";
    - $DB_PORT = "3306";
    
2. Executar o script shopping.sql que se encontra na raiz do projeto:
	- `shopping.sql`
  
3. Subir a aplicação no localhost:
	- `php -S localhost:8000`
