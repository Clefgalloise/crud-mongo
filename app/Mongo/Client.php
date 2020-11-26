<?php

declare(strict_types=1);

namespace App\Mongo;

use Illuminate\Config\Repository;
use MongoDB\Client as MongoClient;

/**
 * Class Client
 *
 * @package App\Mongo
 */
class Client
{
    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var MongoClient
     */
    protected $client;

    /**
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * @return MongoClient
     */
    public function client(): MongoClient
    {
        if ($this->client === null) {
            return $this->client = $this->getDefaultClient();
        }

        return $this->client;
    }

    /**
     * @return MongoClient
     */
    protected function getDefaultClient(): MongoClient
    {
        $uri = 'mongodb://';

        if ($username = $this->config->get('mongo.username')) {
            $uri .= $username;
        }

        if ($password = $this->config->get('mongo.password')) {
            $uri .= ':' . $password;
        }

        if ($username || $password) {
            $uri .= '@';
        }

        $uri .= $this->config->get('mongo.host');
        $uri .= ':' . $this->config->get('mongo.port');

        return new MongoClient($uri);
    }
}
