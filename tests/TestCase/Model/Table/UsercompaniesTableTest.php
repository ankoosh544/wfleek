<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsercompaniesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsercompaniesTable Test Case
 */
class UsercompaniesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsercompaniesTable
     */
    public $Usercompanies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Usercompanies',
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
        $config = TableRegistry::getTableLocator()->exists('Usercompanies') ? [] : ['className' => UsercompaniesTable::class];
        $this->Usercompanies = TableRegistry::getTableLocator()->get('Usercompanies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Usercompanies);

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
