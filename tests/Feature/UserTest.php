<?php

namespace Tests\Feature;

use App\Models\User;
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

        $user = User::find(1);

        $response = $this->actingAs($user)->json('GET', 'api/user', $bodyRaw, ['Accept' => 'application/json']);

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

    public function testSuccessfulShow()
    {
        $bodyRaw = [
            "filterCollumn" => "name",
            "filter" => "",
            "orderBy" => "name",
            "orderDirection" => "asc",
            "perPage" => "20"
        ];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('GET', 'api/user/1', $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "cpf",
                "professional_resume",
                "user_type",
                "email",
                "created_at",
                "updated_at",
                "deleted_at",    
            ]);
    }


    public function testSuccessfulStore()
    {

        $bodyRaw = [
            "name" => "teste",
            "cpf" => "99999999999",
            "user_type" =>  "candidato",
            "email" => "teste@email.com",
            "professional_resume" => "Lorem impsum",
            "senha" => "123"
        ];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('POST', "api/user", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);
    }

    public function testSuccessfulUpdate()
    {
        

        $bodyRaw = [
            "name" => "Recrutador Teste Pós Update",
            "cpf" => "99999999999",
            "user_type" =>  "candidato",
            "email" => "teste@email.com",
            "professional_resume" => "Lorem impsum pós update teste",
            "senha" => "123"
        ];

        $user = User::find(1);

        $lastUserId = User::latest()->first()->id;

        $response = $this->actingAs($user)->json('PUT', "api/user/$lastUserId", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);
    }

    public function testSuccessfulDestroy()
    {

        $bodyRaw = [];

        $lastUserId = User::latest()->first()->id;

        $user = User::find(1);

        $response = $this->actingAs($user)->json('DELETE', "api/user/$lastUserId", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }
}
