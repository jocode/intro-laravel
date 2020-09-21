# 4. Crear PlatziPress

## Proyecto Blog: presentación y configuración inicial

:star: Es interesante poner en prática todo lo aprendido, es allí donde realmente se puede dominar un tema.

Creamos el proyecto en Laravel usando

- **`laravel new basic`**

Ahora instalamos el paquete necesario para el Login

- **`php artisan ui bootstrap --auth`**

## CREACION DE PLATZIPRESS

1. Configuracion inicial

- `composer create-project --prefer-dist laravel/laravel basic`
- `composer require laravel/ui --dev`
- `php artisan ui bootstrap --auth`
- `npm install`
- `npm run dev`
- `php artisan make:model Post -mfc`

- `composer require cviebrock/eloquent-sluggable`

**Creamos la migracion la factory y el controller**

- `geteloquent.com||browse packages|| eloquent-slug`

- `composer require cviebrock/eloquent-sluggable`

_slug_ es la version simplificada de un string para mejor seo ej:
convertir esto
`http://example.com/post/My+Dinner+With+Andr%C3%A9+%26+Fran%C3%A7ois`
en esto
`http://example.com/post/my-dinner-with-andre-francois`

## Creación de tablas, entidades y datos de prueba

Se configura los campos que tendrá la tabla posts en **migrations**, la factory de `Post`, para crear nuevos porst y el `Database Seeder` para crear los datos de prueba.

**Sequel Pro** programa para la gestión de la base de datos.

Creamos la base de datos

Y luego ejecutamos el comando que permite crear los datos de prueba.

- **`php artisan migrate:refresh --seed`** Lo que hace es crear las tablas y llenar los datos en la tablas con lo que le hemos indicado en `DatabaseSeeder.php`

## Plantillas de trabajo y entendiendo el login

1. Crear las rutas
2. Crear el controlador

- `php artisan make:controller PageController` Sólo vamos a trabajar con 2 métodos.

3. Creamos la funcionalidad en los métodos del controlador.

4. Creamos las relaciones en los modelos

5. Configuramos las vistas

## Vista index y botones de acción

Vamos a crear el PostController para utilizarlo en la administración.

Lo que hacemos es crear el controlador dentro de una carpeta para mantener un mejor orden

- `php artisan make:controller Backend/PostController --resource --model=Post`

Lo que sea publica es recomendable dejarlo fuera de la carpeta y lo privado, la administración es bueno dejarlo dentro de bakend.

## Implementación del formulario de creación

Se crea la vista de insertar nuevo post, donde el archivo se llama `create.blade.php`

## Implementacion del guardado

Usamos el Request para realizar las validaciones de los campos del formulario

- **`php artisan make:request PosteRequest`**

Luego de crear la función de validación, vamos con el guardado de los datos al PostController

Para guardar las imágenes en las carpetas usamos la función **`store()`** de Laravel.

```php
// Image
if ($request->file('file')){
    $post->image = $request->file('file')->store('posts', 'public');
    $post->save();
}
```

En el modelo `Post` le indicamos a Laravel que vamos a recibir datos de forma masiva

```php
// Le indicamos a laravel que vamos a recibir datos de forma masiva
protected $fillable = [
    'title', 'body', 'iframe', 'image', 'user_id'
];
```

Finalmente, luego de crear el Request para la validación de los parámetros, se ha realizado el método **create()** para guardar el Post.Lo que nos queda en el controlador `PostController.php` lo siguiente

```php
public function store(PostRequest $request)
{
    // dd($request->all());

    // Función de guardado
    $post = Post::create([
        'user_id' => auth()->user()->id
    ] + $request->all() );

    // Imagen (Guardardo de la imágen, subiendo la imágen y guardar los datos.)
    if ($request->file('file')){
        $post->image = $request->file('file')->store('posts', 'public');
        $post->save();
    }

    // Retornar
    return back()->with('status', 'Creado con éxito');
}
```

## Creando la función de editar un Post

El helper que nos ayuda a recordar el dato cuando estemos validando es **`old(field_form', field_database)`**

```php
old('title', $post->title)
```

## Actualizando los Post (Método update)

Realizamos la configuración de eleiminar en el método **destroy**

Para trabajar con almacenamiento, usamos la clase Storage

- `use Illuminate\Support\Facades\Storage;`

**Eliminar registro**

```php
public function destroy(Post $post)
{
  // Eliminación de la imagen (Dentro de almacenamiento, busca en public y elimina esta imagen en la ruta indicada.)
  Storage::disk('public')->delete($post->image);

  // Eliminación del registro en la base de datos
  $post->delete();

  return back()->with('status', 'Eliminado con éxito');
}
```

**Actualizar los datos**

```php
public function update(PostRequest $request, Post $post)
{
    // se edita solo los campos si file
    $post->update([
        'title' => $request->title,
        'body' => $request->body,
        'iframe' => $request->iframe
    ]);

    // Eliminamos la imagen anterior y guardamos la nueva
    if ($request->file('file')) {
        // Eliminamos la imagen anterior
        Storage::disk('public')->delete($post->image);

        // Guardamos la nueva imágen
        $post->image = $request->file('file')->store('posts', 'public');
        $post->save();
    }

      // Retornar
    return back()->with('status', 'Actualizado con éxito');
}
```

## Integrando contenido audiovisual

Para imprimir el html con blade, debemos imprimirlo usando **`{!! !!}`**

```html
{!! $post->iframe !!}
```

Creamos el enlace simbólico usando. Lo que permire crear un enlace simbolico, en este caso, la imagen original está dentro de `public/storage/posts`, pero lo muestra desde `storage/posts`

- **`php artisan storage:link`**
