<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupposttagmembersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupposttagmembersTable Test Case
 */
class GroupposttagmembersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupposttagmembersTable
     */
    public $Groupposttagmembers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupposttagmembers',
        'app.Groups',
        'app.Posts',
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
        $config = TableRegistry::getTableLocator()->exists('Groupposttagmembers') ? [] : ['className' => GroupposttagmembersTable::class];
        $this->Groupposttagmembers = TableRegistry::getTableLocator()->get('Groupposttagmembers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupposttagmembers);

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
