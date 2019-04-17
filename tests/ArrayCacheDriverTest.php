<?php

namespace Anonym\Components\Cache\tests;


use Anonym\Components\Cache\ArrayCacheDriver;
use PHPUnit\Framework\TestCase;

class ArrayCacheDriverTest extends TestCase
{

    /**
     * @var ArrayCacheDriver
     */
    private $instance;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new ArrayCacheDriver();
    }

    /**
     *
     */
    public function testSetShouldPass()
    {
        $response = $this->instance->set('key', [
            'response' => 'data'
        ]);

        $this->assertInstanceOf(ArrayCacheDriver::class, $response);
    }

    /**
     *  this test should
     */
    public function testGetShouldFail()
    {
        $this->instance->set('fail', [
            'response' => 'data'
        ], 1);

        sleep(2);

        $data = $this->instance->get('fail');

        $this->assertFalse($data);

    }
    /**
     *
     */
    public function testGetShouldPass()
    {
        $data = $this->instance->get('key');


        $this->assertIsArray($data);
        $this->assertArrayHasKey('response', $data);

    }



}
