<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Holiday Entity
 *
 * @property int $id
 * @property string|null $holiday_name
 * @property \Cake\I18n\FrozenTime $holiday_date
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property bool $isDeleted
 */
class Holiday extends Entity
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
        'holiday_name' => true,
        'holiday_date' => true,
        'creation_date' => true,
        'isDeleted' => true
    ];
}
