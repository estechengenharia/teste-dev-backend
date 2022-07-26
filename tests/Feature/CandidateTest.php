<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    /**
     * Test error create candidate email required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_candidate_email_required()
    {
        $candidate = [
            "name" => "Fulano de Tal",
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 1,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The email field is required.'
                    ]);
    }

    /**
     * Test error create candidate email exists, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_candidate_email_exists()
    {
        $candidate = User::factory()->create();
        $candidate = [
            "name" => "Fulano101 de Tal",
            "email" =>  $candidate->email,
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 1,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The email has already been taken.'
                    ]);
    }
    /**
     * Test error create candidate email required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_candidate_password_required()
    {
        $candidate = [
            "name" => "José da Silva",
            "email" => "jose@gmail.com",
            "password_confirmation" => "password",
            "type" => 1,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The password field is required.'
                    ]);
    }
    /**
     * Test error create candidate password_confirmation required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_candidate_password_confirmation_required()
    {
        $candidate = [
            "name" => "Fulano2 de Tal",
            "email" => "fulano2@gmail.com",
            "password" => "password",
            "type" => 1,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);
        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The password confirmation does not match.'
                    ]);
    }

    /**
     * Test error create candidate password confirmation does not match, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_candidate_password_not_match()
    {
        $candidate = [
            "name" => "Fulano3 de Tal",
            "email" => "fulano3@gmail.com",
            "password" => "password",
            "password_confirmation" => "sdfsdfs",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);
        
        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The password confirmation does not match.'
                    ]);
    }

    /**
     * Test error create candidate type required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_candidate_type_required()
    {
        $candidate = [
            "name" => "Fulano3 de Tal",
            "email" => "fulano3@gmail.com",
            "password" => "password",
            "password_confirmation" => "password",
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The type field is required.'
                    ]);
    }

    /**
     * Test error create candidate type its_not_numerical, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_candidate_type_its_not_numerical()
    {
        $candidate = [
            "name" => "Fulano3 de Tal",
            "email" => "fulano3@gmail.com",
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 'sadd',
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The type must be a number.'
                    ]);
    }

    /**
     * Test success create candidate , wait status 200.
     *
     * @return void
     */
    public function test_success_crete_candidate()
    {
        //User::truncate();
        $candidate = [
            "name" => fake()->name(),
            "email" => fake()->safeEmail(),
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 1,
            "status" => 1
        ];

        $response = $this->postJson('/api/v1/candidates/create', $candidate);

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Successful registered candidate!'
                    ]);
    }

    /**
     * Test error show candidate 404, wait status 404.
     *
     * @return void
     */
    public function test_error_show_candidate_404()
    {
        $id = '2a39171c-9196-4b3c-9cb3-0000000000';

        $response = $this->getJson("/api/v1/candidates/show/{$id}");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'Candidate not found!'
                    ]);
    }

    /**
     * Test success show candidate, wait status 200.
     *
     * @return void
     */
    public function test_success_show_candidate()
    {
        //User::truncate();
        $candidate = User::factory()->create();
        $id = $candidate->id;

        $response = $this->getJson("/api/v1/candidates/show/{$id}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success'
                    ]);
    }

    /**
     * Test success update candidate , wait status 200.
     *
     * @return void
     */
    public function test_success_update_candidate()
    {
        //User::truncate();
        $candidate = User::factory()->create();
        
        $inputs = [
            "name" => fake()->name(),
            "email" => $candidate->email,
            "password" => "password",
            "password_confirmation" => "password",
            "type" => 0,
            "status" => 1
        ];

        $response = $this->putJson("/api/v1/candidates/update/{$candidate->id}", $inputs);
        //dd( $response);
        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Successful updated us!'
                    ]);
    }

    /**
     * Test error delete candidate , wait status 404.
     *
     * @return void
     */
    public function test_success_delete_candidate_404()
    {
        $id = '2a39171c-9196-4b3c-9cb3-000000000';

        $response = $this->deleteJson("/api/v1/candidates/delete/{$id}");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'Candidate not found!'
                    ]);
    }

    /**
     * Test success delete candidate , wait status 200.
     *
     * @return void
     */
    public function test_success_delete_candidate()
    {
        //User::truncate();
        $candidate = User::factory()->create();
        $id =  $candidate->id;

        $response = $this->deleteJson("/api/v1/candidates/delete/{$id}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Candidate successfully deleted!'
                    ]);
    }

    /**
     * Test success list candidate , wait status 200.
     *
     * @return void
     */
    public function test_success_list_candidate()
    {
        //User::truncate();
        $candidates = User::factory()->count(40)->create();

        $response = $this->getJson("/api/v1/candidates/index");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }

    /**
     * Test success search candidate , wait status 200.
     *
     * @return void
     */
    public function test_success_search_candidate()
    {
        //User::truncate();
        $candidates = User::factory()->create(['name' => 'Teste Search']);
        $response = $this->getJson("/api/v1/candidates/search?name=Teste&email=&type=&status=&created_at=");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }

    /**
     * Test success job attach candidate , wait status 200.
     *
     * @return void
     */
    public function test_success_job_attach_candidate()
    {
        $candidate = User::factory()->create();
        $jobs = Job::factory()->count(3)->create()->pluck('id')->toArray();
        
        $response = $this->postJson("/api/v1/candidates/attach-job/{$candidate->id}", $jobs);

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }
}
