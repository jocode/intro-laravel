# 3. Aprender sobre Eloquent ORM

**Eloquent** es una simple forma de trabajar con Base de datos. Es una forma de _usar base de datos en Laravel sin escribir SQL_

Un **modelo** básicamente es la representación de una tabla en la base de datos.

Usamos el comando

- **`php artisan make:model Post -m -f`** Usamos `-m` y `-f` para crear la migración y la factory respectivamente

Agregamos el título al post, con el archivo de migrations generado anteriormente.

- **`php artisan migrate`** Con este comando lo que hacemos es crear las tablas en la base de datos.

_Ahora debemos crear unos posts en la base de datos. Para eso usamos **tinker** en PHP_

- **`php artisan tinker`**

Luego configuramos el factory para generar los posts. Para ello vamos a la carpeta **database/factories/PostFactory.php** y nos dirigimos al método `definition`

```php
...
return [
    'title' => $faker->sentence
];
```

Ahora en la terminal digitamos

```php
# Para la versión de PHP 6x
factory(App\Models\Post::class, 30)->create()

# Para la versión 8x
Post::factory()->count(12)->create();
```

## Relaciones de tablas

- **Relaciones de Tablas** Unir datos
- **Collecciones y Serialización** Manipular la información
- **Formato de datos y presentación** Formato de datos

Para eso, necesitamos actualizar los campos en la base de datos. Para eso, vamos a la base de datos ubicada en **database/migrations/** y con eso ubicamos algunos valores.

```php
// Para relacionar las tablas
$table->unsignedBigInteger('user_id');
$table->foreign('user_id')->references('id')->on('users');
```

Luego actualizamos la base de datos con

- **`php artisan migrate`**

- **`php artisan migrate:refresh`** Para actualizar la base de datos, lo malo de refrescar la base de datos, es que se eliminan los datos.

Para evitar tener que crear nuevos datos en la base de datos, actualizamos el DatabaseSeeder de forma que podamos actualizar los datos.

```php
use App\Models\User;
use App\Models\Post;

....

# database/seeeders/DatabaseSeeder.php
User::factory(4)->create();
Post::factory(30)->create();
```

Y creamos el nuevo campo de referencia a la tabla de Post **`'user_id'`** hacia la tabla usuarios.

```php
public function definition()
{
    return [
        'user_id' => rand(1, 4),  # <= Este llave foránea
        'title' => $this->faker->sentence
    ];
}
```

Luego actualizamos los datos, para crear los datos de semilla.

- **`php artisan migrate:refresh --seed`**

### Relaciones entre las tablas para las base de datos

En la factory de User (`database/factories/UserFactory.php`)

```php
public function posts(){
    // Un usuario puede tener muchos posts
    return $this->hasMany(Post::class);
}
```

En la factory de Post (`database/factories/PostFactory.php`)

```php
public function user(){
    // Un posts pertenece a un usuario
    return $this->belongsTo(User::class);
}
```

Teniendo las tablas relacionadas, podemos consultar los datos entre ambas tablas, todo trabajando con el ORM que tiene Laravel.

## Colecciones y serialización de datos

- **Colecciones** Es un conjunto de datos, con mucha información.Es la forma de trabajar con muchos métodos para manipular fácilmente nuestros datos.

- **Serialización** Es manipular esa información, y retornarlos en arrays o json

## Formato de valores en tablas y presentación de datos

Para dar formato a los atributos de la tabla, debemos usar la siguiente convención.

**get`NombreCampo`Attribute** donde debe empezar con _get_, en el medio colocar el nombre y debe finalizar con la palabra _Attribute_. A ese nombre se le llama campo lógico en este caso **NombreCampo**.

Para obtener el campo, lo usamos aplicando la convención _snake case_ siendo el campo **`nombre_campo`**.

Por ejemplo, en la ruta `web.php`, usamos

```php
Route::get('posts', function () {
    // $posts = Post::all(); # Obtengo todos los posts
    $posts = Post::get();

    foreach ($posts as $post){
        // Como lleva varios niveles, se encierran entre llaves
        echo "
        $post->id
        <strong>{$post->user->get_name}</strong>
        $post->title <br>";
    }
});
```

La manipulación de los campos se realiza en los archivos del modelo, que se encuentran en la carpeta **app/Models/**
