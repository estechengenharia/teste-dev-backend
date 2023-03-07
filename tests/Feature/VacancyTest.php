<?php

namespace Tests\Feature;

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

        $response = $this->json('GET', 'api/vacancy', $bodyRaw, ['Accept' => 'application/json']);

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

    public function testSuccessfulStore()
    {

        $bodyRaw = [
            "name" => "teste",
            "user_id" => "1",
            "vacancy_type" =>  "clt",
            "description" => "Lorem impsum"
        ];

        $response = $this->json('POST', "api/vacancy", $bodyRaw, ['Accept' => 'application/json']);

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

        $response = $this->json('POST', "api/vacancy", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(400)
            ->assertJsonStructure([  
                'error',
                'message'
            ]);

    }
}
