## Construir Proyecto Final: API con TDD (Intermedio)

El Testing define el desarrollo profesional de software. Y créeme podrás dormir tranquilo. Permite crear código de calidad.

> Si estas trabajando con VSCode tienes la opcion de descargar un plugin que se llama phpUnit, con este pudes colocar el apuntador en cualquier metodo que desees probar y usando en Mac command+shift+p, en windows: ctrl+shift+p, podras llamar a un prompt ahi escribes la palabra test y tendras la opcion de correr todos o en el que te encuentras trabajando asi aceleras un poco mas tu workflow

Empezamos instalando un proyecto desde cero.

- **`laravel new api`**

Una prueba unitaria es aquella que nos permite probar pequeños bloques de código.

Cuando trabajamos con api, trabajamos con pruebas funcionales, donde tomamos toda la raíz, usando el archivo `testBasicTest.php`

Todo el sistema lo estaremos revisando desde la terminal y no del navegador.

Para ello, usamos

- **`php artisan make:test`**

Le empezamos a dar nombres a las pruebas de nuestras clases.

- **`php artisan make:test UserTest`** Esto nos crea el test para el controlador User, esto nos crea un archivo dentro de la carpeta **test/Feature**

Generalmente nosotros hacemos las pruebas en el navegador, pero esto no lo deberíamos realizar manualmente, debido a que si el sistema es demasiado grande no podemos probarlo completamente.

Si usamos

- **`php artisan make:test UserTest --unit`** Nos crea un archivo dentro de la carpeta **test/Unit**

Para ver como está funcionando esto, usamos el comando

- **`vendor/bin/phpunit`**

En la carpeta Test, creamos todas las clases necesarias para realizar las pruebas, que prueben el codigo.

## Metodología TDD y testing HTTP

- **Testing HTTP** Todas las pruebas la hacemos mediante la web, el navegador.

Cuando no utilizamos testing, probamos directamente en el navegador. Pero si utilizamos testing, no usamos el navegador.

- **Testing TDD**

  - **Paso 1**: Crear prueba, para obtener **rojo**
  - **Paso 2**: Crear código para cumplir con esa prueba, para obtener **verde**
  - **Paso 3**: **Refactorización** es una revisión posterior de revisar, organizar, crear métodos, para seguir consiguiendo verde sin alterar la prueba.

- **`php artisan make:test PageTest`** Crea una prueba unitaria, que se llame Page

- **`vendor/bin/phpunit`** Utilizamos el comando de probar.

Cada método es un Test, siempre inicia con la palabra **home**, siendo los un método `test_home()`, en el caso de probar el home.

Luego de realizar el primer paso (rojo), seguimos con verde, para poder pasar la prueba (verde), y luego de pasarla, refactorizamos el código.

## Proyecto API con TDD (Test Driven Development - Desarrollo guiado por pruebas): presentación y configuración inicial

### Paso 1. Crear prueba

Creamos el archivo de pruebas siguiendo el mismo orden la ruta en el controlador.

- `php artisan make:test Http/Controllers/Api/PostControllerTest`

Luego _creamos los archivos base_, los **modelos**, factorys, y migrations.

- `php artisan make:model Post -fm`

Creamos el controlador

- `php artisan make:controller Api/PostController --api --model=Post`

**--api** crea un controlador de recursos con sólo 5 métodos.
**--model=Post** Le indicamos que se conecte con la entidad del modelo que se ha creado previamente

### Creamos la base de datos para Testing

Creamos la base de datos para las pruebas unitarias. El arhivo lo llamamos `database.sqlite`. En la carpeta **config** vamos y quitamos el llamado de la variable de entorno del driver para _sqlite_, de forma que trabaje sólo con el archivo database.sqlite.

Esto se hace, porque el archivo **phpunit.xml** define la conección a la base de datos mediante sqlite.

> :warning: Si usan _laravel en su versión 7.3 en adelante_ pueden utilizar el comando **_php artisan test_** en lugar de vendor/bin/phpunit . El comando artisan test les proveera mas información y una interfaz mas amigable.

Lo que hacemos nosotros es la prueba, y que ella nos ayude para escribir el código.

La prueba se reaiza en la carpeta **tests** dentro de `PostControllerTest.php`, mantiendo la misma estructura de archivos que el desarrollo.

El siguiente método, garantiza que los datos se estén almacenando correctamente. Prácticamente se realizan 3 validaciones.

```php
public function test_store()
{
    // Necesitamos comprobar que se estén guardando lo datos (Método POST) a la API

    // $this->withoutExceptionHandling(); # Para saber los errores presentados

    $response = $this->json('POST', '/api/posts', [
        'title' => 'El post de prueba'
    ]);

    $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
        ->assertJson(['title' => 'El post de prueba'])
        ->assertStatus(201); // OK, se ha creado un recurso

    $this->assertDatabaseHas('posts', ['title' => 'El post de prueba']);
}
```

