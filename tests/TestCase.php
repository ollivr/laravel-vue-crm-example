<?php

namespace Tests;

use App\Models\OAuth\OAuthClient;
use App\Repositories\OAuth\OAuthClientRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
    MigrateFreshSeedOnce;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }
}
