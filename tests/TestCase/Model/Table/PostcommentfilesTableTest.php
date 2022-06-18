<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostcommentfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostcommentfilesTable Test Case
 */
class PostcommentfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PostcommentfilesTable
     */
    public $Postcommentfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Postcommentfiles',
        'app.Posts',
        'app.Comments',
        'app.Groups',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Postcommentfiles') ? [] : ['className' => PostcommentfilesTable::class];
        $this->Postcommentfiles = TableRegistry::getTableLocator()->get('Postcommentfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Postcommentfiles);

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
