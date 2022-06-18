<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Projecttask Entity
 *
 * @property int $id
 * @property int|null $project_id
 * @property int|null $referred_taskId
 *
 * @property int|null $creatorId
 * @property int|null $assignee_id
 * @property string|null $title
 * @property string|null $description
 * @property float|null $price
 * @property float|null $tax_percentage
 * @property string $status
 * @property string $type
 * @property string|null $category
 * @property bool $isDeleted
 * @property \Cake\I18n\FrozenTime $expiration_date
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property bool $isFuturedTask
 * @property int $status_updatedby
 * @property string|null $priority
 * @property bool $isEpic
 * @property bool $ishaveAnalyst
 *
 */
class Projecttask extends Entity
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
        'project_id' => true,
        'referred_taskId' => true,
        'creatorId' => true,
        'assignee_id' => true,
        'title' => true,
        'description' => true,
        'price' => true,
        'tax_percentage' => true,
        'status' => true,
        'type' => true,
        'category' => true,
        'isDeleted' => true,
        'expiration_date' => true,
        'creation_date' => true,
        'isFuturedTask' => true,
        'status_updatedby' => true,
        'priority' => true,
        'isEpic' => true,
        'ishaveAnalyst' => true
    ];
}
