<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TaskusersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TaskusersTable Test Case
 */
class TaskusersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TaskusersTable
     */
    public $Taskusers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Taskusers',
        'app.Assignees'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Taskusers') ? [] : ['className' => TaskusersTable::class];
        $this->Taskusers = TableRegistry::getTableLocator()->get('Taskusers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Taskusers);

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
