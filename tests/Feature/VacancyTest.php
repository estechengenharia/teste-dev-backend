<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VacancyTest extends TestCase
{
    public function testSuccessfulIndex()
    {
        $bodyRaw = [
            "filterCollumn" => "name",
            "filter" => "",
            "orderBy" => "name",
            "orderDirection" => "asc",
            "perPage" => "20"
        ];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('GET', 'api/vacancy', $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    "current_page",
                    "data" => [
                        '*' =>
                        [
                            "id",
                            "name",
                            "description",
                            "vacancy_type",
                            "user_id",
                            "opened",
                            "created_at",
                            "updated_at",
                            "deleted_at",
                        ]
                    ],
                    "first_page_url",
                    "from",
                    "last_page",
                    "last_page_url",
                    "links",
                    "next_page_url",
                    "path",
                    "per_page",
                    "prev_page_url",
                    "to",
                    "total"
            ]);
    }

    public function testSuccessfulShow()
    {
        $bodyRaw = [];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('GET', 'api/vacancy/1', $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "description",
                "vacancy_type",
                "user_id",
                "opened",
                "created_at",
                "updated_at",
                "deleted_at",
            ]);
    }

    public function testSuccessfulStore()
    {

        $bodyRaw = [
            "name" => "teste",
            "user_id" => "1",
            "vacancy_type" =>  "clt",
            "description" => "Lorem impsum"
        ];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('POST', "api/vacancy", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }
    
    public function testFailStore()
    {

        $bodyRaw = [
            "name" => "teste",
            "user_id" => "2",
            "vacancy_type" =>  "clt",
            "description" => "Lorem impsum"
        ];

        $user = User::find(1);
        
        $response = $this->actingAs($user)->json('POST', "api/vacancy", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(400)
            ->assertJsonStructure([  
                'error',
                'message'
            ]);

    }

    public function testSuccessfulUpdate()
    {

        $bodyRaw = [
            "name" => "teste pós u´date",
            "user_id" => "1",
            "vacancy_type" =>  "pj",
            "description" => "Lorem impsum"
        ];

        $lastVacancyId = Vacancy::latest()->first()->id;

        $user = User::find(1);

        $response = $this->actingAs($user)->json('PUT', "api/vacancy/$lastVacancyId", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }

    public function testSuccessfulDestroy()
    {

        $bodyRaw = [];

        $lastVacancyId = Vacancy::latest()->first()->id;

        $user = User::find(1);

        $response = $this->actingAs($user)->json('DELETE', "api/vacancy/$lastVacancyId", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }
}
