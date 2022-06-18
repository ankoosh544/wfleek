<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Worklocation Entity
 *
 * @property int $id
 * @property string|null $work_location
 * @property string|null $work_address
 * @property bool $isDeleted
 */
class Worklocation extends Entity
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
        'work_location' => true,
        'work_address' => true,
        'isDeleted' => true
    ];
}
