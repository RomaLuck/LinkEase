<?php

namespace unit;

use Core\Container;
use Core\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testConnection(): void
    {
        $db = (new Container())->get(Database::class);
        try {
            $db->query('SELECT 1');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail("Can not connect to: {$e->getMessage()}");
        }
    }
}