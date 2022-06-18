<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PriceTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PriceTable Test Case
 */
class PriceTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PriceTable
     */
    public $Price;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Price'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Price') ? [] : ['className' => PriceTable::class];
        $this->Price = TableRegistry::getTableLocator()->get('Price', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Price);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
