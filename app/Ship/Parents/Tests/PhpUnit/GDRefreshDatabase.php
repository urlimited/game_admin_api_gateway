<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use Illuminate\Foundation\Testing\RefreshDatabase;

trait GDRefreshDatabase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as public parentRefreshDatabase;
        RefreshDatabase::usingInMemoryDatabase as protected parentUsingInMemoryDatabase;
        RefreshDatabase::refreshInMemoryDatabase as protected parentRefreshInMemoryDatabase;
        RefreshDatabase::migrateUsing as protected parentMigrateUsing;
        RefreshDatabase::refreshTestDatabase as protected parentRefreshTestDatabase;
        RefreshDatabase::beginDatabaseTransaction as public parentBeginDatabaseTransaction;
        RefreshDatabase::connectionsToTransact as protected parentConnectionsToTransact;
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function refreshDatabase()
    {
        $this->parentRefreshDatabase();
    }

    /**
     * Determine if an in-memory database is being used.
     *
     * @return bool
     */
    protected function usingInMemoryDatabase(): bool
    {
        return $this->parentUsingInMemoryDatabase();
    }

    /**
     * Refresh the in-memory database.
     *
     * @return void
     */
    protected function refreshInMemoryDatabase(): void
    {
        $this->parentRefreshInMemoryDatabase();
    }

    /**
     * The parameters that should be used when running "migrate".
     *
     * @return array
     */
    protected function migrateUsing(): array
    {
        return $this->parentMigrateUsing();
    }

    /**
     * Refresh a conventional test database.
     *
     * @return void
     */
    protected function refreshTestDatabase(): void
    {
        $this->parentRefreshTestDatabase();
    }

    /**
     * Begin a database transaction on the testing database.
     *
     * @return void
     */
    public function beginDatabaseTransaction(): void
    {
        $this->parentBeginDatabaseTransaction();
    }

    /**
     * The database connections that should have transactions.
     *
     * @return array
     */
    protected function connectionsToTransact(): array
    {
        return $this->parentConnectionsToTransact();
    }
}
