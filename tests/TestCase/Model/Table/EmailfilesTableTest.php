<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailfilesTable Test Case
 */
class EmailfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailfilesTable
     */
    public $Emailfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Emailfiles',
        'app.Fromusers',
        'app.Tousers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Emailfiles') ? [] : ['className' => EmailfilesTable::class];
        $this->Emailfiles = TableRegistry::getTableLocator()->get('Emailfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Emailfiles);

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
