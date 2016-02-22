<?php

use App\Item;
use App\Services\ItemQueryService;
use Mockery as m;

/**
 * Class ItemQueryServiceTest
 */
class ItemQueryServiceTest extends TestCase
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
     * test get all items
     */
    public function test_get_all()
    {

        $this->mock = $this->mock('App\Item');
        $this->mock->shouldReceive('orderBy->get')->andReturn(true);

        $service = new ItemQueryService($this->mock);

        $result = $service->getAll();

        $this->assertTrue($result);
    }

    /**
     * test get all active items
     */
    public function test_get()
    {

        $testCollection        = new \Illuminate\Database\Eloquent\Collection();
        $testEntry1            = new Item();
        $testEntry1->event     = "add";
        $testEntry1->itemID    = "1";
        $testEntry1->label     = "1st";
        $testEntry1->expire_at = "2099-12-12";

        $testEntry2            = new Item();
        $testEntry2->event     = "add";
        $testEntry2->itemID    = "2";
        $testEntry2->label     = "2nd";
        $testEntry2->expire_at = "2099-12-12";

        $testEntry3            = new Item();
        $testEntry3->event     = "remove";
        $testEntry3->itemID    = "2";
        $testEntry3->label     = "";
        $testEntry3->expire_at = "2099-12-12";

        $testCollection->add($testEntry1);
        $testCollection->add($testEntry2);
        $testCollection->add($testEntry3);

        $this->mock = $this->mock('App\Item');
        $this->mock->shouldReceive('orderBy->get')->andReturn($testCollection);

        $service = new ItemQueryService($this->mock);

        $result = $service->get();

        $this->assertInternalType('array', $result);
        $this->assertEquals(1, count($result));
    }

}
