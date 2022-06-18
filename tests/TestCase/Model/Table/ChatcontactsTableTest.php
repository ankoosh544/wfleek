<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChatcontactsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChatcontactsTable Test Case
 */
class ChatcontactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChatcontactsTable
     */
    public $Chatcontacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Chatcontacts',
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
        $config = TableRegistry::getTableLocator()->exists('Chatcontacts') ? [] : ['className' => ChatcontactsTable::class];
        $this->Chatcontacts = TableRegistry::getTableLocator()->get('Chatcontacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Chatcontacts);

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
