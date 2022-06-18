<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserbanksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserbanksTable Test Case
 */
class UserbanksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserbanksTable
     */
    public $Userbanks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Userbanks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Userbanks') ? [] : ['className' => UserbanksTable::class];
        $this->Userbanks = TableRegistry::getTableLocator()->get('Userbanks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Userbanks);

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
