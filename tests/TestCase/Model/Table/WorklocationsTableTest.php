<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorklocationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorklocationsTable Test Case
 */
class WorklocationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorklocationsTable
     */
    public $Worklocations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Worklocations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Worklocations') ? [] : ['className' => WorklocationsTable::class];
        $this->Worklocations = TableRegistry::getTableLocator()->get('Worklocations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Worklocations);

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
