<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnagraphicTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnagraphicTable Test Case
 */
class AnagraphicTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AnagraphicTable
     */
    public $Anagraphic;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Anagraphic'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Anagraphic') ? [] : ['className' => AnagraphicTable::class];
        $this->Anagraphic = TableRegistry::getTableLocator()->get('Anagraphic', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Anagraphic);

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
