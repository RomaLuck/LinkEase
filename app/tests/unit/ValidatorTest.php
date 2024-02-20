<?php

namespace unit;

use Src\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private ?Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->validator = null;
    }

    #[DataProvider('getStringList')]
    public function testString(bool $expected, mixed $string): void
    {
        $result = $this->validator::string($string, 3, 10);
        $this->assertEquals($expected, $result);
    }

    #[DataProvider('getEmailList')]
    public function testEmails(bool $expected, string $email): void
    {
        $result = $this->validator::email($email);
        $this->assertEquals($expected, $result);
    }

    public static function getStringList(): array
    {
        return [
            [false, 'a'],
            [true, 123],
            [false, '12345678910'],
            [true, 'qwerty'],
        ];
    }

    public static function getEmailList(): array
    {
        return [
            [false, 'a@'],
            [true, 'a@gmail.com'],
            [false, 'a@gmail'],
            [false, '@'],
        ];
    }
}