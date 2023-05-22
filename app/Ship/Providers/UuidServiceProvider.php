<?php

namespace App\Ship\Providers;

use App\Ship\Libs\OptimisedUuid\MySqlGrammar;
use Exception;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Grammars\MySqlGrammar as IlluminateMySqlGrammar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class UuidServiceProvider extends ServiceProvider
{
    /**
     * @throws Exception
     */
    public function boot()
    {
        /** @var Connection $connection */
        $connection = app('db')->connection();

        $connection->setSchemaGrammar($this->createGrammarFromConnection($connection));

        $this->optimizeUuids();

        Blueprint::macro('binaryUuid', function ($column) {
            return $this->addColumn('binaryUuid', $column);
        });
    }

    /**
     * @throws Exception
     */
    protected function createGrammarFromConnection(Connection $connection): Grammar
    {
        $queryGrammar = $connection->getQueryGrammar();

        $queryGrammarClass = get_class($queryGrammar);

        if ($queryGrammarClass != IlluminateMySqlGrammar::class) {
            throw new Exception("There current grammar `$queryGrammarClass` doesn't support binary uuids. Only  MySql connection is supported.");
        }

        $grammar = new MySqlGrammar();

        $grammar->setTablePrefix($queryGrammar->getTablePrefix());

        return $grammar;
    }

    protected function optimizeUuids()
    {
        $factory = new UuidFactory();

        $codec = new OrderedTimeCodec($factory->getUuidBuilder());

        $factory->setCodec($codec);

        Uuid::setFactory($factory);
    }
}
