<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Taskuser Entity
 *
 * @property int $id
 * @property int $taskId
 * @property int $assignee_id
 * @property \Cake\I18n\FrozenTime $assigned_date
 *
 * @property \App\Model\Entity\Assignee $assignee
 */
class Taskuser extends Entity
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
        'taskId' => true,
        'assignee_id' => true,
        'assigned_date' => true,
        'assignee' => true
    ];
}
