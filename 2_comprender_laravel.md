# Comprender los fundamentos de Laravel

## Uso de Middlewares

Veamos en este post cómo crear e implementar un middleware. **La función principal es proporcionar una fácil y conveniente capa para filtrar las solicitudes HTTP**. Existen diferentes maneras de hacerlo y de hecho Laravel incluye un middleware que verifica si el usuario está autenticado.

Puedes crear un middleware de registro y tener logs detallados de cada solicitud entrante, cualquier cosa que se te ocurra respecto a HTTP puedes llevarla a cabo usando esta tecnología.

## Middleware Personalizado

- **`php artisan make:middleware Subscribed`**

Este se crea en `app/Http/Middleware/Subscribed.php`. Con él puedes verificar si el usuario está suscrito a mi plan de pago de mi sistema web. O crear un middleware que revise si el usuario que se intenta registrar es mayor de edad.

**`php artisan make:middleware VerifyAge`**

En ambos casos tendremos nuestros middleware estarán creados en `app\Http\Middleware\`. Dentro de cada archivo debemos colocar la lógica de acceso correcto. Por ejemplo:

```php
<?php
namespace App\Http\Middleware;

use Closure;

class Subscribed
{
    //...
    public function handle($request, Closure $next)
    {
        if ( ! $request->user()->subscribed) {
            return abort(403, 'Sin suscripción activa');
        }

        return $next($request);
    }
}
```

**403:** La solicitud fue legal, fue correcta, pero el servidor no la responderá porque el cliente no tiene los privilegios o permisos.

Y respecto a la edad podemos hacer lo siguiente:

```php
<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAge
{
    //...
    public function handle($request, Closure $next)
    {
        if ($request->get('age') < 18) {
            return redirect('guidelines');
        }

        return $next($request);
    }
}
```

Aquí dirigimos al usuario a una vista que tenga los textos apropiados para explicarle porqué no podemos seguir con el registro.

## Registro de las Clases Middleware

```php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    //...
    protected $middleware = [];

    //...
    protected $middlewareGroups = [];

    //...
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'subscribed' => \App\Http\Middleware\Subscribed::class,
        'verify-age' => \App\Http\Middleware\VerifyAge::class,
    ];

    //...
    protected $middlewarePriority = [];
}
```

Y luego podemos usarla y aplicarla donde corresponde. Veamos en una ruta varios ejemplos:

```php
Route::get('/example', 'ExampleController@...')
    ->middleware('auth', 'subscribed', 'verify-age');`
```

Acá y en el video de la clase vimos la forma correcta de proteger a nuestras rutas o métodos en controladores, lo importante es definir qué queremos proteger o interceder y crear la lógica en un archivo aparte. Una persona con poca experiencia usaría estos if pero en las vistas, en cada método de un controlador o en cada una de las rutas. Esto funcionaria pero no es la manera correcta de trabajar.

> **Los middleware por lo general se colocan en las rutas para evitar hacer tan| largos los controladores.**

Formas de definir las rutas en Laravel

```php
Route::get('/', function(){
  return view('welcome');
})

# A continuación podemos realizar lo mismo usando
Route::get('vista', 'welcome', ['app' => 'hola']);
```

**Podemos crear los controladores con artisan mediante**

- **Route::resourc**e: Te permite gestionar 7 rutas junto con un controlador
- `php artisan make:controller [NombreControlador]`: Genera un controlador
- `php artisan make:controller [NombreControlador] --resource`: Genera un controlador con las 7 funciones necesarias que necesita Route::resource
- `php artisan make:controller [NombreControlador] --resource --model`: Genera un controlador con las 7 funciones necesarias que necesita Route::resource así como el modelo necesario para ese controlador

De hecho si pones **`php artisan make:model [NombreModelo] -r -m -c Te crea -r: resource, -m`**: migración, -c: controlador, te ahorra un poco de código y además hace que tu proyecto esté un poco mas ordenado

:fire: _En laravel 8.x hay que importar el controlador_:

```php
use App\Http\Controllers\PageController;
# Y la ruta:
Route::resource('pages', PageController::class);
```

## Validación de datos (rutas, vistas, formularios y controladores)

Las validaciones nos permiten filtrar que los datos que ingresamos en los formularios, son los que realmente se piden.

> :star: La clase **Request** es la que se encarga de tener todos los datos de nuestro formulario.

Para la validación usamos la CLI para realizar el proceso.

- **`php artisan make:request PostRequest`**

## Blade: sistema de plantillas avanzado

Sistema de plantillas en Laravel, con características propias de un lenguaje de plantillas.

## Trabajando con el componente Laravel/UI

Registro y autenticación de usuarios en un sistema Web en Laravel

- **`composer require laravel/ui --dev`** `--dev` Para usarlo sólo en desarrollo

Luego de tenerlo instalado tenemos 3 formas de usar el sistema básico con diseño

- **`php artisan ui bootstrap`**
- **`php artisan ui vue`**
- **`php artisan ui react`**

Para contar con el sistema de autenticación creado, usamos

- **`php artisan ui:auth`**

Para usarlo con estilos le agregamos la bandera `--auth`

- **`php artisan ui bootstrap --auth`** _Nos crea el sistema de autenticación con estilos y funcionalidad_

Luego, dde ejecutar este comando, para ver aplicado los estilos podemos usar

- **`npm install && npm run dev`**
