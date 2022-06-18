<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EpictasksProjecttask Entity
 *
 * @property int $epictask_id
 * @property int $projecttask_id
 * @property int $projectId
 * @property bool $isDeleted
 *
 * @property \App\Model\Entity\Epictask $epictask
 * @property \App\Model\Entity\Projecttask $projecttask
 */
class EpictasksProjecttask extends Entity
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
        'projectId' => true,
        'isDeleted' => true,
        'epictask' => true,
        'projecttask' => true
    ];
}
