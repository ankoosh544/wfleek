<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChatgroupsusersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChatgroupsusersTable Test Case
 */
class ChatgroupsusersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChatgroupsusersTable
     */
    public $Chatgroupsusers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Chatgroupsusers',
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
        $config = TableRegistry::getTableLocator()->exists('Chatgroupsusers') ? [] : ['className' => ChatgroupsusersTable::class];
        $this->Chatgroupsusers = TableRegistry::getTableLocator()->get('Chatgroupsusers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Chatgroupsusers);

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
