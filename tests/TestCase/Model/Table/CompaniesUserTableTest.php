<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompaniesUserTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompaniesUserTable Test Case
 */
class CompaniesUserTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompaniesUserTable
     */
    public $CompaniesUser;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CompaniesUser',
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
        $config = TableRegistry::getTableLocator()->exists('CompaniesUser') ? [] : ['className' => CompaniesUserTable::class];
        $this->CompaniesUser = TableRegistry::getTableLocator()->get('CompaniesUser', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CompaniesUser);

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
