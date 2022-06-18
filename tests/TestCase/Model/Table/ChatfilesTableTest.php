<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChatfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChatfilesTable Test Case
 */
class ChatfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChatfilesTable
     */
    public $Chatfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Chatfiles',
        'app.Users',
        'app.Tousers',
        'app.Groups'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Chatfiles') ? [] : ['className' => ChatfilesTable::class];
        $this->Chatfiles = TableRegistry::getTableLocator()->get('Chatfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Chatfiles);

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
