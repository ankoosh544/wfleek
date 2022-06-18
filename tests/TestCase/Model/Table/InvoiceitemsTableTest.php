<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoiceitemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoiceitemsTable Test Case
 */
class InvoiceitemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvoiceitemsTable
     */
    public $Invoiceitems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Invoiceitems',
        'app.Taskgroups'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Invoiceitems') ? [] : ['className' => InvoiceitemsTable::class];
        $this->Invoiceitems = TableRegistry::getTableLocator()->get('Invoiceitems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Invoiceitems);

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
