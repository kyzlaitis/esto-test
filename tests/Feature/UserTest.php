<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_created_by_admin()
    {
        $this->actingAs($user = factory(User::class)->create(['permission' => true]), 'api');
        $this->assertEquals(true, $user->permission);

        $response = $this->postJson(
            '/api/users',
            [
                'data' => [
                    'type'       => 'users',
                    'attributes' => [
                        'name'       => 'testName',
                        'email'      => 'email@gmail.com',
                        'permission' => true,
                    ],
                ],
            ]
        );

        $createdUser = $response->decodeResponseJson();
        $this->assertEquals('testName', $createdUser['data']['attributes']['name']);
        $this->assertEquals('email@gmail.com', $createdUser['data']['attributes']['email']);
        $this->assertEquals(true, $createdUser['data']['attributes']['permission']);

        $response->assertStatus(201)->assertJson(
            [
                'data' => [
                    'type'       => 'users',
                    'user_id'    => $createdUser['data']['user_id'],
                    'attributes' => [
                        'name'       => $createdUser['data']['attributes']['name'],
                        'email'      => $createdUser['data']['attributes']['email'],
                        'permission' => $createdUser['data']['attributes']['permission'],
                    ],
                ],
            ]
        );
    }

    /** @test */
    public function a_user_without_permission_cannot_create_users()
    {
        $this->actingAs($user = factory(User::class)->create(['permission' => 0]), 'api');

        $response = $this->postJson(
            '/api/users',
            [
                'data' => [
                    'type'       => 'users',
                    'attributes' => [
                        'name'       => 'testName',
                        'email'      => 'email@gmail.com',
                        'permission' => true,
                    ],
                ],
            ]
        );

        $response->assertStatus(401);
    }

    /** @test */
    public function an_admin_user_cannot_create_user_with_invalid_data()
    {
        $this->actingAs($user = factory(User::class)->create(['permission' => true]), 'api');

        $response = $this->postJson(
            '/api/users',
            [
                'data' => [
                    'type'       => 'users',
                    'attributes' => [
                        'name'       => 'testName',
                        'email'      => 'email',
                        'permission' => 'yes',
                    ],
                ],
            ]
        );

        $response->assertStatus(422)->assertJson(
            [
                'errors'  => [
                    'data.attributes.email'      => [
                        'The email address must be a valid email address.',
                    ],
                    'data.attributes.permission' => [
                        'The permission field must be true or false.',
                    ],
                ],
                'message' => 'The given data was invalid.',
            ]
        );


        $sameUserNameRequestData                  = [
            'data' => [
                'type'       => 'users',
                'attributes' => [
                    'name'       => 'testName',
                    'email'      => 'email@gmail.com',
                    'permission' => true,
                ],
            ],
        ];

        $sameUserNameResponse = $this->postJson(
            '/api/users',
            $sameUserNameRequestData
        );
        $sameUserDataResponse = $this->postJson(
            '/api/users',
            $sameUserNameRequestData
        );

        $sameUserDataResponse->assertStatus(422)->assertJson(
            [
                'errors' => [
                    'data.attributes.name'      => [
                        'The name has already been taken.',
                    ],
                ],
                'message' => 'The given data was invalid.'
            ]
        );
    }
}
