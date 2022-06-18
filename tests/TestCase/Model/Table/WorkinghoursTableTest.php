<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkinghoursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkinghoursTable Test Case
 */
class WorkinghoursTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkinghoursTable
     */
    public $Workinghours;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Workinghours',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Workinghours') ? [] : ['className' => WorkinghoursTable::class];
        $this->Workinghours = TableRegistry::getTableLocator()->get('Workinghours', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Workinghours);

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
