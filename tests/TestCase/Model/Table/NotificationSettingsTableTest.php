<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotificationSettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotificationSettingsTable Test Case
 */
class NotificationSettingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotificationSettingsTable
     */
    public $NotificationSettings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotificationSettings',
        'app.Companies',
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
        $config = TableRegistry::getTableLocator()->exists('NotificationSettings') ? [] : ['className' => NotificationSettingsTable::class];
        $this->NotificationSettings = TableRegistry::getTableLocator()->get('NotificationSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotificationSettings);

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
