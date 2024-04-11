<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'users' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    public function test_user()
    {
        $response = $this->get('/api/users/1');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at'
        ]);
    }

    public function test_user_not_found()
    {
        $response = $this->get('/api/users/110');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_update_user_not_found()
    {
        $response = $this->get('/api/users/111');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_upate_user()
    {
        $response = $this->patch('/api/users/1', ['name' => 'John Doe']);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at'
        ]);

        $response->assertJsonPath('name', 'John Doe');
    }

    public function test_user_user_not_found()
    {
        $response = $this->get('/api/users/200');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_user()
    {
        $response = $this->delete('/api/users/2');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at'
        ]);
    }
}
