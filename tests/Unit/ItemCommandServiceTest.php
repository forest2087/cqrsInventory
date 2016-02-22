<?php

use App\Item;
use App\Services\ItemCommandService;
use Illuminate\Http\Request;
use Mockery as m;

class ItemCommandServiceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function mock($class)
    {
        $mock = m::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    public function test_store()
    {

        $testRequest = Request::create('/api/v1/item', 'POST', [
            'label'     => 'testLabel',
            'type'      => 'testType',
            'event'     => 'add',
            'expire_at' => '2099-12-12'
        ]);

        $this->mock = $this->mock('App\Item');
        $this->mock->shouldReceive('construct->create')->andReturn(true);

        $service = new ItemCommandService($this->mock);
//var_dump($service);

        $result = $service->store($testRequest);

        $this->assertTrue($result);
    }
}
