<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EpictasksProjecttasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EpictasksProjecttasksTable Test Case
 */
class EpictasksProjecttasksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EpictasksProjecttasksTable
     */
    public $EpictasksProjecttasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EpictasksProjecttasks',
        'app.Epictasks',
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
        $config = TableRegistry::getTableLocator()->exists('EpictasksProjecttasks') ? [] : ['className' => EpictasksProjecttasksTable::class];
        $this->EpictasksProjecttasks = TableRegistry::getTableLocator()->get('EpictasksProjecttasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EpictasksProjecttasks);

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
