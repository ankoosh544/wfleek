<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectObjectTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectObjectTable Test Case
 */
class ProjectObjectTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectObjectTable
     */
    public $ProjectObject;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProjectObject'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProjectObject') ? [] : ['className' => ProjectObjectTable::class];
        $this->ProjectObject = TableRegistry::getTableLocator()->get('ProjectObject', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectObject);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
