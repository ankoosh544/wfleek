<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModulePermissionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModulePermissionsTable Test Case
 */
class ModulePermissionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ModulePermissionsTable
     */
    public $ModulePermissions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ModulePermissions',
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
        $config = TableRegistry::getTableLocator()->exists('ModulePermissions') ? [] : ['className' => ModulePermissionsTable::class];
        $this->ModulePermissions = TableRegistry::getTableLocator()->get('ModulePermissions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModulePermissions);

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
