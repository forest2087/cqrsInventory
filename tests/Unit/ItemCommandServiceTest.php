<?php

use App\Item;
use App\Services\ItemCommandService;
use Illuminate\Http\Request;
use Mockery as m;

/**
 * Class ItemCommandServiceTest
 */
class ItemCommandServiceTest extends TestCase
{
    /**
     * setup
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * teardown
     */
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    /**
     * @param $class
     *
     * @return m\MockInterface
     */
    public function mock($class)
    {
        $mock = m::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * test store
     */
    public function test_store()
    {

        $testRequest = Request::create('/api/v1/item', 'POST', [
            'label'     => 'testLabel',
            'type'      => 'testType',
            'event'     => 'add',
            'expire_at' => '2099-12-12'
        ]);



        $this->mock = $this->mock('App\Item');

        $this->mock
            ->shouldReceive('newInstance')
            ->once()
            ->andReturn(new Item);


        $service = new ItemCommandService($this->mock);

        $result = $service->store($testRequest);

        $this->assertTrue($result);
    }
}
