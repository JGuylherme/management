<?php

namespace Tests\Unit;

use App\Http\Controllers\RoleController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;
use Mockery;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Artisan;

/**
 * Class StoreMethodTest
 *
 * Unit tests for the store method of the RoleController.
 */
class StoreMethodTest extends TestCase
{
    /**
     * Set up the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
        $app = require __DIR__ . '/../../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        Facade::setFacadeApplication($app);

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        Artisan::call('migrate');
    }

    /**
     * Tear down the test environment.
     */
    public function tearDown(): void
    {
        Artisan::call('migrate:rollback');

        Mockery::close();
        restore_error_handler();
        restore_exception_handler();
        parent::tearDown();
    }

    /**
     * Test that the store method creates a new role.
     *
     * @return void
     */
    public function test_store_method_creates_new_role()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturnUsing(function ($arg) {
            $validator = Validator::make([
                'code' => 'ABC1234',
                'name' => 'Test Role',
            ], $arg);
            $validator->passes();
            return $validator;
        });
        $request->shouldReceive('all')->andReturn([
            'code' => 'ABC1234',
            'name' => 'Test Role',
        ]);

        $roleController = new RoleController();
        $response = $roleController->store($request);
    
        $request->shouldHaveReceived('validate', function ($arg) {
            self::assertEquals([
                'code' => 'required|string|unique:roles,code|regex:/^[A-Za-z]{3}[0-9]{4}$/',
                'name' => 'required|string|max:255',
            ], $arg);
            return true;
        })->once();

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('roles.index'), $response->headers->get('Location'));
        $this->assertEquals('Role created successfully!', session('success'));
    }

    /**
     * Test that the store method fails to create a new role with invalid data.
     *
     * @return void
     */
    public function test_store_method_creates_new_role_fails()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturnUsing(function ($arg) {
            $validator = Validator::make([
                'code' => 'INVALID_CODE',
                'name' => '',
            ], $arg);
            $validator->fails();
            throw new \Illuminate\Validation\ValidationException($validator);
        });
        $request->shouldReceive('all')->andReturn([
            'code' => 'INVALID_CODE',
            'name' => '',
        ]);

        $roleController = new RoleController();

        try {
            $roleController->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            $this->assertEquals('The code field format is invalid.', $errors->first('code'));
            $this->assertEquals('The name field is required.', $errors->first('name'));
            $this->assertTrue(true);
            throw $e;
        }
    }

     /**
     * Test that the store method fails to create a new role with duplicated data.
     *
     * @return void
     */
    public function test_store_method_creates_new_role_fails_duplicated()
    {
        Role::create([
            'code' => 'ABC0010',
            'name' => 'Existing Role',
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturnUsing(function ($arg) {
            $validator = Validator::make([
                'code' => 'ABC0010',
                'name' => 'DUPLICADO',
            ], $arg);
            $validator->fails();
            throw new \Illuminate\Validation\ValidationException($validator);
        });
        $request->shouldReceive('all')->andReturn([
            'code' => 'ABC0010',
            'name' => 'DUPLICADO',
        ]);

        $roleController = new RoleController();

        try {
            $roleController->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            $this->assertEquals('The code has already been taken.', $errors->first('code'));
            $this->assertTrue(true);
            throw $e;
        }
    }

    /**
     * Test that the store method fails to create a new role with missing data.
     *
     * @return void
     */
    public function test_store_method_fails_with_missing_data()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturnUsing(function ($arg) {
            $validator = Validator::make([
                'code' => '',
                'name' => '',
            ], $arg);
            $validator->fails();
            throw new \Illuminate\Validation\ValidationException($validator);
        });
        $request->shouldReceive('all')->andReturn([
            'code' => '',
            'name' => '',
        ]);

        $roleController = new RoleController();

        try {
            $roleController->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            $this->assertEquals('The code field is required.', $errors->first('code'));
            $this->assertEquals('The name field is required.', $errors->first('name'));
            $this->assertTrue(true);
            throw $e;
        }
    }

    /**
     * Test that the store method fails to create a new role with too long data.
     *
     * @return void
     */
    public function test_store_method_fails_with_too_long_data()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturnUsing(function ($arg) {
            $validator = Validator::make([
                'code' => 'ABC123456789',
                'name' => str_repeat('A', 256),
            ], $arg);
            $validator->fails();
            throw new \Illuminate\Validation\ValidationException($validator);
        });
        $request->shouldReceive('all')->andReturn([
            'code' => 'ABC123456789',
            'name' => str_repeat('A', 256),
        ]);

        $roleController = new RoleController();

        try {
            $roleController->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            $this->assertEquals('The code field format is invalid.', $errors->first('code'));
            $this->assertEquals('The name field must not be greater than 255 characters.', $errors->first('name'));
            $this->assertTrue(true);
            throw $e;
        }
    }

    /**
     * Test that the store method fails to create a new role with invalid format.
     *
     * @return void
     */
    public function test_store_method_fails_with_invalid_format()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturnUsing(function ($arg) {
            $validator = Validator::make([
                'code' => '1234ABC',
                'name' => 'Test Role',
            ], $arg);
            $validator->fails();
            throw new \Illuminate\Validation\ValidationException($validator);
        });
        $request->shouldReceive('all')->andReturn([
            'code' => '1234ABC',
            'name' => 'Test Role',
        ]);

        $roleController = new RoleController();

        try {
            $roleController->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            $this->assertEquals('The code field format is invalid.', $errors->first('code'));
            $this->assertTrue(true);
            throw $e;
        }
    }
}
