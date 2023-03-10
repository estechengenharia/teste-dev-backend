<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
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

        $user = User::find(1);

        $response = $this->actingAs($user)->json('GET', 'api/application', $bodyRaw, ['Accept' => 'application/json']);

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

    public function testSuccessfulShow()
    {
        $bodyRaw = [];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('GET', 'api/application/1', $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                "id",
                "user_id",
                "vacancy_id",
                "created_at",
                "updated_at",
                "deleted_at",
                "vacancy",
                "user",
            ]);
    }

    public function testSuccessfulStore()
    {

        $bodyRaw = [
            "user_id" => "2",
            "vacancy_id" =>  "1",
        ];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('POST', "api/application", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }

    public function testSuccessfulUpdate()
    {

        $bodyRaw = [
            "user_id" => "2",
            "vacancy_id" =>  "2",
        ];

        $user = User::find(1);

        $response = $this->actingAs($user)->json('PUT', "api/application/1", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }

    public function testSuccessfulDestroy()
    {

        $bodyRaw = [];

        $lastApplicationId = Application::latest()->first()->id;

        $user = User::find(1);

        $response = $this->actingAs($user)->json('DELETE', "api/application/$lastApplicationId", $bodyRaw, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([  
                'success',
                'message'
            ]);

    }


}
