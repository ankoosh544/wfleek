<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupfilesTable Test Case
 */
class GroupfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupfilesTable
     */
    public $Groupfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Groupfiles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Groupfiles') ? [] : ['className' => GroupfilesTable::class];
        $this->Groupfiles = TableRegistry::getTableLocator()->get('Groupfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupfiles);

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
}
