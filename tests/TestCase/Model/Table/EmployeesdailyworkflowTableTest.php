<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeesdailyworkflowTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeesdailyworkflowTable Test Case
 */
class EmployeesdailyworkflowTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeesdailyworkflowTable
     */
    public $Employeesdailyworkflow;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Employeesdailyworkflow',
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
        $config = TableRegistry::getTableLocator()->exists('Employeesdailyworkflow') ? [] : ['className' => EmployeesdailyworkflowTable::class];
        $this->Employeesdailyworkflow = TableRegistry::getTableLocator()->get('Employeesdailyworkflow', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Employeesdailyworkflow);

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
