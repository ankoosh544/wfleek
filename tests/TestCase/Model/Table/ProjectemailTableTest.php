<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectemailTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectemailTable Test Case
 */
class ProjectemailTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectemailTable
     */
    public $Projectemail;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Projectemail'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Projectemail') ? [] : ['className' => ProjectemailTable::class];
        $this->Projectemail = TableRegistry::getTableLocator()->get('Projectemail', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Projectemail);

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
