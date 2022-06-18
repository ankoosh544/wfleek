<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostcommentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostcommentsTable Test Case
 */
class PostcommentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PostcommentsTable
     */
    public $Postcomments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Postcomments',
        'app.Groups',
        'app.Posts',
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
        $config = TableRegistry::getTableLocator()->exists('Postcomments') ? [] : ['className' => PostcommentsTable::class];
        $this->Postcomments = TableRegistry::getTableLocator()->get('Postcomments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Postcomments);

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
