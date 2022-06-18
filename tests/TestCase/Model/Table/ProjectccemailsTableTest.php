<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectccemailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectccemailsTable Test Case
 */
class ProjectccemailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectccemailsTable
     */
    public $Projectccemails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Projectccemails',
        'app.Emails',
        'app.Ccemails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Projectccemails') ? [] : ['className' => ProjectccemailsTable::class];
        $this->Projectccemails = TableRegistry::getTableLocator()->get('Projectccemails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Projectccemails);

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
