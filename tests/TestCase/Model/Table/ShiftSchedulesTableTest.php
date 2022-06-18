<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShiftSchedulesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShiftSchedulesTable Test Case
 */
class ShiftSchedulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShiftSchedulesTable
     */
    public $ShiftSchedules;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ShiftSchedules',
        'app.Companies',
        'app.Departments',
        'app.Users',
        'app.Shifts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShiftSchedules') ? [] : ['className' => ShiftSchedulesTable::class];
        $this->ShiftSchedules = TableRegistry::getTableLocator()->get('ShiftSchedules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShiftSchedules);

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
