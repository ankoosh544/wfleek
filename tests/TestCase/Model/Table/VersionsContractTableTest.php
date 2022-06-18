<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VersionsContractTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VersionsContractTable Test Case
 */
class VersionsContractTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VersionsContractTable
     */
    public $VersionsContract;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VersionsContract',
        'app.ProjectObjects',
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
        $config = TableRegistry::getTableLocator()->exists('VersionsContract') ? [] : ['className' => VersionsContractTable::class];
        $this->VersionsContract = TableRegistry::getTableLocator()->get('VersionsContract', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VersionsContract);

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
