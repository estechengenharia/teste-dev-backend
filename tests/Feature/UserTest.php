<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test error create user email required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_user_email_required()
    {
        $user = [
            "name" => "Fulano de Tal",
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 0,
            "status" => true
        ];

        $response = $this->postJson('/api/v1/users/create', $user);
        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The email field is required.'
                    ]);
    }
        /**
     * Test error create user email exists, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_user_email_exists()
    {
        
        $user = User::factory()->create();
        $user = [
            "name" => "Fulano100 de Tal",
            "email" => $user->email,
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/users/create', $user);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The email has already been taken.'
                    ]);
    }
    /**
     * Test error create user email required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_user_password_required()
    {
        $user = [
            "name" => "José da Silva",
            "email" => "jose@gmail.com",
            "password_confirmation" => "password",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/users/create', $user);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The password field is required.'
                    ]);
    }
    /**
     * Test error create user password_confirmation required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_user_password_confirmation_required()
    {
        $user = [
            "name" => "Fulano2 de Tal",
            "email" => "fulano2@gmail.com",
            "password" => "password",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/users/create', $user);
        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The password confirmation does not match.'
                    ]);
    }

    /**
     * Test error create user password confirmation does not match, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_user_password_not_match()
    {
        $user = [
            "name" => "Fulano3 de Tal",
            "email" => "fulano3@gmail.com",
            "password" => "password",
            "password_confirmation" => "sdfsdfs",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/users/create', $user);
        
        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The password confirmation does not match.'
                    ]);
    }

    /**
     * Test error create user type required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_user_type_required()
    {
        $user = [
            "name" => "Fulano3 de Tal",
            "email" => "fulano3@gmail.com",
            "password" => "password",
            "password_confirmation" => "password",
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/users/create', $user);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The type field is required.'
                    ]);
    }
    /**
     * Test error create user type its_not_numerical, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_user_type_its_not_numerical()
    {
        $user = [
            "name" => "Fulano3 de Tal",
            "email" => "fulano3@gmail.com",
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 'sadd',
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/users/create', $user);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The type must be a number.'
                    ]);
    }
    
    /**
     * Test success create user , wait status 200.
     *
     * @return void
     */
    public function test_success_crete_user()
    {
        
        $user = [
            "name" => fake()->name(),
            "email" => fake()->safeEmail(),
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/users/create', $user);

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Successful registered user!'
                    ]);
    }

    /**
     * Test error show user 404, wait status 404.
     *
     * @return void
     */
    public function test_error_show_user_404()
    {
        $id = '2a39171c-9196-4b3c-9cb3-0000000000';

        $response = $this->getJson("/api/v1/users/show/{$id}");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'User not found!'
                    ]);
    }
    /**
     * Test success show user, wait status 200.
     *
     * @return void
     */
    public function test_success_show_user()
    {
        
        $user = User::factory()->create();
        $id = $user->id;

        $response = $this->getJson("/api/v1/users/show/{$id}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success'
                    ]);
    }

    /**
     * Test success update user , wait status 200.
     *
     * @return void
     */
    public function test_success_update_user()
    {
        
        $user = User::factory()->create();
        $id = $user->id;
        
        $inputs = [
            "name" => fake()->name(),
            "email" => $user->email,
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->putJson("/api/v1/users/update/{$id}", $inputs);
        
        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Successful updated us!'
                    ]);
    }

    /**
     * Test success delete user , wait status 200.
     *
     * @return void
     */
    public function test_success_delete_user_404()
    {
        $id = '2a39171c-9196-4b3c-9cb3-000000000';

        $response = $this->deleteJson("/api/v1/users/delete/{$id}");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'User not found!'
                    ]);
    }
    /**
     * Test success delete user , wait status 200.
     *
     * @return void
     */
    public function test_success_delete_user()
    {
        //User::truncate();
        $user = User::factory()->create();
        $id =  $user->id;

        $response = $this->deleteJson("/api/v1/users/delete/{$id}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'User successfully deleted!'
                    ]);
    }
    /**
     * Test success list user , wait status 200.
     *
     * @return void
     */
    public function test_success_list_user()
    {
        //User::truncate();
        $users = User::factory()->count(40)->create();

        $response = $this->getJson("/api/v1/users/index");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }
    /**
     * Test success search user , wait status 200.
     *
     * @return void
     */
    public function test_success_search_user()
    {
        //User::truncate();
        $users = User::factory()->create(['name' => 'User Test Search']);
        $parameter = "Test";
        $response = $this->getJson("/api/v1/users/search?parameter={$parameter}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }
    /**
     * Test error search user , wait status 404.
     *
     * @return void
     */
    public function test_error_search_user_404()
    {
        $parameter = "13232";
        $response = $this->getJson("/api/v1/users/search?parameter={$parameter}");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'User not found!'
                    ]);
    }
}
