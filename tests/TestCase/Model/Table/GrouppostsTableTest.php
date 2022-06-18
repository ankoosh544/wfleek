<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GrouppostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GrouppostsTable Test Case
 */
class GrouppostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GrouppostsTable
     */
    public $Groupposts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupposts',
        'app.Grouppostfiles',
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
        $config = TableRegistry::getTableLocator()->exists('Groupposts') ? [] : ['className' => GrouppostsTable::class];
        $this->Groupposts = TableRegistry::getTableLocator()->get('Groupposts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupposts);

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
