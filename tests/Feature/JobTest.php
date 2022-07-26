<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobTest extends TestCase
{
    /**
     * Test error create job with user unauthenticated, wait status 401.
     *
     * @return void
     */
    public function test_error_crete_job_unauthenticated()
    {
        $job = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 0,
            "status" => true
        ];

        $response = $this->postJson('/api/v1/jobs/create', $job);
        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthenticated.'
                    ]);
    }

    /**
     * Test error create job with user unauthenticated, wait status 401.
     *
     * @return void
     */
    public function test_error_crete_job_unauthorized()
    {
        $user = User::factory()->create(['type' => 1]);
        $token = $user->createToken('API Token')->plainTextToken;
        
        $job = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 1,
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson('/api/v1/jobs/create', $job);

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthorized.'
                    ]);
    }

    /**
     * Test error create job title required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_job_title_required()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = [
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 0,
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson('/api/v1/jobs/create', $job);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The title field is required.'
                    ]);
    }
    
    /**
     * Test error create job description required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_job_description_required()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = [
            "title" => "Desenvolvedor Backend",
            "type" => 0,
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson('/api/v1/jobs/create', $job);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The description field is required.'
                    ]);
    }

    /**
     * Test error create job type required, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_job_type_required()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson('/api/v1/jobs/create', $job);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The type field is required.'
                    ]);
    }
    /**
     * Test error create job type its_not_numerical, wait status 422.
     *
     * @return void
     */
    public function test_error_crete_job_type_its_not_numerical()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 'sdfsddf',
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson('/api/v1/jobs/create', $job);

        $response->assertStatus(422)
                    ->assertJson([
                        'message' => 'The type must be a number.'
                    ]);
    }
    
    /**
     * Test success create job , wait status 200.
     *
     * @return void
     */
    public function test_success_crete_job()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 0,
            "status" => true
        ];
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson('/api/v1/jobs/create', $job);

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Successful registered job!'
                    ]);
    }

    /**
     * Test error show job with user unauthenticated, wait status 401.
     *
     * @return void
     */
    public function test_error_show_job_unauthenticated()
    {
        $id = '2a39171c-9196-4b3c-9cb3-0000000000';

        $response = $this->getJson("/api/v1/jobs/show/{$id}");

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthenticated.'
                    ]);
    }
    /**
     * Test error show job 404, wait status 404.
     *
     * @return void
     */
    public function test_error_show_job_404()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $id = '2a39171c-9196-4b3c-9cb3-0000000000';

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->getJson("/api/v1/jobs/show/{$id}");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'Job not found!'
                    ]);
    }
    /**
     * Test success show job, wait status 200.
     *
     * @return void
     */
    public function test_success_show_job()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = Job::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->getJson("/api/v1/jobs/show/{$job->id}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success'
                    ]);
    }

    /**
     * Test error update job unauthenticated, wait status 401.
     *
     * @return void
     */
    public function test_error_update_job_unauthenticated()
    {
        $job = Job::factory()->create();
        $id = $job->id;
        
        $inputs = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 1,
            "status" => true
        ];

        $response = $this->putJson("/api/v1/jobs/update/{$id}", $inputs);
        //dd( $response);
        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthenticated.'
                    ]);
    }

    /**
     * Test error update job unauthorized, wait status 401.
     *
     * @return void
     */
    public function test_error_update_job_unauthorized()
    {
        $user = User::factory()->create(['type' => 1]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = Job::factory()->create();
        $id = $job->id;
        
        $inputs = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 1,
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->putJson("/api/v1/jobs/update/{$id}", $inputs);
        //dd( $response);
        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthorized.'
                    ]);
    }
    /**
     * Test success update job , wait status 200.
     *
     * @return void
     */
    public function test_success_update_job()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = Job::factory()->create();
        $id = $job->id;
        
        $inputs = [
            "title" => "Desenvolvedor Backend",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "type" => 1,
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->putJson("/api/v1/jobs/update/{$id}", $inputs);
        //dd( $response);
        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Successful updated us!'
                    ]);
    }

    /**
     * Test error delete job with user unauthenticated, wait status 401.
     *
     * @return void
     */
    public function test_error_delete_job_unauthenticated()
    {
        $id = '2a39171c-9196-4b3c-9cb3-000000000';

        $response = $this->deleteJson("/api/v1/jobs/delete/{$id}");

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthenticated.'
                    ]);
    }

    /**
     * Test error delete job with user unauthorized, wait status 401.
     *
     * @return void
     */
    public function test_error_delete_job_unauthorized()
    {
        $user = User::factory()->create(['type' => 1]);
        $token = $user->createToken('API Token')->plainTextToken;

        $id = '2a39171c-9196-4b3c-9cb3-000000000';

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->deleteJson("/api/v1/jobs/delete/{$id}");

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthorized.'
                    ]);
    }
    /**
     * Test error delete job 404, wait status 404.
     *
     * @return void
     */
    public function test_error_delete_job_404()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $id = '2a39171c-9196-4b3c-9cb3-000000000';

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->deleteJson("/api/v1/jobs/delete/{$id}");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'Job not found!'
                    ]);
    }

    /**
     * Test success delete job , wait status 200.
     *
     * @return void
     */
    public function test_success_delete_job()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;

        $job = Job::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->deleteJson("/api/v1/jobs/delete/{$job->id}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                        'message' => 'Job successfully deleted!'
                    ]);
    }
    /**
     * Test error list job with user unauthenticated, wait status 200.
     *
     * @return void
     */
    public function test_success_list_job_unauthenticated()
    {
        $jobs = Job::factory()->count(40)->create();

        $response = $this->getJson("/api/v1/jobs/index");

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthenticated.',
                    ]);
    }
    /**
     * Test success list job , wait status 200.
     *
     * @return void
     */
    public function test_success_list_job()
    {
        $user = User::factory()->create(['type' => 1]);
        $token = $user->createToken('API Token')->plainTextToken;

        $jobs = Job::factory()->count(40)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->getJson("/api/v1/jobs/index");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }
    /**
     * Test error search job with unauthenticated, wait status 401.
     *
     * @return void
     */
    public function test_error_search_job_unauthenticated()
    {
        $jobs = Job::factory()->create(['title' => 'Teste Job Search']);
        $response = $this->getJson("/api/v1/jobs/search?title=Teste&description=&type=&status=&created_at=");

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthenticated.',
                    ]);
    }
    /**
     * Test success search job , wait status 200.
     *
     * @return void
     */
    public function test_success_search_job()
    {
        $user = User::factory()->create(['type' => 1]);
        $token = $user->createToken('API Token')->plainTextToken;
        
        $jobs = Job::factory()->create(['title' => 'Teste Job Search']);
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->getJson("/api/v1/jobs/search?title=Teste&description=&type=&status=&created_at=");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }

    /**
     * Test error job status update unauthenticated, wait status 401.
     *
     * @return void
     */
    public function test_error_job_status_update_unauthenticated()
    {
        $jobs = Job::factory()->create();
        
        $response = $this->postJson("/api/v1/jobs/status/1/{$jobs->id}");

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthenticated.',
                    ]);
    }
    /**
     * Test error job status update unauthorized, wait status 401.
     *
     * @return void
     */
    public function test_error_job_status_update_unauthorized()
    {
        $user = User::factory()->create(['type' => 1]);
        $token = $user->createToken('API Token')->plainTextToken;
        
        $jobs = Job::factory()->create(['title' => 'Teste Job Search']);
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson("/api/v1/jobs/status/1/{$jobs->id}");

        $response->assertStatus(401)
                    ->assertJson([
                        'message' => 'Unauthorized.',
                    ]);
    }
    
    /**
     * Test error job status update 404, wait status 404.
     *
     * @return void
     */
    public function test_error_job_status_update_404()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson("/api/v1/jobs/status/1/000000000000");

        $response->assertStatus(404)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'Job not found!'
                    ]);
    }

    /**
     * Test success job status update, wait status 200.
     *
     * @return void
     */
    public function test_success_job_status_update()
    {
        $user = User::factory()->create(['type' => 0]);
        $token = $user->createToken('API Token')->plainTextToken;
        
        $jobs = Job::factory()->create(['status' => 0]);
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson("/api/v1/jobs/status/1/{$jobs->id}");

        $response->assertStatus(200)
                    ->assertJson([
                        'status' => 'success',
                    ]);
    }
}
