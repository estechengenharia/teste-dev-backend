<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
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

        $response = $this->json('GET', 'api/user', $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    "current_page",
                    "data" => [
                        '*' =>
                        [
                            "id",
                            "name",
                            "cpf",
                            "professional_resume",
                            "user_type",
                            "email",
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
            "cpf" => "99999999999",
            "user_type" =>  "candidato",
            "email" => "teste@email.com",
            "professional_resume" => "Lorem impsum"
        ];

        $response = $this->json('POST', "api/user", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }
}
