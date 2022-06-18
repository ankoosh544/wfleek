<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ECourseTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ECourseTable Test Case
 */
class ECourseTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ECourseTable
     */
    public $ECourse;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ECourse'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ECourse') ? [] : ['className' => ECourseTable::class];
        $this->ECourse = TableRegistry::getTableLocator()->get('ECourse', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ECourse);

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
