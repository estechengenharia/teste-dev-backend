<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testSuccessfulIndex()
    {
        $bodyRaw = [
            "filterCollumn" => "",
            "filter" => "",
            "orderBy" => "",
            "orderDirection" => "",
            "perPage" => "20"
        ];

        $response = $this->json('GET', 'api/application', $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    "current_page",
                    "data" => [
                        '*' =>
                        [
                            "id",
                            "user_id",
                            "vacancy_id",
                            "created_at",
                            "updated_at",
                            "deleted_at",
                            "vacancy",
                            "user",
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
            "user_id" => "2",
            "vacancy_id" =>  "1",
        ];

        $response = $this->json('POST', "api/application", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }
}
