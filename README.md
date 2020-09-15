# Conociendo Laravel

## Entendiendo el ciclo de vida de las solicitudes web

Para empezar el servidor virtual podemos usar el siguiente comando. Podemos ver la configuración en la ruta [Instalación en Laravel](https://laravel.com/docs/6.x/installation#configuration)

- **`php artisan serve`**

**Verificar la versión del Framework**

- **`php artisan --version`** Con este comando podemos ver qué versión de laravel está instalada.

**Ciclo de vida ¿Cómo funciona Laravel?**

Vamos a la carpeta donde vamos a alojar los sistemas.

Si abrimos la terminal y digitamos `laravel`, nos mostrará la versión instalada y algunos comandos útiles.

Para instalar un projecto, usamos el comando

- `laravel new sitio-web`

Con la herramienta `composer install` se crean los paquetes necesarios que por equivocación hayamos eliminado. Funciona como node en js o pip en python.

## Qué es un CRUD y cómo implementarlo

CRUD son las siglas de Crear, Leer, Actualizar y Eliminar (Create - Read - Update - Delete)

1. En este ejemplo, crearé un proyecto llamado CRUD

Uso el comando

- `laravel new crud`

Y usamos _mysql_ para la creación de la base de datos. El nombre de la base de datos será también **crud**.

Para indicar al framework la base de datos que se va a usar, podemos usar la variables de entorno que tiene en el archivo **`.env`**

Por defecto al crear un proyecto en Laravel, coloca en el nombre de base de datos, el nombre del proyecto que le hemos dado, en nuestro caso **crud**

> :star: **IMPORTANTE**
> En PHP nunca se trabaja con la base de datos directamente, se hace mediante el ORM, donde creamos las clases. Por defecto, laravel ya trate algunas clases que se encuentran en la carpeta **`database/migrations`**. Ahí se encuentran las clases que se encargan de crear las tablas y gestionar la comunicación con la base de datos.

Para crear las tablas, usamos el comando

- **`php artisan migrate`** _Creamos las tablas_

Este comando, lo usamos también para generar el servidor, lo que cambia es la palabra final; _**serve**_ para ejecutar el proyecto.

## Rutas

Todo empieza con las rutas. Para ver las rutas, podemos ejecutar el comando **php artisan route:list**

Las rutas las encontramos en la carpeta **routes** Y los archivos que contienen las rutas de la api y la web, son los respectivos archivos [api.php] y [web.php].

## Controladores

Teniendo creada las rutas, podemos crear los controladores. Para ello nos dirigimos a la carpeta **`app/Http/Controllers`** y allí creamos el archivo. POddemos usar el comando para crear el controlador

- **`php artisan make:controller UserController`**

> Para aquellos que esten trabajando con **Laravel V8 **van a tener muchos dolores de cabeza, resulta que cambio un poco la forma de escribir las rutas, para no tener errores usen:

```php
use App\Http\Controllers\UserController;
Route::get('/', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::delete('users/{user}', [UserController::class, 'destroy']);
```

## Lógica de controladores y vistas con datos de prueba

En el controlador, llamamos al modelo, que en este caso se encuentra en el directorio **`app/Models/`**. Allí se encuentra el archivo que luego lo llamaremos en el controlador mediante `use App\Models\User;`

### Creando las vistas

Las vistas se encuentran en el directorio **`resources/views/`**. Para ello creamos la carpeta **users** donde se alojarán las vistas respectivas para los métodos. Los nombres de las vistas, deben coincidir con el de los métodos del controlador.

### Creamos los datos de prueba para `usuarios`

Creamos datos de forma automática mediante el comando

- **`php artisan tinker`**

```
User::factory()->count(12)->create();
```

El comodín **@csrf** permite generar un token en Laravel, donde le indicamos que el formulario pertenece sólo a nuestra aplicación y no a una externa.

## Rutas y controladores

**Rutas** Capa encargada de manejar el flujo

**Controller** Nos permite agrupar lógica

:warning: El helper **`dd($request->all());`** permite ver el valor de una variable y detiene la ejecución.
