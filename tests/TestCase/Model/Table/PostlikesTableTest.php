<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostlikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostlikesTable Test Case
 */
class PostlikesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PostlikesTable
     */
    public $Postlikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Postlikes',
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
        $config = TableRegistry::getTableLocator()->exists('Postlikes') ? [] : ['className' => PostlikesTable::class];
        $this->Postlikes = TableRegistry::getTableLocator()->get('Postlikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Postlikes);

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
