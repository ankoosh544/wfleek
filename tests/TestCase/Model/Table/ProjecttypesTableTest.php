<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjecttypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjecttypesTable Test Case
 */
class ProjecttypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjecttypesTable
     */
    public $Projecttypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Projecttypes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Projecttypes') ? [] : ['className' => ProjecttypesTable::class];
        $this->Projecttypes = TableRegistry::getTableLocator()->get('Projecttypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Projecttypes);

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
