<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Taskgroup Entity
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property float|null $price
 * @property float|null $tax_percentage
 * @property int|null $total_workinghrs
 * @property \Cake\I18n\FrozenTime|null $last_update
 * @property \Cake\I18n\FrozenTime|null $creation_date
 * @property \Cake\I18n\FrozenTime|null $startdate
 * @property \Cake\I18n\FrozenTime|null $expirydate
 * @property bool|null $isFuturedGroup
 *
 * @property \App\Model\Entity\Projecttask[] $projecttasks
 */
class Taskgroup extends Entity
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
        'title' => true,
        'description' => true,
        'price' => true,
        'tax_percentage' => true,
        'total_workinghrs' => true,
        'last_update' => true,
        'creation_date' => true,
        'startdate' => true,
        'expirydate' => true,
        'projecttasks' => true,
        'isFuturedGroup' => true,

    ];
}
