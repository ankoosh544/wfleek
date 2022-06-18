<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupmembersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupmembersTable Test Case
 */
class GroupmembersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupmembersTable
     */
    public $Groupmembers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupmembers',
        'app.Groups',
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
        $config = TableRegistry::getTableLocator()->exists('Groupmembers') ? [] : ['className' => GroupmembersTable::class];
        $this->Groupmembers = TableRegistry::getTableLocator()->get('Groupmembers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupmembers);

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
