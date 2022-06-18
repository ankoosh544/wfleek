<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsermodulePermissionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsermodulePermissionsTable Test Case
 */
class UsermodulePermissionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsermodulePermissionsTable
     */
    public $UsermodulePermissions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UsermodulePermissions',
        'app.Designations',
        'app.Modules'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UsermodulePermissions') ? [] : ['className' => UsermodulePermissionsTable::class];
        $this->UsermodulePermissions = TableRegistry::getTableLocator()->get('UsermodulePermissions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsermodulePermissions);

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
