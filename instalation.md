# Introducción a Laravel

## Requisitos

Para trabajar con PHP necesitamos convertir a nuestro equipo en un servidor web, esto se debe a PHP es un lenguaje del lado del servidor a diferencia de Javascript que es del lado del cliente y funciona bien solo con el navegador.

Del lado del servidor significa que consiste en el procesamiento de una petición de usuario en una computadora llamada servidor web, esta petición se procesa y luego genera páginas en HTML con la respuesta deseada.

- **Servidor HTTP**

Un servidor web o servidor HTTP es básicamente un programa que se instala en una computadora con el fin de procesar un sistema web, con este programa la computadora queda preparada para recibir peticiones de usuario generando respuestas a clientes. Cuando escribes en el navegador platzi.com y presionas enter se busca en Internet la computadora con este nombre y al encontrarla el servidor procesa, entiende lo que necesitas y retorna la respuesta "la página home de platzi".

Para crear un proyecto o programa web necesitamos simular que nuestro computador es un servidor web y lo logramos instalando un programa, en este caso sería Apache o Nginx.

- **PHP**

Es el lenguaje de programación que usaremos en el curso y necesitamos instalarlo para que nuestro Servidor HTTP interprete correctamente nuestro código. Básicamente vamos a escribir en PHP así que instalamos el idioma PHP en nuestro equipo.

- **Base de datos**

Necesitamos instalar en nuestro equipo la base de datos que usaremos en el curso, esta puede ser MySql o MariaDB. Ambas funcionarían muy bien porque se entienden perfectamente con PHP.

- **Software de instalación**

En resumen necesitamos convertir a nuestro equipo en un servidor web, para ellos básicamente instalamos:

1. **Servidor web**: Apache o Nginx.
2. **Lenguaje**: PHP.
3. **Base de datos**: MySql o MariaDB.

Hay varias opciones, yo te recomiendo instalar las mas sencillas porque nuestro enfoque es la programación no la administración de servidores y estos conceptos hay que entenderlos bien, sin darnos cuenta estamos haciendo de nuestro computador un servidor web y un servidor de base de datos.

1. **XAMPP**: https://www.apachefriends.org/es/download.html.

2. **MAMP**: https://www.mamp.info/en/downloads/.

3. **En Mac** Usando brew en Mac podrías instalar valet y por separado a PHP y MySql. El tutorial completo está en la doc de Laravel https://laravel.com/docs/6.x/valet básicamente sería:

- `brew update`
- `brew install php`
- `brew install mysql`
- `composer global require laravel/valet`
- Por último `valet install`

También existe la opción de usar Homestead, esto es más avanzado y requiere una configuración mayor, aquí la doc https://laravel.com/docs/6.x/homestead

## Herramientas importantes

El método de instalación de Laravel es a través de composer, un gestor de paquetes PHP que provee todo lo que necesitemos respecto a este lenguaje. Puedes instalarlo desde este enlace https://getcomposer.org/download/

También es muy importante contar con Git, este es nuestro control de versiones de nuestro software y lo podemos instalar desde su web https://git-scm.com/downloads

Para escribir código necesitaremos a Sublime Text, Visual Studio Code o el editor que prefieras, en el curso usaremos a Visual Studio Code. Y para observar el resultado podemos usar a cualquier navegador web, yo usaré Google Chrome.

## Resumen

Necesitamos el software necesario para convertir nuestro computador en un servidor web, en resumen necesitamos:

1. Lenguaje: PHP >= 7.2.0.
2. Servidor: Apache, Nginx.
3. Base de datos: MySql, MariaDB.
4. Composer.
5. Git.
6. Editor de código.
7. Navegador.

## Instalación de Laravel

Podemos usar composer directamente o instalar un software llamado "instalador de Laravel".

1. Con composer sería composer `create-project --prefer-dist laravel/laravel nombre-app`
2. Con Laravel Installer sería `composer global require laravel/installer`.
   En el curso usaremos la opción dos, sin embargo puedes usar el método que gustes y todo al respecto lo conseguirás en este enlace: https://laravel.com/docs/6.x/installation

**Usas Mac y solo debes actualizar**

Laravel siempre nos obligará a estar actualizado, te comparto este enlace: https://rimorsoft.com/actualizar-a-php-7-3-x-con-homebrew-en-mac, te ayudará mucho si usas Mac y un entorno de trabajo parecido al mio.
