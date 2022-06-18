<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostcommentlikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostcommentlikesTable Test Case
 */
class PostcommentlikesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PostcommentlikesTable
     */
    public $Postcommentlikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Postcommentlikes',
        'app.Comments',
        'app.Posts',
        'app.Replies',
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
        $config = TableRegistry::getTableLocator()->exists('Postcommentlikes') ? [] : ['className' => PostcommentlikesTable::class];
        $this->Postcommentlikes = TableRegistry::getTableLocator()->get('Postcommentlikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Postcommentlikes);

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
