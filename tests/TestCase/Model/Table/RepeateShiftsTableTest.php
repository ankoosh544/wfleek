<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RepeateShiftsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RepeateShiftsTable Test Case
 */
class RepeateShiftsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RepeateShiftsTable
     */
    public $RepeateShifts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RepeateShifts',
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
        $config = TableRegistry::getTableLocator()->exists('RepeateShifts') ? [] : ['className' => RepeateShiftsTable::class];
        $this->RepeateShifts = TableRegistry::getTableLocator()->get('RepeateShifts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RepeateShifts);

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
