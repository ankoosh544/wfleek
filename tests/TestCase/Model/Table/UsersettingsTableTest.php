<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersettingsTable Test Case
 */
class UsersettingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersettingsTable
     */
    public $Usersettings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Usersettings',
        'app.Users',
        'app.Companies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Usersettings') ? [] : ['className' => UsersettingsTable::class];
        $this->Usersettings = TableRegistry::getTableLocator()->get('Usersettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Usersettings);

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
