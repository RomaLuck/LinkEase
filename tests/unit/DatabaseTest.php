<?php

namespace unit;

use Doctrine\DBAL\Exception;
use Src\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testConnection(): void
    {
        $entityManager = Database\EntityManagerFactory::create();

        try {
            $db = $entityManager->getConnection();
            $db->executeQuery('SELECT 1');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("Can not connect to: {$e->getMessage()}");
        }
    }
}