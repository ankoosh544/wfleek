<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TaskgroupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TaskgroupsTable Test Case
 */
class TaskgroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TaskgroupsTable
     */
    public $Taskgroups;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Taskgroups',
        'app.Projecttasks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Taskgroups') ? [] : ['className' => TaskgroupsTable::class];
        $this->Taskgroups = TableRegistry::getTableLocator()->get('Taskgroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Taskgroups);

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
