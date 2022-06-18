<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdditionaldatausersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdditionaldatausersTable Test Case
 */
class AdditionaldatausersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdditionaldatausersTable
     */
    public $Additionaldatausers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Additionaldatausers',
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
        $config = TableRegistry::getTableLocator()->exists('Additionaldatausers') ? [] : ['className' => AdditionaldatausersTable::class];
        $this->Additionaldatausers = TableRegistry::getTableLocator()->get('Additionaldatausers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Additionaldatausers);

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
