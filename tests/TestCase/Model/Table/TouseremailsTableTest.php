<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TouseremailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TouseremailsTable Test Case
 */
class TouseremailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TouseremailsTable
     */
    public $Touseremails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Touseremails',
        'app.Projectemail',
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
        $config = TableRegistry::getTableLocator()->exists('Touseremails') ? [] : ['className' => TouseremailsTable::class];
        $this->Touseremails = TableRegistry::getTableLocator()->get('Touseremails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Touseremails);

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
