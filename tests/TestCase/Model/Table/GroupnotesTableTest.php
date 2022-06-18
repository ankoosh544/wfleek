<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupnotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupnotesTable Test Case
 */
class GroupnotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupnotesTable
     */
    public $Groupnotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupnotes',
        'app.Groups',
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
        $config = TableRegistry::getTableLocator()->exists('Groupnotes') ? [] : ['className' => GroupnotesTable::class];
        $this->Groupnotes = TableRegistry::getTableLocator()->get('Groupnotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupnotes);

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
