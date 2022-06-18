<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseProposalTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseProposalTable Test Case
 */
class CourseProposalTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseProposalTable
     */
    public $CourseProposal;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CourseProposal'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseProposal') ? [] : ['className' => CourseProposalTable::class];
        $this->CourseProposal = TableRegistry::getTableLocator()->get('CourseProposal', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseProposal);

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
