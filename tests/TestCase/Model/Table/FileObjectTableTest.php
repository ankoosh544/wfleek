<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FileObjectTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FileObjectTable Test Case
 */
class FileObjectTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FileObjectTable
     */
    public $FileObject;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileObject'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FileObject') ? [] : ['className' => FileObjectTable::class];
        $this->FileObject = TableRegistry::getTableLocator()->get('FileObject', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FileObject);

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
