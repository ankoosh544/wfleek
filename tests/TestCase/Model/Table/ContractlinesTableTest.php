<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractlinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractlinesTable Test Case
 */
class ContractlinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractlinesTable
     */
    public $Contractlines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Contractlines',
        'app.Contracts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Contractlines') ? [] : ['className' => ContractlinesTable::class];
        $this->Contractlines = TableRegistry::getTableLocator()->get('Contractlines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contractlines);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