:fire: :warning: Para crear la base de datos, recordar ejecutar el comando **`php artisan migrate`**

### Creamos un request para hacer la validación de los campos

- **`php artisan make:request PostRequest`**

De esta forma, le indicamos la validacion de los campos, dejando el campo de título como **required**, de esta forma ahora el sistema no mostrará error 500 por la base de datos, si no 402, porque el campo es requerido.

## Show con TDD

Se crea el otro método para probar el método show del controlador. Para ello, se usa la factory, para crear un registro y poder consultar.

```php
public function test_show()
{
    $post = Post::factory()->create();

    $response = $this->json('GET', "/api/posts/$post->id");  // id = 1

    $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
        ->assertJson(['title' => $post->title])
        ->assertStatus(200); // OK, se ha creado un recurso
}
```

Para ello, también se configura la fábrica usando la clase de faker, para crear un título para el post. Em método _definition()_ para la clase PostFactory, quedaría como

```php
public function definition()
{
    return [
        'title' => $this->faker->sentence
    ];
}
```

Finalmente, se programa el método show. Para ello, sólo debemos devolver los datos.

```php
public function show(Post $post)
{
    return response()->json($post);
}
```

## Update y validación con TDD

> Dentro de cada método de test (Si se va a crear o actualizar), se debe hacer la línea de creación de un post para probar. Cada método es independiente.

Para esta clase se hizo el test de update que consta de

- Crear un post con factory
- Actualizarlo mediante una peticion PUT, encontrandolo mediante su ID y enviando la key con el valor
- Verificando estructura del json, valor y key, y status ok
- Verificando el valor y la key en la DB

Las pruebas las podemos usar para sólo un método, usando el flag `--filter` y pasando el nombre del método, de la siguiente forma

- **`vendor/bin/phpunit --filter test_update`**

Si por algún motivo sale error y no sabes cuál es, podemos usar la siguiente instrucción en el método que estemos desarrollando la prueba.

```php
$this->withoutExceptionHandling();
```

## Delete con TDD

Para realizar la prueba con el método delete, se realiza lo siguiente:

1. Crear un post con factory.
2. Configuro la solicitud para eliminar el post con el ID
   pasado por la ruta de eliminación.
3. Verificar que la respuesta este null y el status sea 204
4. verificar que el id no se encuentra en la base de datos.

**Nota**: `$response->assertSee(null)` Afirma que el string dado esta contenido en la respuesta.

## Index con TDD

El index, es el que permite ver una lista de registros. Los pasos para crear la prueba son:

1. Creamos los datos
2. Accedemos a la ruta mediante el método GET
3. Verificamos que obtenemos la estructura de json
4. Verificamos que el estado de la consulta HTTP sea 200

Para el método de prueba queda como:

```php
public function test_index(){
    // Creamos los 5 datos
    Post::factory(5)->create();

    // Accedemos a la ruta mediante el método GET
    $response = $this->json('GET', '/api/posts');

    // Verificamos que obtenemos la estructura de json
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'title', 'created_at', 'updated_at']
        ]
    ])->assertStatus(200); // Status OK
}
```

El método index, en el controlador quedaría como

```php
public function index(){
    return response()->json($this->post->paginate());
}
```

## Protección de una API con Login

Hasta lo que se ha realizado, ha sido un API público. Para configurarlo, debemos ir a las rutas. En este caso en la api, se usa la autenticación mediante token.

```php
use App\Http\Controllers\Api\PostController;
Route::apiResource('posts', PostController::class)->middleware('auth:api');
```

Se realiza la comprobación de autenticación en la ruta con:

```php
public function test_guest(){
  $this->json('GET', '/api/posts')->assertStatus(401); // No tenemos acceso
  $this->json('POST', '/api/posts')->assertStatus(401);
  $this->json('GET', '/api/posts/1000')->assertStatus(401);
  $this->json('PUT', '/api/posts/1000')->assertStatus(401);
  $this->json('DELETE', '/api/posts/1000')->assertStatus(401);
}
```

Pero nos falta realizar la modificación en los otros métodos de test para verificar que es un usuario autenticado, el que realiza las consultas a la base de datos.

Para ello debemos usar el método **`actingAs($user, 'api')`**, usando el usuario que hemos creado y que se el logueo se aplique mediante token.

De donde pasamos a tener

```php
$response = $this->json('POST', '/api/posts', [
  'title' => 'El post de prueba'
]);
```

A tener

```php
$user = User::factory()->create();

$response = $this->actingAs($user, 'api')->json('POST', '/api/posts', [
    'title' => 'El post de prueba'
]);
```

Con esto, cada vez que vayamos a utilizar un método garantizamos que estamos logueados, y además probamos que pasa si hay un usuario invitado.

Ya teniendo, todo esto. Nos ha quedado la API completamente, usando las pruebas unitarias.
