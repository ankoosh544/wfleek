<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupchatfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupchatfilesTable Test Case
 */
class GroupchatfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupchatfilesTable
     */
    public $Groupchatfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupchatfiles',
        'app.Chatgroups',
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
        $config = TableRegistry::getTableLocator()->exists('Groupchatfiles') ? [] : ['className' => GroupchatfilesTable::class];
        $this->Groupchatfiles = TableRegistry::getTableLocator()->get('Groupchatfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupchatfiles);

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
