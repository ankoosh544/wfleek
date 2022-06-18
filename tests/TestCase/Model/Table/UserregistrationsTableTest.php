<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserregistrationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserregistrationsTable Test Case
 */
class UserregistrationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserregistrationsTable
     */
    public $Userregistrations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Userregistrations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Userregistrations') ? [] : ['className' => UserregistrationsTable::class];
        $this->Userregistrations = TableRegistry::getTableLocator()->get('Userregistrations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Userregistrations);

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
