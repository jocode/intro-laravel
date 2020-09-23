<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * assert => Confirmacion
     */
   
    public function test_store()
    {
        // Necesitamos comprobar que se estén guardando lo datos (Método POST) a la API
        
        // $this->withoutExceptionHandling(); # Para saber los errores presentados
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', [
            'title' => 'El post de prueba'
        ]);

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => 'El post de prueba'])
            ->assertStatus(201); // OK, se ha creado un recurso

        $this->assertDatabaseHas('posts', ['title' => 'El post de prueba']);
    }

    public function test_validate_title()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', [
            'title' => ''
        ]);

        $response->assertStatus(422) // Petición bien hecha, pero imposible validar
            ->assertJsonValidationErrors('title');
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user, 'api')->json('GET', "/api/posts/$post->id");  // id = 1

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => $post->title])
            ->assertStatus(200); // OK, se ha creado un recurso
    }

    public function test_404_show()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('GET', '/api/posts/1000'); 

        $response->assertStatus(404); // No existe el post
    }

    public function test_update()
    {
        $user = User::factory()->create();
        // Creamos el post
        $post = Post::factory()->create();

        // Probamos que se actualiza
        $response = $this->actingAs($user, 'api')->json('PUT', "/api/posts/$post->id", [
            'title' => 'Nuevo'
        ]);

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => 'Nuevo'])
            ->assertStatus(200); // OK, se ha creado un recurso

        // Se revisa en la base de datos, que exita el post, con el título nuevo.
        $this->assertDatabaseHas('posts', ['title' => 'Nuevo']);
    }
    
    public function test_delete()
    {
        $user = User::factory()->create();
        // Creamos el post
        $post = Post::factory()->create();

        // Probamos que se elimina, usando el método delete
        $response = $this->actingAs($user, 'api')->json('DELETE', "/api/posts/$post->id");

        $response->assertSee(null)
            ->assertStatus(204); // Sin contenido

        // Se revisa en la base de datos, que no exista el registro
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_index(){

        $user = User::factory()->create();
        // Creamos los 5 datos
        Post::factory(5)->create();

        // Accedemos a la ruta mediante el método GET
        $response = $this->actingAs($user, 'api')->json('GET', '/api/posts');

        // Verificamos que obtenemos la estructura de json
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'created_at', 'updated_at']
            ]
        ])->assertStatus(200); // Status OK

    }

    public function test_guest(){
        $this->json('GET', '/api/posts')->assertStatus(401); // No tenemos acceso
        $this->json('POST', '/api/posts')->assertStatus(401);
        $this->json('GET', '/api/posts/1000')->assertStatus(401);
        $this->json('PUT', '/api/posts/1000')->assertStatus(401);
        $this->json('DELETE', '/api/posts/1000')->assertStatus(401);
    }

}

