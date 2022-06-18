<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TaskgroupsProjecttask Entity
 *
 * @property int|null $taskgroup_id
 * @property int|null $projecttask_id
 * @property int|null $project_id
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Taskgroup $taskgroup
 * @property \App\Model\Entity\Projecttask $projecttask
 */
class TaskgroupsProjecttask extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'taskgroup_id' => true,
        'projecttask_id' => true,
        'project_id' => true,
        'isDeleted' => true,
        'taskgroup' => true,
        'projecttask' => true
    ];
}
