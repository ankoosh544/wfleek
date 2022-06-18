<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectbccemailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectbccemailsTable Test Case
 */
class ProjectbccemailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectbccemailsTable
     */
    public $Projectbccemails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Projectbccemails',
        'app.Emails',
        'app.Bccusers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Projectbccemails') ? [] : ['className' => ProjectbccemailsTable::class];
        $this->Projectbccemails = TableRegistry::getTableLocator()->get('Projectbccemails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Projectbccemails);

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
