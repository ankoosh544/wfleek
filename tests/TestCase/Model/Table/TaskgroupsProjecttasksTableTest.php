<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TaskgroupsProjecttasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TaskgroupsProjecttasksTable Test Case
 */
class TaskgroupsProjecttasksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TaskgroupsProjecttasksTable
     */
    public $TaskgroupsProjecttasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TaskgroupsProjecttasks',
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
        $config = TableRegistry::getTableLocator()->exists('TaskgroupsProjecttasks') ? [] : ['className' => TaskgroupsProjecttasksTable::class];
        $this->TaskgroupsProjecttasks = TableRegistry::getTableLocator()->get('TaskgroupsProjecttasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TaskgroupsProjecttasks);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
