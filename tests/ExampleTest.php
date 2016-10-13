<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test()
    {
        $this->json('GET', 'api/test', ['name' => 'Sally'])
            ->seeJsonEquals([
                'result' => true
            ]);
        $this->assertTrue(true);
    }
}
