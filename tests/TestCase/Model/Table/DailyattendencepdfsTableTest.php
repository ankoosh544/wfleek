<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DailyattendencepdfsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DailyattendencepdfsTable Test Case
 */
class DailyattendencepdfsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DailyattendencepdfsTable
     */
    public $Dailyattendencepdfs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Dailyattendencepdfs',
        'app.Companies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Dailyattendencepdfs') ? [] : ['className' => DailyattendencepdfsTable::class];
        $this->Dailyattendencepdfs = TableRegistry::getTableLocator()->get('Dailyattendencepdfs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dailyattendencepdfs);

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
