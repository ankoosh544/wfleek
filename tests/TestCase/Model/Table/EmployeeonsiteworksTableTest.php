<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeonsiteworksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeonsiteworksTable Test Case
 */
class EmployeeonsiteworksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeonsiteworksTable
     */
    public $Employeeonsiteworks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Employeeonsiteworks',
        'app.Clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Employeeonsiteworks') ? [] : ['className' => EmployeeonsiteworksTable::class];
        $this->Employeeonsiteworks = TableRegistry::getTableLocator()->get('Employeeonsiteworks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Employeeonsiteworks);

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
