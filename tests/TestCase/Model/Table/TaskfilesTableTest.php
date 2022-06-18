<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TaskfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TaskfilesTable Test Case
 */
class TaskfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TaskfilesTable
     */
    public $Taskfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Taskfiles',
        'app.Comments',
        'app.User'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Taskfiles') ? [] : ['className' => TaskfilesTable::class];
        $this->Taskfiles = TableRegistry::getTableLocator()->get('Taskfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Taskfiles);

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
