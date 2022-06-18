<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupchatsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupchatsTable Test Case
 */
class GroupchatsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupchatsTable
     */
    public $Groupchats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupchats',
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
        $config = TableRegistry::getTableLocator()->exists('Groupchats') ? [] : ['className' => GroupchatsTable::class];
        $this->Groupchats = TableRegistry::getTableLocator()->get('Groupchats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupchats);

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
