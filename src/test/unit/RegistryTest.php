<?php
namespace Tests\unit;
use App\Infra\DI\Registry;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    public function testGet()
    {
        $nullInstance = Registry::getInstance()->get('test');
        $this->assertNull($nullInstance);
    }
}