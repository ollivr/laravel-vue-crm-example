<?php

namespace Tests\Unit;

use Str;
use Hash;
use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\OAuth\OAuthClient;
use App\Repositories\User\UserRepository;
use App\Repositories\OAuth\OAuthClientRepository;

class UsersTest extends TestCase
{
    /**
     * Test login
     *
     * @return void
     */
    public function testOAuthLogin()
    {
        $oauthClientId = config('auth.passport_grant_client_id');
        $clientRepository = new OAuthClientRepository(new OAuthClient());
        $client = $clientRepository->findOrFail($oauthClientId);

        $body = [
            'username' => 'admin@test.loc',
            'password' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'grant_type' => 'password',
            'scope' => '*'
        ];

        $this->json('POST', '/oauth/token', $body, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token', 'refresh_token']);

    }

    /**
     * Test wrong password
     *
     * @return void
     */
    public function testOAuthWrongLogin()
    {
        $oauthClientId = config('auth.passport_grant_client_id');
        $clientRepository = new OAuthClientRepository(new OAuthClient());
        $client = $clientRepository->findOrFail($oauthClientId);

        $body = [
            'username' => 'admin@test.loc',
            'password' => 'wrong_password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'grant_type' => 'password',
            'scope' => '*'
        ];

        $this->json('POST', '/oauth/token', $body, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJsonStructure(['error', 'error_description', 'hint', 'message'])
            ->assertJson([
                'error' => 'invalid_grant',
            ]);
    }

    /**
     * Test get users
     *
     * @return void
     */
    public function testUsers()
    {
        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $this->actingAs($adminUser)
            ->json('GET', '/api/admin/users', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['users']);
    }

    /**
     * Test create user
     *
     * @return void
     */
    public function testCreateUser()
    {
        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $faker = \Faker\Factory::create();

        $password = $faker->regexify('[A-Za-z0-9]{20}');

        $body = [
            'name' => $faker->userName,
            'email' => $faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->actingAs($adminUser)
            ->json('POST', '/api/admin/users', $body, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['user']);
    }

    /**
     * Test create user with wrong password
     *
     * @return void
     */
    public function testCreateWrongUser()
    {

        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $faker = \Faker\Factory::create();

        $password = $faker->regexify('[A-Za-z0-9]{20}');

        $body = [
            'name' => $faker->userName,
            'email' => $faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => 'wrong_password',
        ];

        $this->actingAs($adminUser)
            ->json('POST', '/api/admin/users', $body, ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    /**
     * Test delete user
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $faker = \Faker\Factory::create();

        $password = $faker->regexify('[A-Za-z0-9]{20}');

        $body = [
            'name' => $faker->userName,
            'email' => $faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->actingAs($adminUser)
            ->json('POST', '/api/admin/users', $body, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['user'])
            ->decodeResponseJson();

        $this->actingAs($adminUser)
            ->json('DELETE', '/api/admin/users/' . $response['user']['id'], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
