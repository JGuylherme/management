<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that a role can be registered successfully.
     *
     * @return void
     */
    public function test_role_can_be_registered()
    {
        $response = $this->post('/roles', [
            'code' => 'ABC1234',
            'name' => 'Test Role',
        ]);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success', 'Role created successfully!');

        $this->assertDatabaseHas('roles', [
            'code' => 'ABC1234',
            'name' => 'Test Role',
        ]);
    }

    /**
     * Test that role registration fails with invalid data.
     *
     * @return void
     */
    public function test_role_registration_fails_with_invalid_data()
    {
        $response = $this->post('/roles', [
            'code' => 'INVALID_CODE',
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['code', 'name']);
    }

    /**
     * Test that role registration fails with duplicated data.
     *
     * @return void
     */
    public function test_role_registration_fails_with_duplicated_data()
    {
        Role::create([
            'code' => 'ABC0010',
            'name' => 'Existing Role',
        ]);

        $response = $this->post('/roles', [
            'code' => 'ABC0010',
            'name' => 'Duplicated Role',
        ]);

        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test that role registration fails with missing data.
     *
     * @return void
     */
    public function test_role_registration_fails_with_missing_data()
    {
        $response = $this->post('/roles', [
            'code' => '',
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['code', 'name']);
    }

    /**
     * Test that role registration fails with too long data.
     *
     * @return void
     */
    public function test_role_registration_fails_with_too_long_data()
    {
        $response = $this->post('/roles', [
            'code' => 'ABC1234567890',
            'name' => str_repeat('A', 256),
        ]);

        $response->assertSessionHasErrors(['code', 'name']);
    }

    /**
     * Test that role registration fails with invalid format.
     *
     * @return void
     */
    public function test_role_registration_fails_with_invalid_format()
    {
        $response = $this->post('/roles', [
            'code' => '1234ABC',
            'name' => 'Test Role',
        ]);

        $response->assertSessionHasErrors(['code']);
    }
}