<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientsexpenditureTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientsexpenditureTable Test Case
 */
class ClientsexpenditureTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientsexpenditureTable
     */
    public $Clientsexpenditure;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Clientsexpenditure',
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
        $config = TableRegistry::getTableLocator()->exists('Clientsexpenditure') ? [] : ['className' => ClientsexpenditureTable::class];
        $this->Clientsexpenditure = TableRegistry::getTableLocator()->get('Clientsexpenditure', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Clientsexpenditure);

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
