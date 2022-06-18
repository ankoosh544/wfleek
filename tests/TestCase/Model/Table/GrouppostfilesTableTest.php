<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GrouppostfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GrouppostfilesTable Test Case
 */
class GrouppostfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GrouppostfilesTable
     */
    public $Grouppostfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Grouppostfiles',
        'app.Groups',
        'app.Groupposts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Grouppostfiles') ? [] : ['className' => GrouppostfilesTable::class];
        $this->Grouppostfiles = TableRegistry::getTableLocator()->get('Grouppostfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Grouppostfiles);

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
