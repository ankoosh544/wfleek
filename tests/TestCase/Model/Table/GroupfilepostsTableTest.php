<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupfilepostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupfilepostsTable Test Case
 */
class GroupfilepostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupfilepostsTable
     */
    public $Groupfileposts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupfileposts',
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
        $config = TableRegistry::getTableLocator()->exists('Groupfileposts') ? [] : ['className' => GroupfilepostsTable::class];
        $this->Groupfileposts = TableRegistry::getTableLocator()->get('Groupfileposts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupfileposts);

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
