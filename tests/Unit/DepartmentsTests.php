<?php

namespace Tests\Unit;


use Str;
use Hash;
use Faker\Factory;
use Tests\TestCase;
use App\Models\User;

class DepartmentsTests extends TestCase
{
    /**
     * Test get departments
     *
     * @return void
     */
    public function testDepartments()
    {
        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $this->actingAs($adminUser)
            ->json('GET', '/api/admin/departments', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['departments']);
    }

    /**
     * Test create user
     *
     * @return void
     */
    public function testCreateDepartment()
    {
        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $faker = \Faker\Factory::create();

        $body = [
            'name' => $faker->name,
            'description' => $faker->text,
            'logo'        => $faker->image(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'logo'), 640, 480),
            'users'       => []
        ];

        $this->actingAs($adminUser)
            ->json('POST', '/api/admin/departments', $body, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['department']);
    }

    /**
     * Test create user with wrong password
     *
     * @return void
     */
    public function testCreateWrongDepartment()
    {

        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $faker = \Faker\Factory::create();

        $body = [
            'name' => $faker->name,
            'description' => $faker->text,
            'logo'        => '',
            'users'       => []
        ];

        $this->actingAs($adminUser)
            ->json('POST', '/api/admin/departments', $body, ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    /**
     * Test delete user
     *
     * @return void
     */
    public function testDeleteDepartment()
    {
        $this->withoutMiddleware();

        $adminUser = User::findOrFail(1);

        $faker = \Faker\Factory::create();

        $body = [
            'name' => $faker->name,
            'description' => $faker->text,
            'logo'        => $faker->image(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'logo'), 640, 480),
            'users'       => []
        ];

        $response = $this->actingAs($adminUser)
            ->json('POST', '/api/admin/departments', $body, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['department'])
            ->decodeResponseJson();

        $this->actingAs($adminUser)
            ->json('DELETE', '/api/admin/departments/' . $response['department']['id'], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
