<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use App\Ship\Parents\Factories\UserFactory;
use App\Ship\Parents\Models\Role;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel as ApiatoConsoleKernel;
use Illuminate\Foundation\Application;

abstract class TestCase extends LaravelTestCase
{
    /**
     * Setup the test environment, before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Reset the test environment, after each test.
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        $this->baseUrl = env('API_FULL_URL'); // this reads the value from `phpunit.xml` during testing

        $app = require __DIR__ . '/../../../../../bootstrap/app.php';

        $app->make(ApiatoConsoleKernel::class)->bootstrap();

        // create instance of faker and make it available in all tests
        $this->faker = $app->make(Generator::class);

        return $app;
    }

    public function asAdmin(UserFactory $userFactory): UserFactory
    {
        return $userFactory->hasAttached(
            Role::query()->whereName('admin')->first()
        );
    }

    public function asGuest(UserFactory $userFactory): UserFactory
    {
        return $userFactory->hasAttached(
            Role::query()->whereName('guest')->first()
        );
    }

    public function asCommonCustomer(UserFactory $userFactory): UserFactory
    {
        return $userFactory->hasAttached(
            Role::query()->whereName('common_customer')->first()
        );
    }

    public function asPrivilegedCustomer(UserFactory $userFactory): UserFactory
    {
        return $userFactory->hasAttached(
            Role::query()->whereName('privileged_customer')->first()
        );
    }
}
