<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FavoritepostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FavoritepostsTable Test Case
 */
class FavoritepostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FavoritepostsTable
     */
    public $Favoriteposts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Favoriteposts',
        'app.Users',
        'app.Posts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Favoriteposts') ? [] : ['className' => FavoritepostsTable::class];
        $this->Favoriteposts = TableRegistry::getTableLocator()->get('Favoriteposts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Favoriteposts);

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
