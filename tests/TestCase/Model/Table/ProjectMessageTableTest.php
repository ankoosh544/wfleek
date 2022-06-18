<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectMessageTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectMessageTable Test Case
 */
class ProjectMessageTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectMessageTable
     */
    public $ProjectMessage;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProjectMessage'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProjectMessage') ? [] : ['className' => ProjectMessageTable::class];
        $this->ProjectMessage = TableRegistry::getTableLocator()->get('ProjectMessage', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectMessage);

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
