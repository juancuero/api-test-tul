# TulTest - Juan Cuero

Esta prueba consiste en realizar un catálogo de productos sencillo, exponiendo un API desde Laravel, donde la funcionalidad requerida será:


- Los productos disponibles deben contener: imagen, sku, nombre, descripción, categoría, stock y precio.

- Los productos pueden ser agregados a un carrito, que llevará el total a pagar, total de referencias y total de productos.

- Las categorías deberán de tener 2 niveles: categoría principal y categoría hija. Solo en la hija se pueden asignar los productos.

- Las categorías deberán tener: nombre y estado (activo/inactivo).


Las funcionalidades esperadas son:


- Los productos se mostrarán en el catálogo siempre y cuando el stock sea mayor a 0, la categoría del producto esté activa (tanto la padre como la hija) y el precio sea mayor a 0.

- Se pueden agregar, eliminar o modificar productos al carrito.

- Al agregar un producto al carrito y este supere la cantidad disponible, automáticamente colocarle la cantidad disponible.

- El stock debe de descontarse al confirmar la compra.

- Al llegar un producto a 0 de stock, ya no aparecerá en el catálogo.

## Requirements

- Laravel 8.12
- PHP >= ^7.3 

## Installation

Clone the repository

    git clone https://github.com/juancuero/api-test-tul.git
  
 Switch to the repo folder

    cd api-test-tul

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate
    
Run the database migrations and default data

    php artisan migrate --seed

Run documentation api

    php artisan l5-swagger:generate

This will create some products that you can use:
    
Start the local development server

    php artisan serve