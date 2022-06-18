<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FuturetaskgroupTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FuturetaskgroupTable Test Case
 */
class FuturetaskgroupTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FuturetaskgroupTable
     */
    public $Futuretaskgroup;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Futuretaskgroup'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Futuretaskgroup') ? [] : ['className' => FuturetaskgroupTable::class];
        $this->Futuretaskgroup = TableRegistry::getTableLocator()->get('Futuretaskgroup', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Futuretaskgroup);

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
