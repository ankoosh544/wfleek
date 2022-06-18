<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TaskgroupsProjecttasksFixture
 */
class TaskgroupsProjecttasksFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'taskgroup_id' => ['type' => 'biginteger', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'projecttask_id' => ['type' => 'biginteger', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'projecttask_id' => ['type' => 'index', 'columns' => ['projecttask_id'], 'length' => []],
            'taskgroup_id' => ['type' => 'index', 'columns' => ['taskgroup_id'], 'length' => []],
        ],
        '_constraints' => [
            'taskgroups_projecttasks_ibfk_1' => ['type' => 'foreign', 'columns' => ['projecttask_id'], 'references' => ['projecttasks', 'id'], 'update' => 'setNull', 'delete' => 'setNull', 'length' => []],
            'taskgroups_projecttasks_ibfk_2' => ['type' => 'foreign', 'columns' => ['taskgroup_id'], 'references' => ['taskgroups', 'id'], 'update' => 'setNull', 'delete' => 'setNull', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'taskgroup_id' => 1,
                'projecttask_id' => 1
            ],
        ];
        parent::init();
    }
}
